<?php
namespace App\Http\Repository;

use App\Repository\BaseRepository;
use App\VoucherCatalog;
use App\VoucherCatalogOutlet;
use App\StockTransaction;
use DB;

class VoucherCatalogOutletRepository extends BaseRepository
{
    public function voucherCatalogOutletFilter()
    {
        $filter = [
            'orderBy' => 'voucher_catalog_outets_id',
            'filter_1' => 'voucher_catalog_id',
            'filter_2' => 'outlets_id',
            'filter_3' => 'merchant_id',
        ];

        return $filter;

    }

    public function getAllVoucherCatalogOutlets()
    {   
        $voucherCatalogOutlets = DB::table('vou_voucher_catalog_outlets as vo')
            ->join('mch_outlets as mo', 'vo.outlets_id', '=', 'mo.outlets_id')
            ->join('mch_merchant as mm', 'vo.merchant_id', '=', 'mm.merchant_id')
            ->join('bsn_client as bc', 'mm.merchant_client_id', '=', 'bc.client_id')
            ->where('vo.voucher_catalog_id', '=', 'vo.voucher_catalog_id');

            if (!$this->isGroupSprint()) {
                $voucherCatalogOutlets->where('bc.client_category_pid', '=', $this->me()['client_category_pid']);
            }

        $voucherCatalogOutlets->select(
            'vo.voucher_catalog_outets_id',
            'vo.voucher_catalog_id',
            'vo.outlets_id',
            'vo.merchant_id',
            'vo.created_by_user_name'
        );

        if (empty($voucherCatalogOutlets->get()->toArray())) {
            return $this->sendNotfound();
        }
        $filter = $this->voucherCatalogOutletFilter();

        return $this->dataTableResponseBuilder($voucherCatalogOutlets, $filter);
    }

    public function saveVoucherCatalogOutlets($request)
    {
        DB::beginTransaction();
        
        try {    
            $voucherCatalog = VoucherCatalog::find($request->voucher_catalog_id);
            $voucherCatalog->voucher_catalog_revision_no = $voucherCatalog->voucher_catalog_revision_no += 1;
            $voucherCatalog->save();

            foreach($request->outlets_id as $outletId)
            {
                $voucherCatalogOutlet = new VoucherCatalogOutlet;
                $voucherCatalogOutlet->voucher_catalog_id = $voucherCatalog->voucher_catalog_id;
                $voucherCatalogOutlet->merchant_id = $request->input('merchant_id');
                $voucherCatalogOutlet->outlets_id = $outletId;
                $voucherCatalogOutlet->created_by_user_name = $this->loginUsername();
                $voucherCatalogOutlet->save();
            }

            DB::commit();

            return $this->sendCreated($voucherCatalogOutlet);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendBadRequest($e->getMessage());
        }
        
        return $voucherCatalogOutlet;
    }
}