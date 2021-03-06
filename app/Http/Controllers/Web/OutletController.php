<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\MerchantRepository;
use App\Http\Repository\OutletRepository;
use App\Repository\RoleRepository;

class OutletController extends BaseControllerWeb
{
	protected $merchantRepository;
    protected $outletRepository;

	public function __construct()
    {
        $this->merchantRepository = new MerchantRepository;
        $this->outletRepository = new OutletRepository;
    }

	public function index()
	{
		return view('outlet.index');
	}

	public function create(Request $request, $merchantId)
	{
		$merchant = $this->merchantRepository->getMerchantById($merchantId);
		// dd($merchant);
		$response = $this->getDataFromJson($merchant)->first();
		// dd($response);
		$filters = [
			'address_state_province',
            'address_city',
            'address_region',
        ];



        $settings = $this->getSettings($filters, false);
         // dd($settings);
		 // $bussinessCategory = $this->getSettings(['bussiness_category']);
        // $parametersValue = $this->getSettings(['parameters_value']);

        // $data = compact(
        // 	'settings' 
        // );

       
        $outletCode = $this->outletRepository->generateOutletCode();
        // dd($outletCode);

		return view('outlet.outlet_form', compact('settings', 'response', 'outletCode'));
	}

	public function store(Request $request, $merchantId)
	{
		if (!$merchantId) {
			return pageNotFound();
		}
		$outlet= $this->outletRepository->store($request, $merchantId);
		 // dd($outlet);
        $responseCode = $this->getResponseCodeFromJson($outlet);
        if ($responseCode != 201) {

        }
        $response = $this->getDataFromJson($outlet);

        return redirect()->route('merchant.index');
	}
}
