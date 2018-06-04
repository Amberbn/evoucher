<?php
namespace App\Repository;

use App\GlobalParameter;
use App\Repository\BaseRepository;

/**
 *
 */
class GlobalParameterRepository extends BaseRepository
{
    public function saveGlobalParameter($request)
    {
        DB::beginTransaction();

        try {
            $globalParameter = new GlobalParameter;
            $globalParameter->client_id = $request->input('client_id');
            $globalParameter->parameters_type = $request->input('parameters_type');
            $globalParameter->parameters_code = $request->input('parameters_code');
            $globalParameter->parameters_value_datatype = $request->input('parameters_value_datatype');
            $globalParameter->parameters_parent_id = $request->input('parameters_parent_id');
            $globalParameter->data_sort = $request->input('data_sort');
            $globalParameter->isactive = $request->input('isactive') ?: true;
            $globalParameter->isdelete = $request->input('isdelete') ?: false;
            $globalParameter->created_by_user_name = $this->loginUsername();
            $globalParameter->last_updated_by_user_name = $this->loginUsername();
            $globalParameter->save();
            DB::commit();

            return $this->sendCreated($globalParameter);

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendBadRequest($e->getMessage());
        }
    }

    public function getGlobalParameterById($globalParameterId)
    {
        $param = (int) $globalParameterId ? true : false;
        $field = $param ? 'parameters_id' : 'parameters_code';
        
        $globalParameter = GlobalParameter::active()
            ->where($field, $globalParameterId)->first();

        if (!$globalParameter) {
            return $this->sendNotFound();
        }

        return $this->sendSuccess($globalParameter);
    }

    public function updateGlobalParameter($request, $globalParameterId)
    {
        $globalParameter = GlobalParameter::active()->where('parameters_id', $globalParameterId)->first();
        if (!$globalParameter) {
            return $this->sendNotFound();
        }

        DB::beginTransaction();

        try {
            $globalParameter->client_id = $request->input('client_id');
            $globalParameter->parameters_type = $request->input('parameters_type');
            $globalParameter->parameters_code = $request->input('parameters_code');
            $globalParameter->parameters_value_datatype = $request->input('parameters_value_datatype');
            $globalParameter->parameters_parent_id = $request->input('parameters_parent_id');
            $globalParameter->data_sort = $request->input('data_sort');
            $globalParameter->isactive = $request->input('isactive') ?: true;
            $globalParameter->isdelete = $request->input('isdelete') ?: false;
            $globalParameter->last_updated_by_user_name = $this->loginUsername();
            $globalParameter->save();

            DB::commit();

            return $this->sendSuccess($globalParameter);

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendBadRequest($e->getMessage());
        }
    }
}
