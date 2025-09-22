<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Competition extends Model
{
    protected $fillable = ['title', 'description', 'start_date', 'end_date'];

    public function participants(): HasMany
    {
        return $this->hasMany(CompetitionParticipant::class);
    }
}

