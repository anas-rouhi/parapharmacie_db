<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    protected $fillable = ['produit_id', 'nom_client', 'commentaire', 'note'];

    // علاقة عكسية: كل تعليق تابع لمنتج واحد
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
