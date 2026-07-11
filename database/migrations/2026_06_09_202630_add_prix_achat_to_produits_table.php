<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            // نزيدو ثمن الشراء ويكون اختياري ف اللول باش ما يخسرش المنتجات لي كاينين ديجا
            $table->decimal('prix_achat', 10, 2)->nullable()->after('prix');
        });
    }

    public function down(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->dropColumn('prix_achat');
        });
    }
};
