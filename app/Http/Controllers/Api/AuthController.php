<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use JWTAuth;
use JWTAuthException;

class AuthController extends ApiController
{
    public function login(Request $request)
    {
        $credentials = $request->only('user_name', 'password');
        $token = null;

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->sendNotFound('invalid email or password');
            }
        } catch (JWTAuthException $e) {
            return $this->sendBadRequest('failed to create token');
        }
        $token = ['token' => $token];
        return $this->sendSuccess($token);
    }

    public function getAuthUser(Request $request)
    {
        $user = $this->me($request);
        return $this->sendSuccess($user);
    }
}
