<?php

namespace App\Http\Controllers\Api;

use App\Client;
use App\Merchant;
use App\Repository\MerchantRepository;
use DB;
use Illuminate\Http\Request;

class MerchantController extends ApiController
{
    protected $merchantRepository;
    /**
     *FUNCTION __construct FOR DEFINE MODEL AND REPOSITORY
     */
    public function __construct()
    {
        $this->model = new Merchant;
        $this->repository = new MerchantRepository;
        $this->merchantRepository = new MerchantRepository;
    }

    public function index()
    {
        $merchant = $this->merchantRepository->getAllMerchants();

        return $merchant;
    }

    /**
     *FUNCTION FOR STORE DATA MERCHANT
     *@param  $request
     *@return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $merchant = $this->repository->saveMerchant($request);

        return $merchant;
    }

    /**
     *FUNCTION FOR STORE DATA MERCAHANT
     *@param  $request, $merchantId
     *@return \Illuminate\Http\Response
     */
    public function update(Request $request, $merchantId)
    {
        $merchant = $this->repository->updateMerchant($request, $merchant);

        return $merchant;
    }

    /**
     *FUNCTION FOR DETAIL DATA MERCAHANT
     *@param  $merchantId
     *@return \Illuminate\Http\Response
     */
    public function show($merchantId)
    {
        $merchant = $this->merchantRepository->getMerchantById($merchantId);

        return $merchant;
    }
}
