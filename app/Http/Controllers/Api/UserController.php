<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Repository\UserRepository;
use App\Http\Controllers\Controller;
use App\User;
use DB;

class UserController extends ApiController
{
    /**
     *FUNCTION __construct FOR DEFINE MODEL AND REPOSITORY
     */
    public function __construct()
    {
        $this->model = new User;
        $this->repository = new UserRepository;
    }

    /**
     *FUNCTION FOR GET ALL DATA USER
     */
    public function getUsers()
    {
        $users = User::active()->get();
        if (!$users)
        {
            return $this->sendNotfound();
        }

        return $this->sendSuccess($users);
    }

    /**
     *FUNCTION FOR INSERT USER
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $createdBy = $this->createdOrUpdatedByUsername($request);
            $user = $this->repository->saveUser($request, $createdBy);

            DB::commit();

            return $this->sendCreated($user);

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendBadRequest($e->getMessage());
        }
    }

    /**
     *FUNCTION FOR GET DATA USER BY USERNAME
     */
    public function getUser($userName)
    {
        $user = $this->model::active()->where('user_name', $userName)->first();
        if(!$user) {
             return $this->sendNotfound();
        }

        return $this->sendSuccess($user);
    }

    /**
     *FUNCTION FOR UPDATE GLOBAL PARAMETER
     */
    public function update(Request $request, $userName)
    {
        $user = GlobalParameter::active()->where('user_name', $userName)->first();
        if (!$user)
        {
            return $this->sendNotFound();
        }

        DB::beginTransaction();

        try {
            $updateBy = $this->createdOrUpdatedByUsername($request);
            $user = $this->repository->updateUser($request,$user,$updateBy);

            DB::commit();

            return $this->sendSuccess($user);

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendBadRequest($e->getMessage());
        }
    }
}
