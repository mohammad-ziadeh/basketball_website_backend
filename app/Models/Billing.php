<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'total_income',
        'total_expenses',
        'final_payment',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function expenses()
    {
        return $this->hasMany(BillingExpense::class);
    }
}
