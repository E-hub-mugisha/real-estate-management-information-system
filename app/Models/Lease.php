<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lease extends Model
{
    protected $fillable = [
        'tenant_id',
        'unit_id',
        'rent_amount',
        'start_date',
        'end_date',
        'status'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function totalPaid()
    {
        return $this->payments()->sum('amount');
    }

    public function balance()
    {
        return $this->rent_amount - $this->totalPaid();
    }
}
