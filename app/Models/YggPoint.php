<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YggPoint extends Model
{
    protected $fillable = [
        'user_id',
        'points',
    ];

    protected $casts = [
        'points' => 'integer',
    ];

    public $incrementing = false;
    protected $primaryKey = 'user_id';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Adicionar pontos Ygg para um usuário
     */
    public static function addPoints($userId, $points)
    {
        $yggPoint = self::firstOrCreate(
            ['user_id' => $userId],
            ['points' => 0]
        );
        
        $yggPoint->increment('points', $points);
        
        return $yggPoint;
    }

    /**
     * Obter saldo de pontos Ygg de um usuário
     */
    public static function getPoints($userId)
    {
        $yggPoint = self::where('user_id', $userId)->first();
        return $yggPoint ? $yggPoint->points : 0;
    }

    /**
     * Deduzir pontos Ygg de um usuário
     */
    public static function deductPoints($userId, $points)
    {
        $yggPoint = self::where('user_id', $userId)->first();
        
        if (!$yggPoint || $yggPoint->points < $points) {
            return false;
        }
        
        $yggPoint->decrement('points', $points);
        return true;
    }
}
