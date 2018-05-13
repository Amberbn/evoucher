<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ChangePassword;
use App\User;
use Hash;
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

    public function changePassword(ChangePassword $request)
    {
        $me = $this->me($request);
        if (!$me) {
            return $this->sendNotfound();
        }
        try {
            if (Hash::check($request->old_password, $me->password)) {
                $user = User::where('user_id', $me->user_id)->first();
                $user->password = Hash::make($request->password);
                $user->save();
                return $this->sendSuccess('password has been change');
            }
            return $this->sendNotfound();

        } catch (\Exception $e) {
            return $this->sendBadRequest($e->getMessage());

        }
    }
}
