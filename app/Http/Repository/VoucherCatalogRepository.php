<?php
namespace App\Http\Repository;

use DB;
use App\Outlet;
use Carbon\Carbon;
use App\VoucherCatalog;
use App\StockTransaction;
use App\VoucherCatalogOutlet;
use App\Repository\BaseRepository;

class VoucherCatalogRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new VoucherCatalog();
        $this->catalogOutlet = new VoucherCatalogOutlet;
        $this->outlet = new Outlet;
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

    public function getAllVoucherCatalog($voucherId = null)
    {
        $voucherCatalogs = DB::table('vou_voucher_catalog as cat')
            ->join('bsn_client as bc', 'cat.merchant_client_id', '=', 'bc.client_id')
            ->where('cat.isdelete', false);

        if (!$this->isGroupSprint()) {
            $voucherCatalogs->where('bc.client_category_pid', '=', $this->me()['client_category_pid']);
        }
        if ($voucherId) {
            $voucherCatalogs->where('cat.voucher_catalog_id','=',$voucherId);
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

    public function voucherCatalogDatatable($voucherId = null)
    {
        $voucherCatalogs = DB::table('vou_voucher_catalog as cat')
            ->join('bsn_client as bc', 'cat.merchant_client_id', '=', 'bc.client_id')
            ->join('frm_global_parameters as gp', 'gp.parameters_id', '=', 'cat.voucher_catalog_category_pid')
            ->where('cat.isdelete', false)
            ->where('cat.voucher_catalog_valid_end_date', '>', date('Y-m-d h:i:s'));

        if (!$this->isGroupSprint()) {
            $voucherCatalogs->where('bc.client_category_pid', '=', $this->me()['client_category_pid']);
        }
        if ($voucherId) {
            $voucherCatalogs->where('cat.voucher_catalog_id', '=', $voucherId);
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
            'cat.last_updated_by_user_name',
            'gp.parameters_value as voucher_category_pid_title'
        );

        if (empty($voucherCatalogs->get()->toArray())) {
            return $this->sendNotfound();
        }
        $vouchers = $voucherCatalogs->get();

        $voucherOutlet = DB::table('vou_voucher_catalog_outlets as vco')
            ->join('mch_outlets as out', 'out.outlets_id', '=', 'vco.outlets_id')
            ->join('frm_global_parameters as prov', function ($join) {
                $join
                    ->on('prov.parameters_id', '=', 'out.outlets_address_province_pid')
                    ->where('prov.parameters_type', '=', 'address_state_province');
            })
            ->join('frm_global_parameters as city', function ($join) {
                $join
                    ->on('city.parameters_id', '=', 'out.outlets_address_city_pid')
                    ->where('city.parameters_type', '=', 'address_city');
            })
            ->join('frm_global_parameters as region', function ($join) {
                $join
                    ->on('region.parameters_id', '=', 'out.outlets_address_region_pid')
                    ->where('region.parameters_type', '=', 'address_region');
            })->select([
                'vco.voucher_catalog_id',
                'out.outlets_title',
                'out.outlets_address_line',
                'prov.parameters_value as address_state_province_title',
                'city.parameters_value as address_city_title',
                'region.parameters_value as address_region_title'
            ])
            ->get();

        $voucherArray = [];
        foreach($vouchers as $voucher) {
            $catId = $voucher->voucher_catalog_id;

            $voucherArray[$catId]['voucher_catalog_id'] = $voucher->voucher_catalog_id;
            $voucherArray[$catId]['client_name'] = $voucher->client_name;
            $voucherArray[$catId]['voucher_catalog_title'] = $voucher->voucher_catalog_title;
            $voucherArray[$catId]['voucher_catalog_main_image_url'] = $voucher->voucher_catalog_main_image_url;
            $voucherArray[$catId]['voucher_catalog_valid_start_date'] = $voucher->voucher_catalog_valid_start_date;
            $voucherArray[$catId]['voucher_catalog_valid_end_date'] = $voucher->voucher_catalog_valid_end_date;
            $voucherArray[$catId]['voucher_catalog_tags'] = $voucher->voucher_catalog_tags;
            $voucherArray[$catId]['voucher_catalog_value_amount'] = $voucher->voucher_catalog_value_amount;
            $voucherArray[$catId]['voucher_catalog_value_point'] = $voucher->voucher_catalog_value_point;
            $voucherArray[$catId]['voucher_catalog_unit_price_amount'] = $voucher->voucher_catalog_unit_price_amount;
            $voucherArray[$catId]['voucher_catalog_unit_price_point'] = $voucher->voucher_catalog_unit_price_point;
            $voucherArray[$catId]['voucher_category_pid_title'] = $voucher->voucher_category_pid_title;

            $voucherOutletsCollection = $voucherOutlet->where('voucher_catalog_id', $voucher->voucher_catalog_id);

            $location = null;
            $area = null;
            $province = null;
            $city = null;
            $region = null;
            foreach($voucherOutletsCollection as $outlet) {
                $location .= $outlet->outlets_title.' , '; 
                $area .=  $outlet->outlets_address_line . ' , ';
                $province .= $outlet->address_state_province_title . ' , ';
                $city .= $outlet->address_city_title . ' , ';
                $region .= $outlet->address_region_title . ' , ';
            }

            $oneMonth = Carbon::now()->addMonth(1);
            $twoMonth = Carbon::now()->addMonth(2);
            $sixMonth = Carbon::now()->addMonth(6);
            $oneYear = Carbon::now()->addYear();

            $endDate = Carbon::parse($voucher->voucher_catalog_valid_end_date);

            $filterDate = null;
            if($endDate > $oneYear) {
                $filterDate = 'more than 1 year';
            }elseif($endDate > $sixMonth) {
                $filterDate = 'more than 6 month';
            }elseif($endDate > $twoMonth){
                $filterDate = 'more than 2 month';
            } elseif ($endDate > $oneMonth) {
                $filterDate = 'more than 1 month';
            }

            $voucherArray[$catId]['outlet_location'] = $location;
            $voucherArray[$catId]['outlet_area'] = $area;
            $voucherArray[$catId]['province'] = $province;
            $voucherArray[$catId]['city'] = $city;
            $voucherArray[$catId]['region'] = $region;
            $voucherArray[$catId]['voucher_expiration'] = $filterDate;

        }
        $vouchersCollection = collect($voucherArray);

        return $this->sendSuccess($vouchersCollection);
    }

    public function saveVoucherMerchant($request,$voucherCatalogId)
    {
        DB::beginTransaction();
        try {
            
            $getVoucherCatalog = $this->model
                ->where('voucher_catalog_id', $voucherCatalogId)
                ->first();
    
            if(!$getVoucherCatalog) {
                return $this->sendNotfound();
            }

            $voucherCatalogId = $getVoucherCatalog->voucher_catalog_id;
            $savedCatalogOutlet = [];
            $voucherRequest = $request->input('voucher');
            foreach ($voucherRequest as $voucher) {
                $redemAllOutlet = $voucher['redem_all_outlet'] == 'true' ? true : false;
                $merchantId = $voucher['merchant_id'];

                if (!$redemAllOutlet && isset($voucher['add_outlet'])) {
                    foreach ($voucher['add_outlet'] as $outletId) {
                       $catalogOutlet = $this->saveVoucherCatalogOutlet($voucherCatalogId ,$outletId, $merchantId);
                       $savedCatalogOutlet[] = $catalogOutlet->toArray();
                    }
                } else if(!$redemAllOutlet && isset($voucher['exclude_outlet'])) {
                    $outlets = $this->getOutletByMerchantId($merchantId, $voucher['exclude_outlet']);
                    
                    if(!$outlets) {
                        continue;
                    }

                    foreach($outlets as $outlet) {
                        $outletId = $outlet->outlets_id;
                        $catalogOutlet = $this->saveVoucherCatalogOutlet($voucherCatalogId ,$outletId, $merchantId);
                        $savedCatalogOutlet[] = $catalogOutlet->toArray();
                    }

                } else if($redemAllOutlet) {
                    $outlets = $this->getOutletByMerchantId($merchantId);

                    if (!$outlets) {
                        continue;
                    }

                    foreach ($outlets as $outlet) {
                        $outletId = $outlet->outlets_id;
                        $catalogOutlet = $this->saveVoucherCatalogOutlet($voucherCatalogId ,$outletId, $merchantId);
                        $savedCatalogOutlet[] = $catalogOutlet->toArray();
                    }
                } else {
                    continue;
                }
            }

            $voucherCatalog = $this->model
                ->where('voucher_catalog_id', $voucherCatalogId)
                ->first();
            $voucherCatalog->isactive = true;
            $voucherCatalog->voucher_status = "RELEASED";
            $voucherCatalog->save();

            DB::commit();

            return $this->sendCreated($savedCatalogOutlet);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->throwErrorException($e);
        }
        
    }

    public function saveVoucherCatalogOutlet($voucherCatalogId ,$outletId, $merchantId)
    {
        $catalogOutlet = new VoucherCatalogOutlet;
        $catalogOutlet->voucher_catalog_id = $voucherCatalogId;
        $catalogOutlet->outlets_id = $outletId;
        $catalogOutlet->merchant_id = $merchantId;
        $catalogOutlet->created_by_user_name = $this->loginUsername();
        $catalogOutlet->created_at = NOW();
        $catalogOutlet->save();
        return $catalogOutlet;
    }

    public function getOutletByMerchantId($merchantId,$noIn = null)
    {
        $outlets = $this->outlet::where('merchant_id', $merchantId)
            ->where('isactive', true)
            ->where('isdelete', false);
            if($noIn) {
                $outlets = $outlets->whereNotIn('outlets_id', $noIn);
            }
        return $outlets->get();
    }

    public function getVoucherDraftById($voucherId)
    {
        $voucherCatalogs = $this->model
            ->where('voucher_catalog_id','=',$voucherId)
            ->where('isactive',false)
            ->where('voucher_status','=','DRAFT');
        if (empty($voucherCatalogs->get()->toArray())) {
            return $this->sendNotfound();
        }
        return $this->sendSuccess($voucherCatalogs->first());
    }

    public function getVoucherCatalogTags()
    {
        $tags = DB::table('vw_voucher_catalog_tags')->get();
        if (empty($tags->toArray())) {
            return $this->sendNotfound();
        }
        return $this->sendSuccess($tags);
    }

    public function createVoucherProfile($request)
    {
        $randomNum = substr(str_shuffle("0123456789"), 0, 4);
        $result = $randomNum . "-" . $randomNum;
        $tags = implode(',',$request->voucher_catalog_tags);
        DB::beginTransaction();
        try {

            $filename = null;
            if ($request->voucher_catalog_main_image_url) {
                $filename = $this->saveImage($request, 'voucher_catalog_main_image_url', 'voucher');
            }

            $voucherCatalog = new VoucherCatalog;
            $voucherCatalog->voucher_catalog_revision_no = 0;
            $voucherCatalog->merchant_client_id = $request->input('merchant_client_id') ?: $this->me()['client_id'];
            $voucherCatalog->voucher_catalog_sku_code = $result;
            $voucherCatalog->voucher_catalog_title = $request->input('voucher_catalog_title');
            $voucherCatalog->voucher_catalog_main_image_url = $filename;
            $voucherCatalog->voucher_catalog_information = $request->input('voucher_catalog_information');
            $voucherCatalog->voucher_catalog_valid_start_date = $request->input('voucher_catalog_valid_start_date');
            $voucherCatalog->voucher_catalog_valid_end_date = $request->input('voucher_catalog_valid_end_date');
            $voucherCatalog->voucher_catalog_category_pid = $request->input('voucher_catalog_category_pid');
            $voucherCatalog->voucher_catalog_short_information = $request->input('voucher_catalog_short_information');
            $voucherCatalog->voucher_catalog_tags = $tags;
            $voucherCatalog->voucher_status = 'DRAFT';
            $voucherCatalog->data_sort = $request->input('data_sort') ? : 1000;
            $voucherCatalog->isactive = $request->input('isactive') ? : false;
            $voucherCatalog->isdelete = $request->input('isdelete') ? : false;
            $voucherCatalog->created_by_user_name = $this->loginUsername();
            $voucherCatalog->last_updated_by_user_name = $this->loginUsername();
            $voucherCatalog->save();

            DB::commit();

            $voucher = $this->model::where('voucher_catalog_id',$voucherCatalog->voucher_catalog_id)->first();
            return $this->sendCreated($voucher);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->throwErrorException($e);
        }        
    }

    public function createVoucherDetail($request,$voucherId)
    {
        $voucher = $this->model
            ->where('voucher_catalog_id', '=', $voucherId)
            ->where('isactive', false)
            ->where('voucher_status', '=', 'DRAFT');
        if (empty($voucher->get()->toArray())) {
            return $this->sendNotfound();
        }

        $stockTransactionInitialStockLevel = 0;
        $voucherCatalogStockLevel = request('voucher_catalog_stock_level');
        $stockTransactionInitialStockLevel = $voucherCatalogStockLevel;

        DB::beginTransaction();
        try {
            $voucherCatalog = $voucher->first();
            $voucherCatalog->voucher_catalog_terms_and_condition = $request->input('voucher_catalog_terms_and_condition');
            $voucherCatalog->voucher_catalog_instruction_customer = $request->input('voucher_catalog_instruction_customer');
            $voucherCatalog->voucher_catalog_instruction_outlet = $request->input('voucher_catalog_instruction_outlet');
            $voucherCatalog->voucher_catalog_value_amount = $request->input('voucher_catalog_value_amount');
            $voucherCatalog->voucher_catalog_value_point = $request->input('voucher_catalog_value_point');
            $voucherCatalog->voucher_catalog_unit_price_amount = $request->input('voucher_catalog_unit_price_amount');
            $voucherCatalog->voucher_catalog_unit_price_point = $request->input('voucher_catalog_unit_price_point');
            $voucherCatalog->voucher_catalog_stock_level = $request->input('voucher_catalog_stock_level');
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
    public function stockTransaction($catalogId, $from, $campaignID=null, $adjustedStock = 0, $approvalStatus=1)
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

        if($approvalStatus){
            $difference = -1 * abs($difference);
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

            $query->voucher_catalog_stock_level = $query->voucher_catalog_stock_level + $difference;
            $query->save();

            return $stockTransaction;
        }
    }
}
 