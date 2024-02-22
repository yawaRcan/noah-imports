<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'country_id',
        'timezone_id',
        'first_name',
        'last_name',
        'email',
        'username',
        'password',
        'customer_no',
        'phone',
        'image',
        'lang',
        'initial_country',
        'country_code',
        'status',
        'gender',
        'theme',
        'company',
        'ref_no',
        'ip',
        'invite_no',
        'role',
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

    public function country() 
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function timezone() 
    {
        return $this->belongsTo(TimeZone::class, 'timezone_id');
    }

    public function transactions()
    {
        return $this->hasMany(Wallet::class,'morphable_id');
    }
    public function filterTransactions($status)
    {
        return $this->transactions()->where('status', $status);
    }
    public function validTransactions()
    {
        return $this->transactions()->where('status', 'approved');
    }
    public function credit()
    {
        return $this->validTransactions()
                    ->where('type', 'credit')
                    ->sum('amount_converted');
    }
    public function debit()
    {
        return $this->validTransactions()
                    ->where('type', 'debit')
                    ->sum('amount_converted');
    }
    public function balance()
    {
        return $this->credit() - $this->debit();
    }
    public function allowWithdraw($amount) : bool
    {
        return $this->balance() >= $amount;
    }
}
