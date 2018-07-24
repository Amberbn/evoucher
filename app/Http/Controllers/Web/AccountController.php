<?php

namespace App\Http\Controllers\Web;

class AccountController extends BaseControllerWeb
{
    public function changePassword()
    {
        return view('account.change_password');
    }
}
