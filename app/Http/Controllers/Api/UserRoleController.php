<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Repository\UserRoleRepository;
use App\UserRole;
use DB;
use Illuminate\Http\Request;

class UserRoleController extends ApiController
{
    protected $userRoleRepository;

    public function __construct()
    {
        /**
         *FUNCTION __construct FOR DEFINE MODEL AND REPOSITORY
         */
        $this->model = new UserRole;
        $this->repository = new UserRoleRepository;
        $this->userRoleRepository = new UserRoleRepository;
    }

    /**
     *FUNCTION FOR GET ALL DATA USER ROLE
     *@param
     *@return \Illuminate\Http\Response
     */
    public function index()
    {
        $userRoles = $this->userRoleRepository->getAllUserRoles();
        
        return $userRoles;
    }

    /**
     *FUNCTION FOR STORE DATA USER ROLE
     *@param  $request
     *@return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
            $userRole = $this->repository->saveUserRole($request);

            
    }

    /**
     *FUNCTION FOR DATA USERROLE BY ID
     *@param Request $request
     *@param int $userRoleId
     *@return \Illuminate\Http\Response
     */
    public function show($userRoledId)
    {
        $userRole = $this->userRoleRepository->getUserRoleById($userRoledId);
        
        return $userRole;
    }

    /**
     *FUNCTION FOR UPDATE USERROLE
     *@param Request $request
     *@param int $userRoleId
     *@return \Illuminate\Http\Response
     */
    public function update(Request $request, $userRoleId)
    {
        $userRole = $this->repository->updateUserRole($request, $userRoleId);

        return $userRole;
    }
}
