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
        // Criar tabela no banco ragnarok seguindo estrutura exata do addon PHP
        DB::connection('ragnarok')->statement("
            CREATE TABLE IF NOT EXISTS roulette_log (
                id INT(11) NOT NULL AUTO_INCREMENT,
                account_id INT(11) NOT NULL,
                char_id INT(11) NOT NULL,
                item_id INT(11) NOT NULL,
                item_name VARCHAR(50) NOT NULL,
                spin_date DATETIME NOT NULL,
                PRIMARY KEY (id),
                KEY account_id (account_id),
                KEY char_id (char_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::connection('ragnarok')->statement("DROP TABLE IF EXISTS roulette_log");
    }
};
