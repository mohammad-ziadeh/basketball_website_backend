<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Achievement extends Model
{
    protected $fillable = ['player_id', 'points', 'badge_name', 'reward'];

    public function player(): BelongsTo
    {
        return $this->belongsTo(User::class, 'player_id');
    }
}

