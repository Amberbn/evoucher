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
        $userRole->user_name = $request->user_name;
        $userRole->roles_code = $request->roles_code;
        $userRole->created_by_user_name = $createdBy;
        $userRole->save();
    }

    public function updateUserRole($request,$userRole)
    {
        $userRole->user_name = $request->user_name;
        $userRole->roles_code = $request->roles_code;
        // $userRole->created_by_user_name = $createdBy;
        $userRole->save();
    }
}
