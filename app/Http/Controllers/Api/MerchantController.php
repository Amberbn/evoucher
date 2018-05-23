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

    /**
     *FUNCTION FOR SET FILTER CLIENT
     *@return Array $filter
     */
    public function merchantFilter()
    {
        $filter = [
            'orderBy' => 'merchant_code',
            'filter_1' => 'merchant_title',
            'filter_2' => 'merchant_description',
            'filter_3' => 'client_legal_name',
        ];

        return $filter;

    }

    public function index()
    {
        $merchant = $this->merchantRepository->getAllMerchants();
        if (empty($merchant->get()->toArray())) {
            return $this->sendNotfound();
        }
        $filter = $this->merchantFilter();

        return $this->dataTableResponseBuilder($merchant, $filter);
    }

    /**
     *FUNCTION FOR STORE DATA MERCHANT
     *@param  $request
     *@return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $merchant = $this->repository->saveMerchant($request);

            DB::commit();

            return $this->sendCreated($merchant);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendBadRequest($e->getMessage());
        }
    }

    /**
     *FUNCTION FOR STORE DATA MERCAHANT
     *@param  $request, $merchantId
     *@return \Illuminate\Http\Response
     */
    public function update(Request $request, $merchantId)
    {
        $merchant = $this->model::where('merchant_id', $merchantId)->first();

        if (!$merchant) {
            return $this->sendNotfound();
        }

        DB::beginTransaction();

        try {
            $merchant = $this->repository->updateMerchant($request, $merchant);

            DB::commit();

            return $this->sendSuccess($merchant);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendBadRequest($e->getMessage());
        }
    }

    /**
     *FUNCTION FOR DETAIL DATA MERCAHANT
     *@param  $merchantId
     *@return \Illuminate\Http\Response
     */
    public function show($merchantId)
    {
        $merchant = $this->merchantRepository->getMerchantById($merchantId);
        if (empty($merchant)) {
            return $this->sendNotfound();
        }
        return $this->sendSuccess($merchant);
    }
}
