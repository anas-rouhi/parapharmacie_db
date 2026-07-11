<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Hna k-n-q-o-l-o l-Laravel l-colonnes li n-q-d-r-o n-b-d-l-o
    protected $fillable = ['user_id', 'nom_complet', 'telephone', 'adresse', 'total', 'status'];    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    protected $casts = [
        'products_json' => 'array',
    ];
}
