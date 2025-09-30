<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionPerformance extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'session_date',
        'score',
        'remarks'
    ];

    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }
}
