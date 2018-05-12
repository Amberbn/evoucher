<?php
namespace App\Repository;
use App\User;

/**
 *
 */
class UserRepository
{
    public function saveUser($request, $createdBy)
    {
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
        $user->created_by_user_name = $createdBy;
        $user->last_updated_by_user_name = $createdBy;
        $user->save();
    }

    public function updateUser($request,$user,$updateBy)
    {
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
        // $user->created_by_user_name = $createdBy;
        $user->last_updated_by_user_name = $updateBy;
        $user->save();
    }
}
