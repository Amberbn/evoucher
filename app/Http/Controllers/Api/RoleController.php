<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRole;
use App\Role;

class RoleController extends ApiController
{
    public function __construct()
    {
        $this->model = new Role;
        // $this->repository = new RoleRepository;
    }

    public function index()
    {
        $role = $this->model::active()->get();
        if(!$role) {
            return $this->sendNotfound();
        }
        return $this->sendSuccess($role);
    }

    public function create(StoreRole $request)
    {
        
    }
}
