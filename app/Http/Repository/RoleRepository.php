<?php
namespace App\Repository;

use App\Role;

class RoleRepository
{

    public function store($request, $createBy)
    {
        $role = new Role;
        $role->roles_code = $request->roles_code;
        $role->roles_description = $request->roles_description;
        $role->data_sort = $request->data_sort;
        $role->created_by_user_name = $createBy;
        $role->isactive = $request->isactive;
        $role->isdelete = $request->isdelete;
        $role->created_at = date("Y-m-d H:i:s");
        $role->save();

        return $role;
    }

    public function update($request, $role)
    {
        $role->roles_description = $request->roles_description;
        $role->data_sort = $request->data_sort;
        $role->isactive = $request->isactive;
        $role->isdelete = $request->isdelete;
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
