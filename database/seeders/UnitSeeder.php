<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $properties = Property::all();

        foreach ($properties as $property) {
            for ($i = 1; $i <= 5; $i++) {
                Unit::create([
                    'property_id' => $property->id,
                    'unit_number' => 'Unit ' . $i,
                    'rent' => rand(300000, 800000),
                    'status' => 'Vacant',
                ]);
            }
        }
    }
}
