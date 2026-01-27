<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'lease_id',
        'amount',
        'payment_date',
        'method',
    ];

    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }
}
