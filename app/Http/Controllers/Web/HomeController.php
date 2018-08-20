<?php

namespace App\Http\Controllers\Web;

class HomeController extends BaseControllerWeb
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'check-permission']);
    }

    public function username()
    {
        return 'user_name';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
