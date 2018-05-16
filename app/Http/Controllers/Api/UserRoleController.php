<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserRole;
use App\Repository\UserRoleRepository;
use DB;

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
        if (empty($userRoles)) {
            return $this->sendNotfound();
        }
        return $this->sendSuccess($userRoles);
    }

    /**
     *FUNCTION FOR STORE DATA USER ROLE
     *@param  $request
     *@return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try{
            $createdBy = $this->createdOrUpdatedByUsername($request);
            $userRole = $this->repository->saveUserRole($request, $createdBy);

            DB::commit();

            return $this->sendCreated($userRole);
        }catch(\Exception $e){
            DB::rollback();
            return $this->sendBadRequest($e->getMessage());
        }
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
        if (empty($userRole)) {
            return $this->sendNotfound();
        }
        return $this->sendSuccess($userRole);
    }

    /**
     *FUNCTION FOR UPDATE USERROLE
     *@param Request $request
     *@param int $userRoleId
     *@return \Illuminate\Http\Response
     */
    public function update(Request $request, $userRoleId)
    {
        $userRole = $this->model::where('user_roled_id', $userRoleId)->first();
        if (!$userRole) {
            return $this->sendNotfound();
        }

        DB::beginTransaction();

        try{
            //$updateBy = $this->createdOrUpdatedByUsername($request);
            $userRole = $this->repository->updateUserRole($request, $userRole);

            DB::commit();

            return $this->sendCreated($userRole);
        }catch(\Exception $e){
            DB::rollback();
            return $this->sendBadRequest($e->getMessage());
        }
    }
}
