<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            // زدت ليك كاع الخانات لي حتاجيناهم باش تتهنى بمرة
            if (!Schema::hasColumn('produits', 'is_flash_sale')) {
                $table->boolean('is_flash_sale')->default(0);
            }
            if (!Schema::hasColumn('produits', 'prix_flash')) {
                $table->decimal('prix_flash', 8, 2)->nullable();
            }
            if (!Schema::hasColumn('produits', 'flash_sale_end')) {
                $table->string('flash_sale_end')->nullable(); // أو datetime على حساب الفورما
            }
            if (!Schema::hasColumn('produits', 'pack_products')) {
                $table->text('pack_products')->nullable(); // هادي هي لي كانت ناقصة ومسببة الـ Error
            }
        });
    }

    public function down(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->dropColumn(['is_flash_sale', 'prix_flash', 'flash_sale_end', 'pack_products']);
        });
    }
};
