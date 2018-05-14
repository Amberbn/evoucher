<?php
namespace App\Repository;

use App\Role;

class RoleRepository
{

    public function store($request, $createBy)
    {
        $role = new Role;
        $role->roles_code = $request->input('roles_code');
        $role->roles_description = $request->input('roles_description');
        $role->data_sort = $request->input('data_sort') ?: 1000;
        $role->created_by_user_name = $createBy;
        $role->isactive = $request->input('isactive') ?: true;
        $role->isdelete = $request->input('isdelete') ?: false;
        $role->created_at = date("Y-m-d H:i:s");
        $role->save();

        return $role;
    }

    public function update($request, $role)
    {
        $role->roles_description = $request->roles_description;
        $role->data_sort = $request->input('data_sort') ?: 1000;
        $role->isactive = $request->input('isactive') ?: true;
        $role->isdelete = $request->input('isdelete') ?: false;
        $role->save();

        return $role;
    }

    public function delete($role)
    {
        $role->isdelete = true;
        $role->save();

        return $role;
    }

}
