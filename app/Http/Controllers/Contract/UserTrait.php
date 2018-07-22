<?php

namespace App\Http\Controllers\Contract;

use App\GlobalParameter;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $user = null;
        //claim auth trough jwt to get user
        if (!Auth::user()) {
            $user = JWTAuth::toUser(request()->token);
        } elseif (Auth::user()) {
            $user = Auth::user();
        } elseif (!$user) {
            return $this->sendNotfound();
        }
        //get return id for user and eagerload with client object
        $userClient = User::where('user_id', $user->user_id)
            ->with('client')->first();
        $userClient = $this->prepareUserdata($userClient);
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

    /**
     *FUNCTION GET COMPANY IDENTIFIER
     *@return \Illuminate\Http\Response
     */
    public function companyParamId($code)
    {
        //get object spt=rint from global parameter
        $company = GlobalParameter::where('parameters_type', '=', 'client_category')
            ->where('parameters_code', '=', $code)
            ->select('parameters_id', 'parameters_code', 'parameters_type')
            ->first();
        return $company;
    }

    public function isGroupSprint()
    {
        $userClientPid = $this->me()['client_category_pid'];
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
    public function loginUsername()
    {
        //get user data login
        $user = $this->me(request());
        if ($user) {
            //set user profile name as return string
            return $user['user_profile_name'];
        }

        return null;
    }

    public function prepareUserdata($userClient)
    {
        return [
            'user_id' => $userClient->user_id,
            'user_profile_image_url' => $userClient->user_profile_image_url,
            'client_id' => $userClient->client_id,
            'user_profile_name' => $userClient->user_profile_name,
            'user_phone' => $userClient->user_phone,
            'client_id' => $userClient->client->client_id,
            'client_category_pid' => $userClient->client->client_category_pid,
            'client_code' => $userClient->client->client_code,
            'client_is_also_merchant' => $userClient->client->client_is_also_merchant,
            'client_allow_postpaid' => $userClient->client->client_allow_postpaid,
            'client_name' => $userClient->client->client_name,
            'client_legal_name' => $userClient->client->client_legal_name,
            'client_billing_address_line_1' => $userClient->client->client_billing_address_line_1,
            'client_billing_address_line_2' => $userClient->client->client_billing_address_line_2,
        ];

    }

}
