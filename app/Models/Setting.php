<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
 * The attributes that are mass assignable.
 *
 * @var array<int, string>
 */
protected $fillable = [
    'setting',
    'configuration',
    'company',
    'freight',
    'smtp',
    'aftership',
];

        /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'setting' => 'object',
        'configuration' => 'object',
        'company' => 'object',
        'freight' => 'object',
        'smtp' => 'object',
        'aftership' => 'object',
    ];
}
