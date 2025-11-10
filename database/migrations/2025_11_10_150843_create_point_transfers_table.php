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
        Schema::create('point_transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('account_id');
            $table->integer('ygg_points')->default(0);
            $table->integer('vote_points')->default(0);
            $table->integer('cash_points')->default(0);
            $table->timestamp('created_at')->useCurrent();
            
            $table->index('user_id');
            $table->index('account_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_transfers');
    }
};
