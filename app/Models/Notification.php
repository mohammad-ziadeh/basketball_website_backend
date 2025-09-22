<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = ['title', 'message', 'type', 'target_role', 'recipient_id'];

    // The target_role is now just a string (enum)
    // Example query: Notification::where('target_role', 'coach')->get();

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}

