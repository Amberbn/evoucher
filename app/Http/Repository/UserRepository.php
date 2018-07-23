<?php
namespace App\Repository;

use App\Repository\BaseRepository;
use App\User;
use App\UserRole;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Hash;

/**
 *
 */
class UserRepository extends BaseRepository
{
    public function getAllUser($userId = null)
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
            ->join('frm_global_parameters as salutation', function ($join) use ($table) {
                $join
                    ->on('salutation.parameters_id', '=', $table . '.user_salutation_pid')
                    ->where('salutation.parameters_type', '=', 'salutation');
            })
            ->leftJoin('frm_user_roles as user_roles', function ($join) use ($table) {
                $join
                    ->on('user_roles.user_id', '=', $table . '.user_id');
            })
            ->leftJoin('frm_roles as roles', function ($join) use ($table) {
                $join
                    ->on('roles.roles_id', '=', 'user_roles.roles_id');
            });
            $users->leftJoin('vw_user_login_last_logs as login_logs', function ($join) use ($table) {
                $join
                    ->on('login_logs.user_id', '=', $table . '.user_id')
                    ->orderBy('login_logs.login_logs_timestamp');
            });

        if ($userId) {
            $users->where($table . '.user_id', '=', $userId);
        }

        if (!$this->isGroupSprint()) {
            $users->where('client.client_category_pid', '=', $this->me()['client_category_pid']);
        }

        $users->where($table . '.isactive', '=', true);
        $users->where($table . '.isdelete', '=', false);

        $users->select(
            $table . '.user_id',
            $table . '.user_name',
            $table . '.user_profile_name',
            $table . '.user_salutation_pid',
            $table . '.user_phone',
            $table . '.user_password_force_expiration',
            $table . '.user_password_expiration_days',
            $table . '.user_password_next_expiration_date',
            $table . '.user_password_force_reset_on_login',
            $table . '.user_password_is_intial',
            $table . '.user_profile_image_url',
            $table . '.data_sort',
            $table . '.isactive',
            $table . '.isdelete',
            $table . '.created_at',
            $table . '.created_by_user_name',
            $table . '.updated_at',
            $table .'.last_updated_by_user_name',
            'salutation.parameters_value as user_salutation_title',
            'login_logs.login_logs_timestamp',
            'company.parameters_value as company',
            'roles.roles_id',
            'roles.roles_description as user_roles'
        );

        if (empty($users->get()->toarray())) {
            return $this->sendNotfound();
        }

        return $this->sendSuccess($users->get());
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
        $users->leftJoin('vw_user_login_last_logs as login_logs', function ($join) use ($table) {
            $join
                ->on('login_logs.user_id', '=', $table . '.user_id')
                ->orderBy('login_logs.login_logs_timestamp');
        });
        if (!$this->isGroupSprint()) {
            $users->where('client.client_category_pid', '=', $this->me()['client_category_pid']);
        }

        $users->where($table . '.isactive', '=', true);
        $users->where($table . '.isdelete', '=', false);

        $users->select(
            $table . '.user_id',
            $table . '.user_profile_name',
            'login_logs.login_logs_timestamp',
            $table . '.user_phone',
            'company.parameters_value as company',
            'roles.roles_description as user_roles'
        );
        return $this->sendSuccess($users->get());
    }

    public function saveUser($request)
    {
        DB::beginTransaction();

        try {

            $settingExpirationDays = $this->getConfig('user_password_expiration_days') ?: 90;
            $current = Carbon::now();
            // add 90 days to the current time
            $expiratonDays = $current->addDays($settingExpirationDays);
            $forceExpiration = $this->getConfig('user_password_force_expiration');
            $sprintClientId = $this->getConfig('sprint_client_id');

            $user = new User;
            $user->user_name = $request->input('user_name');
            $user->client_id = $request->input('client_id') ?: $sprintClientId;
            $user->user_salutation_pid = $request->input('user_salutation_pid');
            $user->user_profile_name = $request->input('user_profile_name');
            $user->password = $request->input('password') ?: Hash::make('Passw0rd1');
            $user->user_phone = $request->input('user_phone');
            $user->user_token = $request->input('user_token');
            $user->user_password_force_expiration = $request->input('user_password_force_expiration') ?: $forceExpiration;
            $user->user_password_expiration_days = $settingExpirationDays;
            $user->user_password_next_expiration_date = $expiratonDays;
            $user->user_password_force_reset_on_login = $request->input('user_password_force_reset_on_login') ?: true;
            $user->user_password_is_intial = true;
            $user->data_sort = $request->input('data_sort') ?: 1000;
            $user->isactive = $request->input('isactive') ?: true;
            $user->isdelete = $request->input('isdelete') ?: false;
            $user->created_by_user_name = $this->loginUsername();
            $user->last_updated_by_user_name = $this->loginUsername();
            $user->save();

            if ($user) {
                $userRole = new UserRole;
                $userRole->user_id = $user->user_id;
                $userRole->roles_id = $request->input('roles_id');
                $userRole->created_by_user_name = $this->loginUsername();
                $userRole->created_at = now();
                $userRole->save();
            }

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
            $user->user_salutation_pid = $request->input('user_salutation_pid');
            $user->user_profile_name = $request->input('user_profile_name');
            $user->user_phone = $request->input('user_phone');
            $user->last_updated_by_user_name = $this->loginUsername();
            $user->save();
            $role = UserRole::where('user_id',$user->user_id)->first();
            
            if($role) {
                $role->delete();
            }

            if ($user) {
                $userRole = new UserRole;
                $userRole->user_id = $user->user_id;
                $userRole->roles_id = $request->input('roles_id');
                $userRole->created_by_user_name = $this->loginUsername();
                $userRole->created_at = now();
                $userRole->save();
            }

            DB::commit();

            return $this->sendSuccess($user);

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendBadRequest($e->getMessage());
        }
    }

    public function getListUsername()
    {
        $user = User::select('user_id', 'user_name')->get();
        if (!$user) {
            return $this->sendNotfound();
        }

        return $this->sendSuccess($user);
    }
}
