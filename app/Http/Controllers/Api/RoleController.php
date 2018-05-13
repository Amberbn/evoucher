<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreRole;
use App\Repository\RoleRepository;
use App\Role;
use DB;
use Illuminate\Http\Request;

class RoleController extends ApiController
{
    /**
     *FUNCTION __construct FOR DEFINE MODEL AND REPOSITORY
     */
    public function __construct()
    {
        $this->model = new Role;
        $this->repository = new RoleRepository;
    }

    /**
     *FUNCTION FOR GET ALL DATA ROLE
     *@return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = $this->model::active()->get();
        if (!$role) {
            return $this->sendNotfound();
        }
        return $this->sendSuccess($role);
    }

    /**
     *FUNCTION FOR STORE DATA ROLE
     *@param StoreRole $request
     *@return \Illuminate\Http\Response
     */
    public function store(StoreRole $request)
    {
        try {
            DB::beginTransaction();
            $createdBy = $this->createdOrUpdatedByUsername($request);
            $role = $this->repository->store($request, $createdBy);
            DB::commit();
            return $this->sendCreated($role);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendBadRequest($e->getMessage());
        }
    }

    /**
     *FUNCTION FOR UPDATE DATA ROLE
     *@param Request $request
     *@param int $roleid
     *@return \Illuminate\Http\Response
     */
    public function update(Request $request, $roleid)
    {
        $role = Role::active()->where('roles_id', $roleid)->first();

        if (!$role) {
            return $this->sendNotfound();
        }

        try {
            DB::beginTransaction();
            $role = $this->repository->update($request, $role);
            DB::commit();
            return $this->sendCreated($role);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendBadRequest($e->getMessage());
        }
    }

    /**
     *FUNCTION FOR DELETE DATA ROLE
     *@param int $roleid
     *@return \Illuminate\Http\Response
     */
    public function delete($roleId)
    {
        $role = Role::active()->where('roles_id', $roleId)->first();

        if (!$role) {
            return $this->sendNotfound();
        }

        try {
            DB::beginTransaction();
            $role = $this->repository->delete($role);
            DB::commit();
            return $this->sendCreated($role);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendBadRequest($e->getMessage());
        }
    }
}
