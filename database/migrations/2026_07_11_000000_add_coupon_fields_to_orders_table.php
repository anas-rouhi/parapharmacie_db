<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // معلومات الكوبون اللي استعمل الكليان (باش تبان ف الفاتورة)
            $table->string('coupon_code')->nullable()->after('total');       // EX: ANAS
            $table->string('coupon_type')->nullable()->after('coupon_code'); // pourcentage | fixe
            $table->decimal('coupon_value', 10, 2)->nullable()->after('coupon_type');   // 10 (%) أو 15 (DH)
            $table->decimal('discount_amount', 10, 2)->default(0)->after('coupon_value'); // القيمة الحقيقية اللي تنقصات بالدرهم
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['coupon_code', 'coupon_type', 'coupon_value', 'discount_amount']);
        });
    }
};
