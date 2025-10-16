<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingExpense extends Model
{
    use HasFactory;

    protected $fillable = ['billing_id', 'name', 'amount'];

    public function billing()
    {
        return $this->belongsTo(Billing::class);
    }
}
