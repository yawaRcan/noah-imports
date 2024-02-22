<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupStation extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'country_id',
        'name',
        'email',
        'initial_country',
        'country_code',
        'phone',
        'state',
        'address',
        'status'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
