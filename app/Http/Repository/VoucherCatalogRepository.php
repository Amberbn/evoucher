<?php
namespace App\Http\Repository;

use App\Repository\BaseRepository;
use App\VoucherCatalog;
use DB;

class VoucherCatalogRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new VoucherCatalog();
    }

    public function getAllVoucherCatalog()
    {
        $voucherCatalogs = DB::table('vou_voucher_catalog as cat')
            ->join('bsn_client as bc', 'cat.merchant_client_id', '=', 'bc.client_id')
            ->where('cat.isdelete', false);

        if (!$this->isGroupSprint()) {
            $outlet->where('client.client_category_pid', '=', $this->me()['client_category_pid']);
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

        return $voucherCatalogs;
    }

    public function saveVoucherCatalog($request)
    {
        $voucherCatalog = new VoucherCatalog;
        $voucherCatalog->voucher_catalog_revision_no = 0;
        $voucherCatalog->merchant_client_id = $request->input('merchant_client_id');
        $voucherCatalog->client_name = $request->input('client_name');
        $voucherCatalog->voucher_catalog_sku_code = $request->input('voucher_catalog_sku_code');
        $voucherCatalog->voucher_catalog_title = $request->input('voucher_catalog_title');
        $voucherCatalog->voucher_catalog_main_image_url = $request->input('voucher_catalog_main_image_url');
        $voucherCatalog->voucher_catalog_information = $request->input('voucher_catalog_information');
        $voucherCatalog->voucher_catalog_terms_and_condition = $request->input('voucher_catalog_terms_and_condition');
        $voucherCatalog->voucher_catalog_instruction_customer = $request->input('voucher_catalog_instruction_customer');
        $voucherCatalog->voucher_catalog_instruction_outlet = $request->input('voucher_catalog_instruction_outlet');
        $voucherCatalog->voucher_catalog_valid_start_date = $request->input('voucher_catalog_valid_start_date');
        $voucherCatalog->voucher_catalog_valid_end_date = $request->input('voucher_catalog_valid_end_date');
        $voucherCatalog->voucher_catalog_tags = $request->input('voucher_catalog_tags');
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

        return $voucherCatalog;
    }
}
