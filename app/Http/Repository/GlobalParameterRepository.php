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
        $globalParameter->client_code = $request->client_code;
        $globalParameter->parameters_type = $request->parameters_type;
        $globalParameter->parameters_code = $request->parameters_code;
        $globalParameter->parameters_value_datatype = $request->parameters_value_datatype;
        $globalParameter->parameters_parent_id = $request->parameters_parent_id;
        $globalParameter->data_sort = $request->data_sort;
        $globalParameter->isactive = $request->isactive;
        $globalParameter->isdelete = $request->isdelete;
        $globalParameter->created_by_user_name = $createdBy;
        $globalParameter->last_updated_by_user_name = $createdBy;
        $globalParameter->save();

        return $globalParameter;
    }

    public function updateGlobalParameter($request, $globalParameter, $updateBy)
    {
        $globalParameter->client_code = $request->client_code;
        $globalParameter->parameters_type = $request->parameters_type;
        $globalParameter->parameters_code = $request->parameters_code;
        $globalParameter->parameters_value_datatype = $request->parameters_value_datatype;
        $globalParameter->parameters_parent_id = $request->parameters_parent_id;
        $globalParameter->data_sort = $request->data_sort;
        $globalParameter->isactive = $request->isactive;
        $globalParameter->isdelete = $request->isdelete;
        // $globalParameter->created_by_user_name = $updateBy;
        $globalParameter->last_updated_by_user_name = $updateBy;
        $globalParameter->save();
    }
}
