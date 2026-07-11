<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // الـ Code اللي غايدخل الـ Client بحال PARA20
            $table->enum('type', ['pourcentage', 'fixe']); // واش % ولا قيمة مادية بالدرهم
            $table->decimal('valeur', 8, 2); // القيمة (مثلا 20 في المائة أو 50 درهم)
            $table->decimal('montant_minimum', 8, 2)->default(0); // الحد الأدنى للشراء باش يخدم
            $table->integer('limite_utilisation')->nullable(); // عدد المرات الأقصى لاستعمال هاد الكود
            $table->integer('total_utilisations')->default(0); // الـ Counter شحال من مرة تستعمل فعليا
            $table->date('date_expiration'); // التاريخ فاش غيموت الكود تلقائيا
            $table->boolean('is_active')->default(true); // واش مفعل أو حابسو الـ Admin مؤقتا
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
