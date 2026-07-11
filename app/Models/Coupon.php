<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'valeur',
        'montant_minimum',
        'limite_utilisation',
        'total_utilisations',
        'date_expiration',
        'is_active',
    ];

    protected $casts = [
        'date_expiration' => 'date',
        'is_active' => 'boolean',
    ];
}
