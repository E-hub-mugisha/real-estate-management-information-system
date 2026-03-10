<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();

            // Basic info
            $table->string('name')->comment('Property name or title');
            $table->string('location')->comment('General location, city/area');
            $table->string('address')->nullable()->comment('Full street address');
            $table->string('slug')->unique()->comment('URL-friendly slug for SEO');

            // Type & Status
            $table->string('type', 50)->default('Residential')->comment('Property type');
            $table->enum('status', ['Available', 'Rented', 'Sold', 'Pending'])->default('Available')->comment('Current status');

            // Financial / Size info
            $table->decimal('price', 15, 2)->nullable()->comment('Property price in local currency');
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('size')->nullable()->comment('Size in square meters');
            $table->string('unit_measurement')->default('sqm')->comment('Unit of size, e.g., sqm, sqft');

            // Relationships
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete()->comment('Property owner');

            // Media & extra
            $table->string('main_image')->nullable()->comment('Main featured image');
            $table->json('gallery')->nullable()->comment('Additional images in JSON format');
            $table->string('room_360_image')->nullable()->comment('360° room image path');

            // Optional notes
            $table->text('description')->nullable()->comment('Detailed property description');
            $table->text('amenities')->nullable()->comment('Comma-separated list or JSON of amenities');

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
