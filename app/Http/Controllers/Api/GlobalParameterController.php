<?php

namespace App\Http\Controllers\Api;

use App\GlobalParameter;
use App\Http\Controllers\Api\ApiController;
use App\Repository\GlobalParameterRepository;
use DB;
use Illuminate\Http\Request;

class GlobalParameterController extends ApiController
{
    /**
     *FUNCTION __construct FOR DEFINE MODEL AND REPOSITORY
     */
    public function __construct()
    {
        $this->model = new GlobalParameter;
        $this->repository = new GlobalParameterRepository;
    }

    /**
     *FUNCTION FOR GET ALL DATA GLOBAL PARAMETER
     */
    public function getGlobalParameters()
    {
        $globalParameters = GlobalParameter::active()->get();
        if (!$globalParameters) {
            return $this->sendNotfound();
        }

        return $this->sendSuccess($globalParameters);
    }

    /**
     *FUNCTION FOR INSERT GLOBAL PARAMETER
     */
    public function store(Request $request)
    {
        $globalParameter = $this->repository->saveGlobalParameter($request);

        return $globalParameter;
    }

    /**
     *FUNCTION FOR GET DATA GLOBAL PARAMETER BY GLOBAL PARAMETER ID
     */
    public function getGlobalParameter($globalParameterId)
    {
        $globalParameter = $this->repository->getGlobalParameterById($globalParameterId);

        return $globalParameter;
    }

    /**
     *FUNCTION FOR UPDATE GLOBAL PARAMETER
     */
    public function update(Request $request, $globalParameterId)
    {
        $globalParameter = $this->repository->updateGlobalParameter($request, $globalParameterId);

        return $globalParameter;
    }
}
