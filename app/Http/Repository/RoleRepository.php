<?php
namespace App\Repository;

use App\Repository\BaseRepository;
use App\Role;

class RoleRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new Role;
    }
    public function store($request)
    {
        $role = $this->model;
        $role->roles_code = $request->input('roles_code');
        $role->roles_description = $request->input('roles_description');
        $role->data_sort = $request->input('data_sort') ?: 1000;
        $role->created_by_user_name = $this->loginUsername();
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
