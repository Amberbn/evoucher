<?php
namespace App\Repository;

use App\Repository\BaseRepository;
use App\Role;
use Illuminate\Support\Facades\DB;

class RoleRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new Role;
    }

    public function getRole()
    {
        $role = $this->model::active()->get();

        if (!$role) {
            return $this->sendNotfound();
        }
        return $this->sendSuccess($role);
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();

            $role = $this->model;
            $role->roles_code = $request->input('roles_code');
            $role->roles_description = $request->input('roles_description');
            $role->data_sort = $request->input('data_sort') ?: 1000;
            $role->created_by_user_name = $this->loginUsername();
            $role->isactive = $request->input('isactive') ?: true;
            $role->isdelete = $request->input('isdelete') ?: false;
            $role->created_at = date("Y-m-d H:i:s");
            $role->save();

            DB::commit();
            return $this->sendCreated($role);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->throwErrorException($e);
        }
    }

    public function update($request, $roleid)
    {
        $role = Role::active()->where('roles_id', $roleid)->first();

        if (!$role) {
            return $this->sendNotfound();
        }

        try {
            DB::beginTransaction();

            $role->roles_description = $request->roles_description;
            $role->data_sort = $request->input('data_sort') ?: 1000;
            $role->isactive = $request->input('isactive') ?: true;
            $role->isdelete = $request->input('isdelete') ?: false;
            $role->save();

            DB::commit();
            return $this->sendSuccess($role);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->throwErrorException($e);
        }
    }

    public function delete($roleId)
    {
        $role = Role::active()->where('roles_id', $roleId)->first();

        if (!$role) {
            return $this->sendNotfound();
        }

        try {
            DB::beginTransaction();

            $role->isdelete = true;
            $role->save();
            DB::commit();

            return $this->sendSuccess($role);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->throwErrorException($e);
        }
    }

}
