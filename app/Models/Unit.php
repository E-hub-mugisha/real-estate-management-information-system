<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'name',
        'floor',
        'size',
        'unit_measurement',
        'price',
        'bedrooms',
        'bathrooms',
        'status',
        'main_image',
        'gallery',
        'description',
        'amenities',
        'room_360_image',
    ];

    protected $casts = [
        'gallery'   => 'array',
        'amenities' => 'array',
        'price'     => 'decimal:2',
    ];

    // ─── Relationships ────────────────────────────────────────────

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function tenant()
    {
        return $this->hasOne(Tenant::class);
    }

    public function leases()
    {
        return $this->hasMany(Lease::class);
    }

    public function activeLease()
    {
        return $this->hasOne(Lease::class)->where('status', 'active')->latestOfMany();
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    // ─── Helpers ──────────────────────────────────────────────────

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isOccupied(): bool
    {
        return $this->status === 'occupied';
    }

    public function mainImageUrl(): string
    {
        return $this->main_image
            ? asset('storage/' . $this->main_image)
            : asset('images/unit-default.png');
    }
}
