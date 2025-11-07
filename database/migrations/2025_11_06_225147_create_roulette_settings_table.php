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
        Schema::create('roulette_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('spin_cost')->default(100); // Custo em Cash Points por giro
            $table->boolean('is_active')->default(true); // Se a roleta está ativa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roulette_settings');
    }
};
