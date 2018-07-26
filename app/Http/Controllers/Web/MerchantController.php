<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\MerchantRepository;

class MerchantController extends BaseControllerWeb
{
    protected $merchantRepository;

    public function __construct()
    {
        $this->merchantRepository = new MerchantRepository;
    }

    public function index()
    {
        return view('merchant.index');
    }

    public function indexDatatable()
    {
        $merchant = $this->merchantRepository->getAllMerchants();
        dd("Jangkrik");
        $merchant = $this->getDataFromJson($merchant);
dd($merchant);
        return Datatables::of($merchant)
            ->addIndexColumn()
            ->addColumn('action', function ($merchant) {
                return '<td class="first">' .
                '<div class="form-check">' .
                '<input type="checkbox" value="user_id_' . $merchant->merchant_id . '" class="form-check-input" nice-checkbox-radio />' .
                    '</div>' .
                    '</td>';
            })
             ->make(true);
       
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
