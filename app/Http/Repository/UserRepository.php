<?php
namespace App\Repository;

use App\Repository\BaseRepository;
use App\User;
use DB;

/**
 *
 */
class UserRepository extends BaseRepository
{
    public function getAllUser()
    {
        $users = DB::table('frm_user as us')
            ->join('frm_global_parameters as sal', 'sal.parameters_id', '=', 'us.user_salutation_pid')
            ->where('us.isdelete', '=', 0)
            ->where('sal.parameters_type', '=', 'salutation')
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

        if (!$users) {
            return $this->sendNotfound();
        }

        return $this->sendSuccess($users);
    }

    public function userIndexDatatable()
    {
        $table = (new User)->getTable();
        $users = (new User)
            ->join('bsn_client as client', function ($join) use ($table) {
                $join
                    ->on('client.client_id', '=', $table . '.client_id');
            })
            ->join('frm_global_parameters as company', function ($join) use ($table) {
                $join
                    ->on('company.parameters_id', '=', 'client.client_category_pid')
                    ->where('company.parameters_type', '=', 'client_category');
            })
            ->leftJoin('frm_user_roles as user_roles', function ($join) use ($table) {
                $join
                    ->on('user_roles.user_id', '=', $table . '.user_id');
            })
            ->leftJoin('frm_roles as roles', function ($join) use ($table) {
                $join
                    ->on('roles.roles_id', '=', 'user_roles.roles_id');
            });
        // ->leftJoin('frm_login_logs as login_logs', function ($join) use ($table) {
        //     $join
        //         ->on('login_logs.user_id', '=', $table . '.user_id')
        //         ->orderBy('login_logs.login_logs_timestamp')
        //         ->take(1);
        // })->groupBy('login_logs.user_id');
        if (!$this->isGroupSprint()) {
            $users->where($table . '.client_category_pid', '=', $this->me()['client_category_pid']);
        }

        $users->where($table . '.isactive', '=', true);
        $users->where($table . '.isdelete', '=', false);

        $users->select(
            $table . '.user_id',
            $table . '.user_profile_name',
            $table . '.user_phone',
            'company.parameters_value as company',
            'roles.roles_description as user_roles'
        );
        return $users->get();
    }

    public function saveUser($request)
    {
        DB::beginTransaction();

        try {
            $user = new User;
            $user->user_name = $request->input('user_name');
            $user->client_id = $request->input('client_id');
            $user->user_salutation_pid = $request->input('user_salutation_pid');
            $user->user_profile_name = $request->input('user_profile_name');
            $user->password = $request->input('password');
            $user->user_phone = $request->input('user_phone');
            $user->user_token = $request->input('user_token');
            $user->user_password_force_expiration = $request->input('user_password_force_expiration');
            $user->user_password_expiration_days = $request->input('user_password_expiration_days');
            $user->user_password_next_expiration_date = $request->input('user_password_next_expiration_date');
            $user->user_password_force_reset_on_login = $request->input('user_password_force_reset_on_login');
            $user->user_password_is_intial = $request->input('user_password_is_intial');
            $user->data_sort = $request->input('data_sort');
            $user->isactive = $request->input('isactive') ?: true;
            $user->isdelete = $request->input('isdelete') ?: false;
            $user->created_by_user_name = $this->loginUsername();
            $user->last_updated_by_user_name = $this->loginUsername();
            $user->save();

            DB::commit();

            return $this->sendCreated($user);

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendBadRequest($e->getMessage());
        }
    }

    public function getUserById($userId)
    {
        $user = $this->model::active()->where('user_id', $userId)->first();
        if (!$user) {
            return $this->sendNotfound();
        }

        return $this->sendSuccess($user);
    }

    public function updateUser($request, $userId)
    {
        $user = User::active()->where('user_id', $userId)->first();
        if (!$user) {
            return $this->sendNotFound();
        }

        DB::beginTransaction();

        try {
            $user->user_name = $request->input('user_name');
            $user->client_id = $request->input('client_id');
            $user->user_salutation_pid = $request->input('user_salutation_pid');
            $user->user_profile_name = $request->input('user_profile_name');
            $user->password = $request->input('password');
            $user->user_phone = $request->input('user_phone');
            $user->user_token = $request->input('user_token');
            $user->user_password_force_expiration = $request->input('user_password_force_expiration');
            $user->user_password_expiration_days = $request->input('user_password_expiration_days');
            $user->user_password_next_expiration_date = $request->input('user_password_next_expiration_date');
            $user->user_password_force_reset_on_login = $request->input('user_password_force_reset_on_login');
            $user->user_password_is_intial = $request->input('user_password_is_intial');
            $user->data_sort = $request->input('data_sort');
            $user->isactive = $request->input('isactive') ?: true;
            $user->isdelete = $request->input('isdelete') ?: false;
            $user->last_updated_by_user_name = $this->loginUsername();
            $user->save();

            DB::commit();

            return $this->sendSuccess($user);

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendBadRequest($e->getMessage());
        }
    }
}
