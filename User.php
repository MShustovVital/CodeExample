<?php

namespace App\Models;

use App\Filters\FilterableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles, FilterableTrait;

    const ADMIN_ROLE_NAME = 'admin';
    const ACADEMY_ROLE_NAME = 'academy';
    const GAINER_ROLE_NAME = 'gainer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden
        = [
            'password',
            'remember_token',
            'created_at',
            'updated_at',
            'is_blocked',
            'email_verified_at',
        ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts
        = [
            'email_verified_at' => 'datetime',
        ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function academy()
    {
        return $this->hasOne(Academy::class);
    }

    public function resetToken()
    {
        return $this->hasOne(PasswordReset::class);
    }

}
