<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Repository\UserRepository;
use App\User;
use DB;
use Illuminate\Http\Request;

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
        $users = $this->repository->getAllUser();
         if (!$users) {
            return $this->sendNotfound();
        }

        return $this->sendSuccess($users);

        // $users = User::active()->get();
        // if (!$users) {
        //     return $this->sendNotfound();
        // }
        //
        // return $this->sendSuccess($users);
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
    public function getUser($userId)
    {
        $user = $this->model::active()->where('user_id', $userId)->first();
        if (!$user) {
            return $this->sendNotfound();
        }

        return $this->sendSuccess($user);
    }

    /**
     *FUNCTION FOR UPDATE GLOBAL PARAMETER
     */
    public function update(Request $request, $userId)
    {
        $user = User::active()->where('user_id', $userId)->first();
        if (!$user) {
            return $this->sendNotFound();
        }

        DB::beginTransaction();

        try {
            $updateBy = $this->createdOrUpdatedByUsername($request);
            $user = $this->repository->updateUser($request, $user, $updateBy);

            DB::commit();

            return $this->sendSuccess($user);

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendBadRequest($e->getMessage());
        }
    }
}
