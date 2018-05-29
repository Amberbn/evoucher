<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ChangePassword;
use App\Repository\AuthRepository;
use Illuminate\Http\Request;

class AuthController extends ApiController
{
    public function __construct()
    {
        $this->repository = new AuthRepository;
    }

    /**
     *FUNCTION LOGIN USER
     *@return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        return $this->repository->login($request);
    }

    /**
     *FUNCTION FOR GET PROFILE USER
     *@return \Illuminate\Http\Response
     */
    public function getAuthUser(Request $request)
    {
        return $this->repository->getAuthUser($request);
    }

    /**
     *FUNCTION FOR CHANGE PASSWORD
     *@param Request $request
     *@return \Illuminate\Http\Response
     */
    public function changePassword(ChangePassword $request)
    {
        return $this->repository->changePassword($request);
    }
}
