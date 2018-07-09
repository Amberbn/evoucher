<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreRole;
use App\Repository\RoleRepository;
use App\Role;
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
        return $this->repository->getRole();
    }

    /**
     *FUNCTION FOR STORE DATA ROLE
     *@param StoreRole $request
     *@return \Illuminate\Http\Response
     */
    public function store(StoreRole $request)
    {
        return $this->repository->store($request);
    }

    /**
     *FUNCTION FOR UPDATE DATA ROLE
     *@param Request $request
     *@param int $roleid
     *@return \Illuminate\Http\Response
     */
    public function update(Request $request, $roleid)
    {
        return $this->repository->update($request, $roleid);
    }

    /**
     *FUNCTION FOR DELETE DATA ROLE
     *@param int $roleid
     *@return \Illuminate\Http\Response
     */
    public function delete($roleId)
    {
        return $this->repository->delete($roleId);
    }
}
