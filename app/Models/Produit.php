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
        'prix_achat',
        'prix',
        'category_id',
        'stock',
        'description',
        'image',
        'prix_flash',
        'quantite_flash_vendue',
        'flash_sale_end',
        'is_flash_sale' // 👈 تأكد من زيادة هادو هنا
    ];
    public $timestamps = true;

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function categorie()
    {
        // هاد المنتج ينتمي لـ catégorie واحدة
        return $this->belongsTo(Category::class, 'category_id');
    }


    public function avis()
    {
        return $this->hasMany(Avis::class)->latest(); // كيجيب التـعاليق الجديدة هي الأولى
    }
}