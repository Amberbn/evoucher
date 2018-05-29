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

    public function index()
    {
        $voucherCatalogs = $this->voucherCatalogRepository->getAllVoucherCatalog();

        return $voucherCatalogs;
    }

    public function store(Request $request)
    {
        $voucherCatalog = $this->voucherCatalogRepository->saveVoucherCatalog($request);

        return $voucherCatalog;
    }
}
