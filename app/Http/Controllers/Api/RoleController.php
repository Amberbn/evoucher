<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRole;
use App\Repository\RoleRepository;
use App\Role;
use DB;

class RoleController extends ApiController
{
    public function __construct()
    {
        $this->model = new Role;
        $this->repository = new RoleRepository;
    }

    public function index()
    {
        $role = $this->model::active()->get();
        if(!$role) {
            return $this->sendNotfound();
        }
        return $this->sendSuccess($role);
    }

    public function store(StoreRole $request)
    {
        try {
            DB::beginTransaction();
            $createdBy = $this->createdOrUpdatedByUsername($request);
            $role = $this->repository->store($request,$createdBy);
            DB::commit();
            return $this->sendCreated($role);

        } catch(\Exception $e) {
            DB::rollBack();
            return $this->sendBadRequest($e->getMessage());
        }
    }

    public function update(Request $request,$roleCode)
    {
        $role = Role::active()->where('roles_code',$roleCode)->first();

        if(!$role) {
            return $this->sendNotfound();
        }

        try {
            DB::beginTransaction();
            $role = $this->repository->update($request,$role);
            DB::commit();
            return $this->sendCreated($role);

        } catch(\Exception $e) {
            DB::rollBack();
            return $this->sendBadRequest($e->getMessage());
        }
    }

    public function delete($roleCode)
    {
        $role = Role::active()->where('roles_code',$roleCode)->first();

        if(!$role) {
            return $this->sendNotfound();
        }

        try {
            DB::beginTransaction();
            $role = $this->repository->delete($role);
            DB::commit();
            return $this->sendCreated($role);

        } catch(\Exception $e) {
            DB::rollBack();
            return $this->sendBadRequest($e->getMessage());
        }
    }
}
