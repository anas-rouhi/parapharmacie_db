<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // user_id i-koun nullable (OUI) bach i-qbel l-visiteur
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

            $table->string('nom_complet');
            $table->string('telephone');
            $table->text('adresse');
            $table->decimal('total', 10, 2);
            $table->string('status')->default('en_attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
