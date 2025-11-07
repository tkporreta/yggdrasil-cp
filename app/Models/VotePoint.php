<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VotePoint extends Model
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

    public static function addPoints($userId, $points)
    {
        $votePoint = self::firstOrCreate(
            ['user_id' => $userId],
            ['points' => 0]
        );
        
        $votePoint->increment('points', $points);
        
        return $votePoint;
    }

    public static function getPoints($userId)
    {
        $votePoint = self::where('user_id', $userId)->first();
        return $votePoint ? $votePoint->points : 0;
    }

    public static function deductPoints($userId, $points)
    {
        $votePoint = self::where('user_id', $userId)->first();
        
        if (!$votePoint || $votePoint->points < $points) {
            return false;
        }
        
        $votePoint->decrement('points', $points);
        return true;
    }
}
