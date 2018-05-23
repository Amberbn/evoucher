<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repository\VoucherCatalogRepository;
use App\VoucherCatalog;

class VoucherCatalogController extends ApiController
{
    protected $voucherCatalogRepository;

    public function __construct()
    {
        $this->voucherCatalogRepository = new VoucherCatalogRepository;
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

    public function index()
    {
        $voucherCatalogs = $this->merchantRepository->getAllMerchants();
        if (empty($voucherCatalogs->get()->toArray())) {
            return $this->sendNotfound();
        }
        $filter = $this->voucherCatalogFilter();

        return $this->dataTableResponseBuilder($voucherCatalogs, $filter);
    }
}
