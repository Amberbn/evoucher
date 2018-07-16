<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

class AuthController extends WebController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $me = $this->getMe();
        if ($me['status_code'] != '401') {
            return view('home');
        }

        return view('layouts.auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $body = [
            'user_name' => $request->input('user_name'),
            'password' => $request->input('password'),
            'is_login_request' => true,
        ];
        $response = $this->guzzlePost('login', $body);
        if ($response['status_code'] == 200) {
            $token = $response['data']['token'];
            if (!$this->isNullOrEmptyString($token)) {
                $request->session()->put('token', $token);
                return view('home');
            }
        }
        return back()->with('message', 'Your username or password did not exist');
    }
    public function logout()
    {
        session()->forget('token');
        return redirect()->route('auth.form');
    }
}
