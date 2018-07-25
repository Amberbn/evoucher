<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\MerchantRepository;

class MerchantController extends Controller
{
    protected $merchantRepository;

    public function __construct()
    {
        $this->merchantRepository = new MerchantRepository;
    }

    public function create()
    {
        return view('merchant.create');
    }

    public function store(Request $request)
    {
        $merchant = $this->merchantRepository->store($request);
        $responseCode = $this->getResponseCodeFromJson($merchant);
        if ($responseCode != 201) {

        }

        return redirect()->route('merchant.index');
    }
}
