<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'national_id',
        'employment',
        'unit_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function leases()
    {
        return $this->hasMany(Lease::class);
    }
    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    public function payments()
    {
        return $this->hasManyThrough(
            Payment::class,
            Lease::class,
            'tenant_id', // FK on leases table
            'lease_id',  // FK on payments table
            'id',
            'id'
        );
    }

    public function inquiries()
{
    return $this->hasMany(Inquiry::class);
}
}
