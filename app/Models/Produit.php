<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    // HADA HUWA L-HAL: Kat-dir list dyal ga3 l-fields li bghiti t-3emmer
    protected $fillable = [
        'nom',
        'description',
        'prix',
        'category_id',
        'image',
        'stock'
    ];
    public $timestamps = true;

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}