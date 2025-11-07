<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouletteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'spin_cost',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Pegar as configurações atuais (sempre usa o primeiro registro)
    public static function current()
    {
        return self::firstOrCreate(
            ['id' => 1],
            ['spin_cost' => 100, 'is_active' => true]
        );
    }

    // Verificar se a roleta está ativa
    public static function isActive()
    {
        return self::current()->is_active;
    }

    // Pegar o custo do giro
    public static function getSpinCost()
    {
        return self::current()->spin_cost;
    }
}