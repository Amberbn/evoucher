<?php
namespace App\Repository;

use App\Repository\BaseRepository;
use App\User;
use App\UserLog;
use Hash;
use Illuminate\Http\Request;
use JWTAuth;
use JWTAuthException;

class AuthRepository extends BaseRepository
{
    /**
     *FUNCTION LOGIN USER
     *@return \Illuminate\Http\Response
     */
    public function login($request)
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
        if ($token) {
            $this->createLoginLog($request, $credentials);
        }

        return $this->sendSuccess($token);
    }

    /**
     *FUNCTION FOR GET PROFILE USER
     *@return \Illuminate\Http\Response
     */
    public function getAuthUser($request)
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
    public function changePassword($request)
    {
        //get credential from jwt token to get user login
        $me = $this->me($request);

        if (!$me) {
            return $this->sendNotfound();
        }

        try {
            //check if old password diferent from password has
            $user = User::where('user_id', $me['user_id'])->first();
            if (Hash::check($request->input('old_password'), $user->password)) {
                //if true then get user from login user then cahange password
                $user->password = Hash::make($request->input('password'));
                $user->save();
                return $this->sendSuccess('password has been change');
            }
            return $this->sendNotfound();

        } catch (\Exception $e) {
            return $this->throwErrorException($e);

        }
    }

    /**
     *FUNCTION FOR LOGGING USER LOGIN
     *@param Request $request
     *@param Array $credentials
     *@return void
     */
    public function createLoginLog(Request $request, $credentials)
    {
        //logging user login
        $user = User::where('user_name', $credentials['user_name'])->first();
        $log = new UserLog;
        $log->user_id = $user->user_id;
        $log->user_name = $user->user_name;
        $log->login_logs_ip_address = $request->ip();
        $log->login_logs_agent = $request->header('User-Agent');
        $log->login_logs_hostname = $request->getHttpHost();
        $log->login_logs_timestamp = NOW();
        $log->save();

    }
}
