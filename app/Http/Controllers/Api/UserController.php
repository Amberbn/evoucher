<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\User;
use DB;

class UserController extends ApiController
{
    public function getUsers()
    {
        $users = User::active()->get();
        if (!$users)
        {
            return $this->sendNotfound();
        }

        return $this->sendSuccess($users);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $user = new User;
            $user->user_name = $request->user_name;
            $user->client_code = $request->client_code;
            $user->user_salutation_pid = $request->user_salutation_pid;
            $user->user_profile_name = $request->user_profile_name;
            $user->user_password = $request->user_password;
            $user->user_token = $request->user_token;
            $user->user_password_force_expiration = $request->user_password_force_expiration;
            $user->user_password_expiration_days = $request->user_password_expiration_days;
            $user->user_password_next_expiration_date = $request->user_password_next_expiration_date;
            $user->user_password_force_reset_on_login = $request->user_password_force_reset_on_login;
            $user->user_password_is_intial = $request->user_password_is_intial;
            $user->data_sort = $request->data_sort;
            $user->isactive = $request->isactive;
            $user->isdelete = $request->isdelete;
            $user->created_by_user_name = $request->created_by_user_name;
            $user->last_updated_by_user_name = $request->last_updated_by_user_name;
            $user->save();

            DB::commit();

            return $this->sendCreated($user);

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendBadRequest($e->getMessage());
        }

    }
}
