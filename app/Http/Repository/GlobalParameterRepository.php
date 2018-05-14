<?php
namespace App\Repository;

use App\GlobalParameter;

/**
 *
 */
class GlobalParameterRepository
{
    public function saveGlobalParameter($request, $createdBy)
    {
        $globalParameter = new GlobalParameter;
        $globalParameter->client_id = $request->input('client_id');
        $globalParameter->parameters_type = $request->input('parameters_type');
        $globalParameter->parameters_code = $request->input('parameters_code');
        $globalParameter->parameters_value_datatype = $request->input('parameters_value_datatype');
        $globalParameter->parameters_parent_id = $request->input('parameters_parent_id');
        $globalParameter->data_sort = $request->input('data_sort');
        $globalParameter->isactive = $request->input('isactive') ? true;
        $globalParameter->isdelete = $request->input('isdelete') ? false;
        $globalParameter->created_by_user_name = $createdBy;
        $globalParameter->last_updated_by_user_name = $createdBy;
        $globalParameter->save();

        return $globalParameter;
    }

    public function updateGlobalParameter($request, $globalParameter, $updateBy)
    {
        $globalParameter->client_id = $request->input('client_id');
        $globalParameter->parameters_type = $request->input('parameters_type');
        $globalParameter->parameters_code = $request->input('parameters_code');
        $globalParameter->parameters_value_datatype = $request->input('parameters_value_datatype');
        $globalParameter->parameters_parent_id = $request->input('parameters_parent_id');
        $globalParameter->data_sort = $request->input('data_sort');
        $globalParameter->isactive = $request->input('isactive') ? : true;
        $globalParameter->isdelete = $request->input('isdelete') ? : false;
        $globalParameter->last_updated_by_user_name = $updateBy;
        $globalParameter->save();

        return $globalParameter;
    }
}
