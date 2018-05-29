<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\VoucherCatalogOutletRepository;
use DB;

class VoucherCatalogOutletController extends ApiController
{
    protected $voucherCatalogOutletRepository;

    public function __construct()
    {
        $this->voucherCatalogOutletRepository = new MerchantRepository;
    }

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

    public function index()
    {
        $voucherCatalogOutlets = $this->voucherCatalogOutletRepository->getAllVoucherCatalogOutlets();
        if (empty($voucherCatalogOutlets->get()->toArray())) {
            return $this->sendNotfound();
        }
        $filter = $this->voucherCatalogOutletFilter();

        return $this->dataTableResponseBuilder($voucherCatalogOutlets, $filter);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        try {
            $voucherCatalogOutlets = $this->voucherCatalogOutletRepository->saveVoucherCatalogOutlets($request);

            DB::commit();

            return $this->sendCreated($voucherCatalogOutlets);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendBadRequest($e->getMessage());
        }
        
    }
}
