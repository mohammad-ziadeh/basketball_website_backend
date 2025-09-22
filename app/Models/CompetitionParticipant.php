<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompetitionParticipant extends Model
{
    protected $fillable = ['competition_id', 'player_id'];

    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(User::class, 'player_id');
    }
}

