<?php
namespace App\Repository;

use App\User;
use App\GlobalParameter;
use DB;

/**
 *
 */
class UserRepository
{
    public function getAllUser()
    {
        $users = DB::table('frm_user as us')
            ->join('frm_global_parameters as sal', 'sal.parameters_id', '=', 'us.user_salutation_pid')
            ->where('us.isdelete', '=', 0)
            ->where('sal.parameters_type','=','salutation')
            ->where('us.isactive', '=', true)
            ->select('us.user_name',
                    'us.user_profile_name',
                    'us.user_salutation_pid',
                    'sal.parameters_value as user_salutation_title',
                    'us.user_token',
                    'us.user_password_force_expiration',
                    'us.user_password_expiration_days',
                    'us.user_password_next_expiration_date',
                    'us.user_password_force_reset_on_login',
                    'us.user_password_is_intial',
                    'us.data_sort',
                    'us.isactive',
                    'us.isdelete',
                    'us.created_at',
                    'us.created_by_user_name',
                    'us.updated_at',
                    'us.last_updated_by_user_name')
            ->get();

          return $users;
    }

    public function saveUser($request, $createdBy)
    {
        $user = new User;
        $user->user_name = $request->user_name;
        $user->client_id = $request->client_id;
        $user->user_salutation_pid = $request->user_salutation_pid;
        $user->user_profile_name = $request->user_profile_name;
        $user->password = $request->password;
        $user->user_phone = $request->user_phone;
        $user->user_token = $request->user_token;
        $user->user_password_force_expiration = $request->user_password_force_expiration;
        $user->user_password_expiration_days = $request->user_password_expiration_days;
        $user->user_password_next_expiration_date = $request->user_password_next_expiration_date;
        $user->user_password_force_reset_on_login = $request->user_password_force_reset_on_login;
        $user->user_password_is_intial = $request->user_password_is_intial;
        $user->data_sort = $request->data_sort;
        $user->isactive = $request->isactive;
        $user->isdelete = $request->isdelete;
        $user->created_by_user_name = $createdBy;
        $user->last_updated_by_user_name = $createdBy;
        $user->save();

        return $user;
    }

    public function updateUser($request, $user, $updateBy)
    {
        $user->user_name = $request->user_name;
        $user->client_id = $request->client_id;
        $user->user_salutation_pid = $request->user_salutation_pid;
        $user->user_profile_name = $request->user_profile_name;
        $user->password = $request->password;
        $user->user_phone = $request->user_phone;
        $user->user_token = $request->user_token;
        $user->user_password_force_expiration = $request->user_password_force_expiration;
        $user->user_password_expiration_days = $request->user_password_expiration_days;
        $user->user_password_next_expiration_date = $request->user_password_next_expiration_date;
        $user->user_password_force_reset_on_login = $request->user_password_force_reset_on_login;
        $user->user_password_is_intial = $request->user_password_is_intial;
        $user->data_sort = $request->data_sort;
        $user->isactive = $request->isactive;
        $user->isdelete = $request->isdelete;
        // $user->created_by_user_name = $createdBy;
        $user->last_updated_by_user_name = $updateBy;
        $user->save();

        return $user;
    }
}