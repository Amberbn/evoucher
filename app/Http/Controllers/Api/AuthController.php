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
    /**
     *FUNCTION LOGIN USER
     *@return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        //get oly username and password from request body
        $credentials = $request->only('user_name', 'password');
        $token = null;

        try {
            //create jwt token from credential user
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->sendNotFound('invalid email or password');
            }
        } catch (JWTAuthException $e) {
            return $this->sendBadRequest('failed to create token');
        }
        $token = ['token' => $token];
        return $this->sendSuccess($token);
    }

    /**
     *FUNCTION FOR GET PROFILE USER
     *@return \Illuminate\Http\Response
     */
    public function getAuthUser(Request $request)
    {
        //get credential from jwt token to get user login
        $user = $this->me($request);
        return $this->sendSuccess($user);
    }

    /**
     *FUNCTION FOR CHANGE PASSWORD
     *@param Request $request
     *@return \Illuminate\Http\Response
     */
    public function changePassword(ChangePassword $request)
    {
        //get credential from jwt token to get user login
        $me = $this->me($request);
        if (!$me) {
            return $this->sendNotfound();
        }
        try {
            //check if old password diferent from password has
            if (Hash::check($request->input('old_password'), $me->password)) {
                //if true then get user from login user then cahange password
                $user = User::where('user_id', $me->user_id)->first();
                $user->password = Hash::make($request->input('password'));
                $user->save();
                return $this->sendSuccess('password has been change');
            }
            return $this->sendNotfound();

        } catch (\Exception $e) {
            return $this->sendBadRequest($e->getMessage());

        }
    }
}
