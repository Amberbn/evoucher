<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    public function welcome()
    {
        return view('public.welcome');
    }

    public function termsAndCondition()
    {
        return view('public.terms_and_condition');
    }
}
