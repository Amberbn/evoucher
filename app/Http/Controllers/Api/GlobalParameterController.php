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
        if ($globalParameters) {
            return $this->sendNotfound();
        }

        return $this->sendSuccess($globalParameters);
    }

    /**
     *FUNCTION FOR INSERT GLOBAL PARAMETER
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $createdBy = $this->createdOrUpdatedByUsername($request);
            $globalParameter = $this->repository->saveGlobalParameter($request, $createdBy);

            DB::commit();

            return $this->sendCreated($globalParameter);

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendBadRequest($e->getMessage());
        }
    }

    /**
     *FUNCTION FOR GET DATA GLOBAL PARAMETER BY GLOBAL PARAMETER ID
     */
    public function getGlobalParameter($globalParameterId)
    {
        $param = (int) $globalParameterId ? true : false;
        $field = $param ? 'parameters_id' : 'parameters_code';
        $globalParameter = GlobalParameter::active()
            ->where($field, $globalParameterId)->first();
        // ->where('parameters_id', $globalParameterId)
        // ->orWhere('parameters_code', $parametersCode)

        // if($param) {
        //   $globalParameter->where('parameters_id', $globalParameterId);
        // }else{
        //   $globalParameter->where('parameters_code', $globalParameterId);
        // }
        // $globalParameter->first();

        if (!$globalParameter) {
            return $this->sendNotFound();
        }

        return $this->sendSuccess($globalParameter);
    }

    /**
     *FUNCTION FOR UPDATE GLOBAL PARAMETER
     */
    public function update(Request $request, $globalParameterId)
    {
        $globalParameter = GlobalParameter::active()->where('parameters_id', $globalParameterId)->first();
        if (!$globalParameter) {
            return $this->sendNotFound();
        }

        DB::beginTransaction();

        try {
            $updateBy = $this->createdOrUpdatedByUsername($request);
            $globalParameter = $this->repository->updateGlobalParameter($request, $globalParameter, $updateBy);

            DB::commit();

            return $this->sendSuccess($globalParameter);

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendBadRequest($e->getMessage());
        }
    }
}
