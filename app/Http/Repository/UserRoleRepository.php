<?php
namespace App\Repository;

use App\UserRole;

/**
 *
 */
class UserRoleRepository
{
    public function saveUserRole($request, $createdBy)
    {
        $userRole = new UserRole;
        $userRole->user_id = $request->input('user_id');
        $userRole->roles_id = $request->input('roles_id');
        $userRole->created_by_user_name = $createdBy;
        $userRole->save();

        return userRole;
    }

    public function updateUserRole($request, $userRole)
    {
        $userRole->user_id = $request->input('user_id');
        $userRole->roles_id = $request->input('roles_id');
        $userRole->save();

        return userRole;
    }
}
