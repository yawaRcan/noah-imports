<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseCategory extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
    public function admins()
    {
        return $this->belongsTo(Admin::class, 'added_by', 'id');
    }
}
