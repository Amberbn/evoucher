<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use JWTAuthException;
use App\User;

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

     public function getAuthUser(Request $request){
        $user = $this->me($request); 
        $response = [
            'email' => $user->user_name,
            'client_code' => $user->client_code
        ];      
        return $this->sendSuccess($response);
    }
}
