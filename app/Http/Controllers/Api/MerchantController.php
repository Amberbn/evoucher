<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\MerchantRepository;
use App\Merchant;
use DB;
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
        $merchant = Merchant::active()->get();
        if (!$merchant) {
            return $this->sendNotfound();
        }

        return $this->sendSuccess($merchant);
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
            $createdBy = $this->createdOrUpdatedByUsername($request);
            $merchant = $this->repository->saveMerchant($request, $createdBy);

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
            $updateBy = $this->createdOrUpdatedByUsername($request);
            $merchant = $this->repository->updateMerchant($request, $merchant, $updateBy);

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
