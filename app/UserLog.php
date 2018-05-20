<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    public $timestamps = false;
    protected $table = 'frm_login_logs';
    protected $primaryKey = 'logs_id';
    protected $fillable = [
        'user_id',
        'user_name',
        'login_logs_hostname',
        'login_logs_ip_address',
        'login_logs_agent',
        'login_logs_timestamp',
    ];
}
