<?php
namespace App\Repository;

use Hash;
use JWTAuth;
use App\User;
use App\Client;
use App\UserLog;
use JWTAuthException;
use Illuminate\Http\Request;
use App\Repository\BaseRepository;
use Illuminate\Support\Facades\Auth;

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
        $checkUser = $this->checkUser();

        if(!$checkUser) {
            return $this->sendBadRequest('These credentials do not match our records.');
        }

        if ($token) {
            $this->createLoginLog($request, $credentials);
        }

        return $this->sendSuccess($token);
    }

    public function checkUser() {
        if (Auth::check()) {
            $user = Auth::user();
            $userIsActive = $user->isactive != 1;
            $userIsDelete = $user->isdelete != 0;

            if(($userIsActive || $userIsDelete)) {
                return false;
            }

            $client = Client::where('client_id', $user->client_id)->first();

            if (!$client) {
                return false;
            }

            $clientIsactive = $client->isactive != 1;
            $clientIsDelete = $client->isdelete != 0;

            if (($clientIsactive || $clientIsDelete)) {
                return false;
            }

            return true;
        }

        return false;
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
