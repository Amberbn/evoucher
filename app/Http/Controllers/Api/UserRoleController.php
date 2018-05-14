<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserRole;
use DB;

class UserRoleController extends ApiController
{
    public function __construct()
    {
        /**
        *FUNCTION __construct FOR DEFINE MODEL AND REPOSITORY
        */
        $this->model = new UserRole;
        $this->repository = new UserRoleRepository;
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
     *FUNCTION FOR DELETE CLIENT
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
            $userRole = $this->repository->updateUserRole($request, $createdBy);

            DB::commit();

            return $this->sendCreated($userRole);
        }catch(\Exception $e){
            DB::rollback();
            return $this->sendBadRequest($e->getMessage());
        }
    }
}
