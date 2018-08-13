<?php

namespace App\Http\Controllers\Api;
use App\Repository\RedeemRepository;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RedeemController extends ApiController
{
    protected $redeemRepository;
    /**
     *FUNCTION __construct FOR DEFINE MODEL AND REPOSITORY
     */
    public function __construct()
    {
        $this->redeemRepository = new RedeemRepository;
    }

    public function redeem(Request $request, $voucherNumber)
    {
    	 $redeem = $this->redeemRepository->redeem($request, $voucherNumber);

    	 return $redeem;
    }
}
