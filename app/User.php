<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'frm_user';

    protected $fillable = [
        'user_name',
        'client_code',
        'user_salutation_pid',
        'user_profile_name',
        'user_password',
        'user_token',
        'user_password_force_expiration',
        'user_password_expiration_days',
        'user_password_next_expiration_date',
        'user_password_force_reset_on_login',
        'user_password_is_intial',
        'data_sort',
        'isactive',
        'isdelete',
        'created_by_user_name',
        'last_updated_by_user_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_password',
        'password'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
