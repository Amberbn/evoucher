<?php
namespace App\Repository;

use App\Repository\BaseRepository;
use App\UserRole;
use DB;

/**
 *
 */
class UserRoleRepository extends BaseRepository
{
    public function getAllUserRoles()
    {
        $userRoles = DB::table('frm_user_roles as ur')
            ->join('frm_user as u', 'ur.user_roled_id', '=', 'u.user_id')
            ->join('frm_roles as r', 'ur.user_roled_id', '=', 'r.roles_id')
            ->select('u.user_name', 'r.roles_code')
            ->get();

            if (empty($userRoles)) {
                return $this->sendNotfound();
            }
            return $this->sendSuccess($userRoles);
    }

    public function saveUserRole($request)
    {
        DB::beginTransaction();

        try {
            $userRole = new UserRole;
            $userRole->user_id = $request->input('user_id');
            $userRole->roles_id = $request->input('roles_id');
            $userRole->created_by_user_name = $this->loginUsername();
            $userRole->save();

            DB::commit();

            return $this->sendCreated($userRole);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->sendBadRequest($e->getMessage());
        }
    }

    public function getUserRoleById($userRoledId)
    {
        $userRole = UserRole::find($userRoledId);

        if (empty($userRole)) {
            return $this->sendNotfound();
        }

        return $this->sendSuccess($userRole);
    }

    public function updateUserRole($request, $userRoleId)
    {
        $userRole = $this->model::where('user_roled_id', $userRoleId)->first();
        if (!$userRole) {
            return $this->sendNotfound();
        }

        DB::beginTransaction();

        try {
            $userRole->user_id = $request->input('user_id');
            $userRole->roles_id = $request->input('roles_id');
            $userRole->save();

            DB::commit();

            return $this->sendCreated($userRole);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->sendBadRequest($e->getMessage());
        }
    }
}
