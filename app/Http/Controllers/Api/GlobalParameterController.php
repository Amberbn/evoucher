<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\GlobalParameter;
use DB;

class GlobalParameterController extends ApiController
{
    public function getGlobalParameters()
    {
        $globalParameters = GlobalParameter::active()->get();
        if ($globalParameters)
        {
            return $this->sendNotfound();
        }

        return $this->sendSuccess($globalParameters);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $globalParameter = new GlobalParameter;
            $globalParameter->client_code = $request->client_code;
            $globalParameter->parameters_type = $request->parameters_type;
            $globalParameter->parameters_code = $request->parameters_code;
            $globalParameter->parameters_value_datatype = $request->parameters_value_datatype;
            $globalParameter->parameters_parent_id = $request->parameters_parent_id;
            $globalParameter->data_sort = $request->data_sort;
            $globalParameter->isactive = $request->isactive;
            $globalParameter->isdelete = $request->isdelete;
            $globalParameter->created_by_user_name = $request->created_by_user_name;
            $globalParameter->last_updated_by_user_name = $request->last_updated_by_user_name;
            $globalParameter->save();

            DB::commit();

            return $this->sendCreated($globalParameter);

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendBadRequest($e->getMessage());
        }
    }

    public function getGlobalParameter($globalParameterId)
    {
        $param = (int)$globalParameterId ? true : false;
        $field = $param ? 'parameters_id' : 'parameters_code';
        $globalParameter = GlobalParameter::active()
          ->where($field,$globalParameterId)->first();
          // ->where('parameters_id', $globalParameterId)
          // ->orWhere('parameters_code', $parametersCode)

          // if($param) {
          //   $globalParameter->where('parameters_id', $globalParameterId);
          // }else{
          //   $globalParameter->where('parameters_code', $globalParameterId);
          // }
          // $globalParameter->first();

        if (!$globalParameter)
        {
            return $this->sendNotFound();
        }

        return $this->sendSuccess($globalParameter);
    }

    public function update($globalParameterId)
    {
        $globalParameter = GlobalParameter::active()->where('parameters_id', $globalParameterId)->first();
        if (!$globalParameter)
        {
            return $this->sendNotFound();
        }

        DB::beginTransaction();

        try {
            $globalParameter->client_code = $request->client_code;
            $globalParameter->parameters_type = $request->parameters_type;
            $globalParameter->parameters_code = $request->parameters_code;
            $globalParameter->parameters_value_datatype = $request->parameters_value_datatype;
            $globalParameter->parameters_parent_id = $request->parameters_parent_id;
            $globalParameter->data_sort = $request->data_sort;
            $globalParameter->isactive = $request->isactive;
            $globalParameter->isdelete = $request->isdelete;
            $globalParameter->created_by_user_name = $request->created_by_user_name;
            $globalParameter->last_updated_by_user_name = $request->last_updated_by_user_name;
            $globalParameter->save();

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendBadRequest($e->getMessage());
        }
    }
}
