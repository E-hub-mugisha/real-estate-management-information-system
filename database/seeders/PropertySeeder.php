<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owner = User::role('Owner')->first();

        Property::create([
            'name' => 'Kigali Heights Apartments',
            'location' => 'Kacyiru, Kigali',
            'type' => 'Residential',
            'owner_id' => $owner->id,
        ]);

        Property::create([
            'name' => 'Downtown Business Plaza',
            'location' => 'Nyarugenge, Kigali',
            'type' => 'Commercial',
            'owner_id' => $owner->id,
        ]);
    }
}
