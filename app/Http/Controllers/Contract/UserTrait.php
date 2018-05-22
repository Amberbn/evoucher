<?php

namespace App\Http\Controllers\Contract;

use App\GlobalParameter;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;

trait UserTrait
{
    /**
     *FUNCTION GET PROFILE
     *@param Request $request
     *@return \Illuminate\Http\Response
     */
    public function me()
    {
        //claim auth trough jwt to get user
        $user = JWTAuth::toUser(request()->token);
        if (!$user) {
            return $this->sendNotfound();
        }
        //get return id for user and eagerload with client object
        $userClient = User::where('user_id', $user->user_id)
            ->with('client')->first();

        return $userClient;
    }

    /**
     *FUNCTION GET SPRINT IDENTIFIER
     *@return \Illuminate\Http\Response
     */
    public function sprintParamId()
    {
        //get object spt=rint from global parameter
        $sprint = GlobalParameter::where('parameters_type', '=', 'client_category')
            ->where('parameters_code', '=', 'SPRINT')
            ->select('parameters_id', 'parameters_code', 'parameters_type')
            ->first();
        return $sprint;
    }

    public function isGroupSprint()
    {
        $userClientPid = $this->me()->client->client_category_pid;
        $sprintClientPid = $this->sprintParamId()->parameters_id;
        if ($userClientPid == $sprintClientPid) {
            return true;
        }
        return false;
    }

    /**
     *FUNCTION GET PROFILE
     *@param Request $request
     *@return String
     */
    public function createdOrUpdatedByUsername()
    {
        //get user data login
        $user = $this->me(request());
        if ($user) {
            //set user profile name as return string
            return $user->user_profile_name;
        }

        return null;
    }

}
