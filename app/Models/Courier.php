<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    /** @use HasFactory<\Database\Factories\CourierFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'level',
        'vehicle_type',
        'is_active',
        'registered_at',
    ];

    protected function casts(): array
    {
        return [
            'level' => 'integer',
            'is_active' => 'boolean',
            'registered_at' => 'datetime',
        ];
    }
}
