<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginActivity extends Model
{
    protected $table = 'frm_login_logs';
    protected $primaryKey = 'logs_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'user_name',
        'login_logs_hostname',
        'login_logs_ip_address',
        'login_logs_agent',
        'login_logs_timestamp',
    ];
}
