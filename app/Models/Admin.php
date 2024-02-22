<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'branch_id',
        'country_id',
        'timezone_id',
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'phone',
        'image',
        'lang',
        'initial_country',
        'country_code',
        'status',
        'gender',
        'theme',
        'dob',
        'last_login',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function shipping()
    {
        return $this->morphMany('App\Models\ShippingAddress', 'morphable');
    }

    public function wallet()
    {
        return $this->morphMany('App\Models\Wallet', 'morphable');
    }

}
