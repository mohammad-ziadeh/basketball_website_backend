<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'coach_id',
        'start_date',
        'end_date'
    ];

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function players()
    {
        return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id');
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
