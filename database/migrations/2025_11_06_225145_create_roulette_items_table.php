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
        Schema::create('roulette_items', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nome do item (ex: "Poção de Cura")
            $table->integer('item_id'); // ID do item no jogo
            $table->integer('quantity')->default(1); // Quantidade do item
            $table->integer('probability'); // Peso da probabilidade (1-100)
            $table->string('image')->nullable(); // URL da imagem do item
            $table->boolean('is_active')->default(true); // Se o item está ativo na roleta
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roulette_items');
    }
};
