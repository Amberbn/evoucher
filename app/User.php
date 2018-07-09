<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'frm_user';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_profile_image_url',
        'user_name',
        'client_id',
        'user_salutation_pid',
        'user_profile_name',
        'password',
        'user_phone',
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
        'last_updated_by_user_name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_password',
        'password',
    ];

    public function scopeActive($query)
    {
        return $query->where('isactive', '=', true);
    }

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

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');

    }
}
