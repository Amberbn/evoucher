<?php

namespace App\Listeners;

use App\LoginActivity;
use Illuminate\Auth\Events\Login;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        LoginActivity::create([
            'user_id' => $event->user->user_id,
            'user_name' => $event->user->user_name,
            'login_logs_hostname' => \Illuminate\Support\Facades\Request::getHttpHost(),
            'login_logs_agent' => \Illuminate\Support\Facades\Request::header('User-Agent'),
            'login_logs_ip_address' => \Illuminate\Support\Facades\Request::ip(),
            'login_logs_timestamp' => NOW(),
        ]);
    }
}
