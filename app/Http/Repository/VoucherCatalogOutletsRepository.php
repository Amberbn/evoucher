<?php
namespace App\Http\Repository;

use App\Repository\BaseRepository;
use App\VoucherCatalog;
use App\VoucherCatalogOutlet;
use App\StockTransaction;
use DB;

class VoucherCatalogOutletRepository extends BaseRepository
{
    public function getAllVoucherCatalogOutlets()
    {
        $voucherCatalogOutlets = DB::table('vou_voucher_catalog_outlets as vo')
            ->join('mch_outlets as mo', 'vo.outlets_id', '=', 'mo.outlets_id')
            ->join('mch_merchant as mm', 'vo.merchant_id', '=', 'mm.merchant_id')
            ->join('bsn_client as bc', 'mm.merchant_client_id', '=', 'bc.client_id')
            ->where('vo.voucher_catalog_id', '=', 'vo.voucher_catalog_id');

            if (!$this->isGroupSprint()) {
                $merchants->where('bc.client_category_pid', '=', $this->me()['client_category_pid']);
            }

        $voucherCatalogOutlets->select(
            'vo.voucher_catalog_outets_id',
            'vo.voucher_catalog_id',
            'vo.outlets_id',
            'vo.merchant_id',
            'vo.created_by_user_name'
        );
    }

    public function saveVoucherCatalogOutlets($request)
    {
        foreach($request->outlets_id as $outlets_id)
        {
            $voucherCatalogOutlet = new VoucherCatalogOutlet;
            $voucherCatalogOutlet->voucher_catalog_id = $request->input('voucher_catalog_id');
            $voucherCatalogOutlet->merchant_id = $request->input('merchant_id');
            $voucherCatalogOutlet->outlets_id = $outlets_id;
            $voucherCatalogOutlet->created_by_user_name = $this->loginUsername();
            $voucherCatalogOutlet->save();
        }
        
        return $voucherCatalogOutlet;
    }
}