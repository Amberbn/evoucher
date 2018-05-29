<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repository\VoucherCatalogOutletRepository;
use DB;

class VoucherCatalogOutletController extends ApiController
{
    protected $voucherCatalogOutletRepository;

    public function __construct()
    {
        $this->voucherCatalogOutletRepository = new VoucherCatalogOutletRepository;
    }

    public function index()
    {
        $voucherCatalogOutlets = $this->voucherCatalogOutletRepository->getAllVoucherCatalogOutlets();
        
        return $voucherCatalogOutlets;
    }

    public function store(Request $request)
    {
        $voucherCatalogOutlets = $this->voucherCatalogOutletRepository->saveVoucherCatalogOutlets($request);

        return $voucherCatalogOutlets;
    }
}
