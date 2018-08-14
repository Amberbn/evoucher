<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\RedeemRepository;

class RedeemController extends BaseControllerWeb
{

	public function __construct()
	{
		$this->redemRepository = new RedeemRepository;
	}

    public function redeem($voucherGeneratedNumber)
    {
        $voucherId = $voucherGeneratedNumber;
    	$redeem = $this->redemRepository->redeemInformation($voucherGeneratedNumber);

    	if(!$voucherGeneratedNumber) {
    		return $this->pageNotFound();
    	}

    	if(!$redeem) {
    		return $this->pageNotFound();
    	}

    	$redeem = $this->getDataFromJson($redeem);
    	return view('redeem.redeem', compact('redeem','voucherId'));
    }

    public function redeemSave(Request $request, $voucherNumber)
    {
         $redeem = $this->redemRepository->redeem($request, $voucherNumber);

         // return ($this->getDataFromJson($redeem)->first());

         return $redeem;
    }
}
