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

        return $userRoles;

    }
    public function saveUserRole($request)
    {
        $userRole = new UserRole;
        $userRole->user_id = $request->input('user_id');
        $userRole->roles_id = $request->input('roles_id');
        $userRole->created_by_user_name = $this->loginUsername();
        $userRole->save();

        return $userRole;
    }

    public function getUserRoleById($userRoledId)
    {
        $userRole = UserRole::find($userRoledId);
        // $userRole = DB::table('frm_user_roles as ur')
        //     ->join('frm_user as u', 'ur.user_roled_id', '=', 'u.user_id')
        //     ->join('frm_roles as r', 'ur.user_roled_id', '=', 'r.roles_id')
        //     ->select('u.user_name', 'r.roles_code')
        //     ->where('ur.user_roled_id', $userRoledId)
        //     ->first();

        return $userRole;
    }

    public function updateUserRole($request, $userRole)
    {
        $userRole->user_id = $request->input('user_id');
        $userRole->roles_id = $request->input('roles_id');
        $userRole->save();

        return $userRole;
    }
}
