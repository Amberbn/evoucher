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
    }

    /**
     *FUNCTION FOR INSERT USER
     */
    public function store(Request $request)
    {
        $user = $this->repository->saveUser($request);
    }

    /**
     *FUNCTION FOR GET DATA USER BY USERNAME
     */
    public function getUser($userId)
    {
        $user = $this->repository->updateUser($userId);

        return $user;
    }

    /**
     *FUNCTION FOR UPDATE GLOBAL PARAMETER
     */
    public function update(Request $request, $userId)
    {
        $user = $this->repository->updateUser($request,$userId);
    }
}
