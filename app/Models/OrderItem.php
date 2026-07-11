<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    public function produit()
    {
        // بدلنا 'produit_id' لـ 'product_id' باش تطابق مع الداتابيز ديالك
        return $this->belongsTo(Produit::class, 'product_id');
    }
}
