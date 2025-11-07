<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouletteLog extends Model
{
    protected $connection = 'ragnarok'; // Usar conexão ragnarok
    protected $table = 'roulette_log';
    
    // Campos exatos do addon PHP
    protected $fillable = [
        'account_id',
        'char_id',
        'item_id',
        'item_name',
        'spin_date'
    ];
    
    // Não usar timestamps padrão do Laravel (created_at, updated_at)
    public $timestamps = false;
    
    protected $casts = [
        'spin_date' => 'datetime',
    ];
    
    // Relacionamento com User (se necessário)
    public function user()
    {
        return $this->belongsTo(User::class, 'account_id', 'account_id');
    }
}
