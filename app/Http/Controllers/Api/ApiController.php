<?php

namespace App\Http\Controllers\Api;

use DB;
use Illuminate\Datatbase\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use JWTAuth;

class ApiController extends BaseController
{
    use \App\Http\Controllers\Contract\ResponseTrait;

    const STATUS_ACTIVE = 'active';

    /**
     * Get authenticated & autorisation user with Api Token
     * @param Request $request
     * @param active
     * @param \Iluminate\Database\Eloquent\Model
     */

    public function index()
    {
        dd(DB::table('bsn_client')->get());
        // echo phpinfo();
    }

    public function me(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        if (!$user) {
            return $this->sendNotfound();
        }
        return $user;
    }

    public function createdOrUpdatedByUsername($request)
    {
        $user = $this->me($request);
        if ($user) {
            return $user->user_profile_name;
        }

        return null;
    }
}
