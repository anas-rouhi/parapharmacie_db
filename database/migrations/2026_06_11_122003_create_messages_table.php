<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $class) {
            $class->id();
            $class->string('nom');
            $class->string('email');
            $class->string('sujet')->nullable(); // زدنا nullable باش يلا ما صيفطوش من برا ما يوقعش إيرور
            $class->text('message');
            $class->boolean('is_read')->default(false); // هادي مهمة للـ Statut (Nouveau/Lu)
            $class->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};