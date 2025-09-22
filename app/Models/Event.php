<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = ['title', 'description', 'start_date', 'end_date', 'location', 'requires_confirmation'];

    public function confirmations(): HasMany
    {
        return $this->hasMany(EventConfirmation::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function performanceReports(): HasMany
    {
        return $this->hasMany(PerformanceReport::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}

