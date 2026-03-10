<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();

            $table->foreignId('property_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('name');                        // e.g. "Unit A", "Apt 3B"
            $table->integer('floor')->default(1);
            $table->decimal('size', 8, 2)->nullable();
            $table->string('unit_measurement')->default('sqm');
            $table->decimal('price', 12, 2);
            $table->integer('bedrooms')->default(1);
            $table->integer('bathrooms')->default(1);

            $table->enum('status', [
                'available',
                'occupied',
                'maintenance',
                'reserved',
            ])->default('available');

            $table->string('main_image')->nullable();
            $table->json('gallery')->nullable();
            $table->text('description')->nullable();
            $table->json('amenities')->nullable();
            $table->string('room_360_image')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};