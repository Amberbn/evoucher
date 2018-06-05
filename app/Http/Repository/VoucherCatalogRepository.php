<?php
namespace App\Http\Repository;

use App\Repository\BaseRepository;
use App\VoucherCatalog;
use App\VoucherCatalogOutlet;
use App\StockTransaction;
use DB;

class VoucherCatalogRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new VoucherCatalog();
    }

    public function voucherCatalogFilter()
    {
        $filter = [
            'orderBy' => 'voucher_catalog_sku_code',
            'filter_1' => 'voucher_catalog_title',
            'filter_2' => 'voucher_catalog_instruction_customer',
            'filter_3' => 'voucher_catalog_information',
        ];

        return $filter;
    }

    public function getAllVoucherCatalog()
    {
        $voucherCatalogs = DB::table('vou_voucher_catalog as cat')
            ->join('bsn_client as bc', 'cat.merchant_client_id', '=', 'bc.client_id')
            ->where('cat.isdelete', false);

        if (!$this->isGroupSprint()) {
            $voucherCatalogs->where('bc.client_category_pid', '=', $this->me()['client_category_pid']);
        }

        $voucherCatalogs->select(
            'cat.voucher_catalog_id',
            'cat.voucher_catalog_revision_no',
            'cat.merchant_client_id',
            'bc.client_name',
            'cat.voucher_catalog_sku_code',
            'cat.voucher_catalog_title',
            'cat.voucher_catalog_main_image_url',
            'cat.voucher_catalog_information',
            'cat.voucher_catalog_terms_and_condition',
            'cat.voucher_catalog_instruction_customer',
            'cat.voucher_catalog_instruction_outlet',
            'cat.voucher_catalog_valid_start_date',
            'cat.voucher_catalog_valid_end_date',
            'cat.voucher_catalog_tags',
            'cat.voucher_catalog_value_amount',
            'cat.voucher_catalog_value_point',
            'cat.voucher_catalog_unit_price_amount',
            'cat.voucher_catalog_unit_price_point',
            'cat.voucher_catalog_stock_level',
            'cat.voucher_status',
            'cat.data_sort',
            'cat.isactive',
            'cat.isdelete',
            'cat.created_by_user_name',
            'cat.last_updated_by_user_name'
        );
    
        if (empty($voucherCatalogs->get()->toArray())) {
            return $this->sendNotfound();
        }
        $filter = $this->voucherCatalogFilter();

        return $this->dataTableResponseBuilder($voucherCatalogs, $filter);
    }

    public function saveVoucherCatalog($request)
    {
        $stockTransactionInitialStockLevel = 0;
        $voucherCatalogStockLevel = request('voucher_catalog_stock_level');
        $stockTransactionInitialStockLevel = $voucherCatalogStockLevel;

        $randomNum = substr(str_shuffle("0123456789"), 0, 4);
        $result = $randomNum. "-" .$randomNum;

        DB::beginTransaction();
        try {
            $voucherCatalog = new VoucherCatalog;
            $voucherCatalog->voucher_catalog_revision_no = 0;
            $voucherCatalog->merchant_client_id = $request->input('merchant_client_id');
            $voucherCatalog->voucher_catalog_sku_code = $result;
            $voucherCatalog->voucher_catalog_title = $request->input('voucher_catalog_title');
            $voucherCatalog->voucher_catalog_main_image_url = $request->input('voucher_catalog_main_image_url');
            $voucherCatalog->voucher_catalog_information = $request->input('voucher_catalog_information');
            $voucherCatalog->voucher_catalog_terms_and_condition = $request->input('voucher_catalog_terms_and_condition');
            $voucherCatalog->voucher_catalog_instruction_customer = $request->input('voucher_catalog_instruction_customer');
            $voucherCatalog->voucher_catalog_instruction_outlet = $request->input('voucher_catalog_instruction_outlet');
            $voucherCatalog->voucher_catalog_valid_start_date = $request->input('voucher_catalog_valid_start_date');
            $voucherCatalog->voucher_catalog_valid_end_date = $request->input('voucher_catalog_valid_end_date');
            $voucherCatalog->voucher_catalog_tags = $request->input('voucher_catalog_tags');
            $voucherCatalog->voucher_catalog_unit_cogs_amount = $request->input('voucher_catalog_unit_cogs_amount');
            $voucherCatalog->voucher_catalog_value_amount = $request->input('voucher_catalog_value_amount');
            $voucherCatalog->voucher_catalog_value_point = $request->input('voucher_catalog_value_point');
            $voucherCatalog->voucher_catalog_unit_price_amount = $request->input('voucher_catalog_unit_price_amount');
            $voucherCatalog->voucher_catalog_unit_price_point = $request->input('voucher_catalog_unit_price_point');
            $voucherCatalog->voucher_catalog_stock_level = $request->input('voucher_catalog_stock_level');
            $voucherCatalog->voucher_status = 'DRAFT';
            $voucherCatalog->data_sort = $request->input('data_sort') ? : 1000;
            $voucherCatalog->isactive = $request->input('isactive') ? : true;
            $voucherCatalog->isdelete = $request->input('isdelete') ? : false;
            $voucherCatalog->created_by_user_name = $this->loginUsername();
            $voucherCatalog->last_updated_by_user_name = $this->loginUsername();
            $voucherCatalog->save();

            $stockTransaction = new StockTransaction;
            $stockTransaction->voucher_catalog_id = $voucherCatalog->voucher_catalog_id;
            $stockTransaction->stock_transaction_adjustment_type = 'EDIT';
            $stockTransaction->campaign_id = $request->input('campaign_id') ? : null;
            $stockTransaction->stock_transaction_initial_stock_level = $stockTransactionInitialStockLevel;
            $stockTransaction->stock_transaction_adjustment_value = 0; 
            $stockTransaction->stock_transaction_adjusted_stock_level = 0;
            $stockTransaction->created_at = NOW();
            $stockTransaction->created_by_user_name = $this->loginUsername();
            $stockTransaction->save();
            
            DB::commit();

            return $this->sendCreated($voucherCatalog);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendBadRequest($e->getMessage());
        }        
    }

    public function updateVoucherCatalog($request, $id)
    {
        $voucherCatalog = VoucherCatalog::find($id);
// dd($voucherCatalog);
        $version = $voucherCatalog->voucher_catalog_revision_no += 1;

        DB::beginTransaction();
        try {
            $voucherCatalog->voucher_catalog_revision_no = $version;
            $voucherCatalog->merchant_client_id = $request->input('merchant_client_id');
            $voucherCatalog->voucher_catalog_title = $request->input('voucher_catalog_title');
            $voucherCatalog->voucher_catalog_main_image_url = $request->input('voucher_catalog_main_image_url');
            $voucherCatalog->voucher_catalog_information = $request->input('voucher_catalog_information');
            $voucherCatalog->voucher_catalog_terms_and_condition = $request->input('voucher_catalog_terms_and_condition');
            $voucherCatalog->voucher_catalog_instruction_customer = $request->input('voucher_catalog_instruction_customer');
            $voucherCatalog->voucher_catalog_instruction_outlet = $request->input('voucher_catalog_instruction_outlet');
            $voucherCatalog->voucher_catalog_valid_start_date = $request->input('voucher_catalog_valid_start_date');
            $voucherCatalog->voucher_catalog_valid_end_date = $request->input('voucher_catalog_valid_end_date');
            $voucherCatalog->voucher_catalog_tags = $request->input('voucher_catalog_tags');
            $voucherCatalog->voucher_catalog_unit_cogs_amount = $request->input('voucher_catalog_unit_cogs_amount');
            $voucherCatalog->voucher_catalog_value_amount = $request->input('voucher_catalog_value_amount');
            $voucherCatalog->voucher_catalog_value_point = $request->input('voucher_catalog_value_point');
            $voucherCatalog->voucher_catalog_unit_price_amount = $request->input('voucher_catalog_unit_price_amount');
            $voucherCatalog->voucher_catalog_unit_price_point = $request->input('voucher_catalog_unit_price_point');
            $voucherCatalog->voucher_catalog_stock_level = $request->input('voucher_catalog_stock_level');
            $voucherCatalog->voucher_status = 'DRAFT';
            $voucherCatalog->data_sort = $request->input('data_sort') ? : 1000;
            $voucherCatalog->isactive = $request->input('isactive') ? : true;
            $voucherCatalog->isdelete = $request->input('isdelete') ? : false;
            $voucherCatalog->created_by_user_name = $this->loginUsername();
            $voucherCatalog->last_updated_by_user_name = $this->loginUsername();
            $voucherCatalog->update();

            $transaction = $this->stockTransaction($voucherCatalog->voucher_catalog_id,'EDIT',null,$request->input('voucher_catalog_stock_level'));
        
            DB::commit();

            return $this->sendCreated($voucherCatalog);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendBadRequest($e->getMessage());
        }        
    }

    //function for transaction
    public function stockTransaction($catalogId, $from, $campaignID=null, $adjustedStock = 0)
    {
        $stockTransactionInitialStockLevel = 0;
        $stockTransactionAdjustmentValue = 0;
        $difference = 0;

        $query = VoucherCatalog::find($catalogId);
 
        $stockTransactionInitialStockLevel = $query->voucher_catalog_stock_level;
       
        if($stockTransactionInitialStockLevel > $adjustedStock) {
            $stockTransactionAdjustmentValue = $adjustedStock - $stockTransactionInitialStockLevel;
            $difference = $stockTransactionInitialStockLevel - $adjustedStock;
            $difference = -1 * abs($difference);
        }
        
        if($stockTransactionInitialStockLevel < $adjustedStock) {
            $stockTransactionAdjustmentValue = $adjustedStock + $stockTransactionInitialStockLevel;
            $difference = ($adjustedStock - $stockTransactionInitialStockLevel);
        }

        if($stockTransactionInitialStockLevel != $adjustedStock) {
            $stockTransaction = new StockTransaction;
            $stockTransaction->voucher_catalog_id = $query->voucher_catalog_id;
            $stockTransaction->stock_transaction_adjustment_type =  $from;
            $stockTransaction->campaign_id = $campaignID;
            $stockTransaction->stock_transaction_initial_stock_level = $stockTransactionInitialStockLevel;
            $stockTransaction->stock_transaction_adjustment_value = $difference; 
            $stockTransaction->stock_transaction_adjusted_stock_level = $adjustedStock;
            $stockTransaction->created_at = NOW();
            $stockTransaction->created_by_user_name = $this->loginUsername();
            $stockTransaction->save();
        
            return $stockTransaction;
        }
        
        
    }
}
 