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

	public function create(Request $request)
	{
			
	}
}
