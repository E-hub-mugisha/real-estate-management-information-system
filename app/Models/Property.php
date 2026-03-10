<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'name',
        'slug',
        'location',
        'address',
        'type',
        'status',
        'price',
        'bedrooms',
        'bathrooms',
        'size',
        'unit_measurement',
        'owner_id',
        'main_image',
        'gallery',
        'description',
        'amenities',
        'room_360_image',
    ];

    // Cast JSON fields
    protected $casts = [
        'gallery' => 'array',
        'amenities' => 'array',
        'price' => 'decimal:2',
    ];

    // Relationships

    /**
     * Owner of the property (user)
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Units inside property (for apartments/commercial spaces)
     */
    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    /**
     * Tenants currently assigned to this property
     */
    public function tenants()
    {
        return $this->hasManyThrough(Tenant::class, Unit::class);
    }

    // Helper methods

    /**
     * Get main image URL or default
     */
    public function mainImageUrl()
    {
        return $this->main_image ? asset('storage/' . $this->main_image) : asset('images/property-default.png');
    }

    /**
     * Check if property is available
     */
    public function isAvailable()
    {
        return $this->status === 'Available';
    }

    /**
     * Generate SEO-friendly slug from name
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($property) {
            if (empty($property->slug)) {
                $property->slug = Str::slug($property->name) . '-' . time();
            }
        });
    }
    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }
}
