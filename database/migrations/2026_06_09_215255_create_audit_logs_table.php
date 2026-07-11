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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // شكون دار الحركة (null يلا كان زائر عادي حاول يدخل)
            $table->string('user_name')->nullable(); // اسم المستخدم باش يبقى مسجل وخا يتحذف الحساب
            $table->string('action'); // نوع الحركة: Login, Create, Update, Delete
            $table->text('description'); // تفاصيل الحركة
            $table->string('ip_address')->nullable(); // الـ IP ديالو
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
