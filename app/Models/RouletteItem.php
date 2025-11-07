<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouletteItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'item_id',
        'quantity',
        'probability',
        'image',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope para pegar apenas itens ativos
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Pegar todos os itens ativos para a roleta
    public static function getActiveItems()
    {
        return self::active()->get();
    }
}