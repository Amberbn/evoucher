<?php
namespace App\Http\Repository;

use App\Repository\BaseRepository;
use App\VoucherCatalog;
use App\VoucherCatalogOutlet;
use App\StockTransaction;
use DB;

class VoucherCatalogOutletRepository extends BaseRepository
{
    public function saveVoucherCatalogOutlets()
    {
        $voucherCatalogOutlet = new VoucherCatalogOutlet;
        $voucherCatalogOutlet->voucher_catalog_id = $request->input('voucher_catalog_id');
        $voucherCatalogOutlet->outlets_id = $request->input('outlets_id');
        $voucherCatalogOutlet->merchant_id = $request->input('merchant_id');
        $voucherCatalogOutlet->created_by_user_name = $this->loginUsername();
        $voucherCatalogOutlet->save();

        return $voucherCatalogOutlet;
    }
}