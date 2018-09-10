<?php

namespace App\Http\Controllers\Web;

use App\Repository\AuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends BaseControllerWeb
{
    public function __construct()
    {
        $this->repository = new AuthRepository;
    }

    public function index()
    {
        return view('account.change_password');
    }

    public function forceLogout(){
        Auth::logout();
        return redirect()->route('login');
    }

    public function changePassword(Request $request)
    {
        $response = $this->repository->changePassword($request);
        $responseCode = $this->getResponseCodeFromJson($response);
        if ($responseCode == 404) {
            return back()->withErrors(['message' => ['The old password is incorrect. Please retype your password.']]);
        } else if ($responseCode == 200) {
            Auth::logout();
            return redirect()->route('login')->with('message', 'your password has been changed please relogin');
        }
    }
}
