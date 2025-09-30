<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MonthlyPerformance extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'year',
        'month',
        'average_score',
        'remarks'
    ];

    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }

    public static function calculateMonthly($playerId, $year, $month)
    {
        $sessions = SessionPerformance::where('player_id', $playerId)
            ->whereYear('session_date', $year)
            ->whereMonth('session_date', $month)
            ->get();

        if ($sessions->isEmpty()) {
            return null;
        }

        $average = round($sessions->avg('score'), 2);

        return self::updateOrCreate(
            ['player_id' => $playerId, 'year' => $year, 'month' => $month],
            ['average_score' => $average]
        );
    }
}
