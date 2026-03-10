<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $owners = User::where('role', 'Owner')->get();

        $properties = [
            [
                'name'             => 'Kigali Heights Residences',
                'location'         => 'Kigali',
                'address'          => 'KG 7 Ave, Kiyovu, Nyarugenge, Kigali',
                'type'             => 'Apartment',
                'status'           => 'Available',
                'price'            => 850000.00,
                'bedrooms'         => 3,
                'bathrooms'        => 2,
                'size'             => 145.00,
                'unit_measurement' => 'sqm',
                'description'      => 'Modern high-rise apartments in the heart of Kigali with stunning panoramic views of the city skyline. Each unit features floor-to-ceiling windows, open-plan living spaces, and premium finishes throughout.',
                'amenities'        => ['Swimming Pool', 'Gym', 'Underground Parking', '24/7 Security', 'Backup Generator', 'Rooftop Terrace', 'Concierge Service'],
                'main_image'       => 'properties/kigali-heights/main.jpg',
                'gallery'          => [
                    'properties/kigali-heights/gallery-1.jpg',
                    'properties/kigali-heights/gallery-2.jpg',
                    'properties/kigali-heights/gallery-3.jpg',
                ],
                'room_360_image'   => 'properties/kigali-heights/panorama.jpg',
            ],
            [
                'name'             => 'Nyarutarama Green Villas',
                'location'         => 'Kigali',
                'address'          => 'KG 563 St, Nyarutarama, Gasabo, Kigali',
                'type'             => 'Villa',
                'status'           => 'Available',
                'price'            => 2500000.00,
                'bedrooms'         => 5,
                'bathrooms'        => 4,
                'size'             => 420.00,
                'unit_measurement' => 'sqm',
                'description'      => 'Exclusive gated villa community nestled in the prestigious Nyarutarama neighborhood. Surrounded by lush greenery, each villa offers spacious living areas, private gardens, and breathtaking views of Lake Muhazi.',
                'amenities'        => ['Private Garden', 'Swimming Pool', 'Double Garage', 'Staff Quarters', 'Borehole Water', 'Solar Panels', 'Smart Home System'],
                'main_image'       => 'properties/nyarutarama-villas/main.jpg',
                'gallery'          => [
                    'properties/nyarutarama-villas/gallery-1.jpg',
                    'properties/nyarutarama-villas/gallery-2.jpg',
                    'properties/nyarutarama-villas/gallery-3.jpg',
                ],
                'room_360_image'   => 'properties/nyarutarama-villas/panorama.jpg',
            ],
            [
                'name'             => 'Kimihurura Executive Suites',
                'location'         => 'Kigali',
                'address'          => 'KG 9 Ave, Kimihurura, Gasabo, Kigali',
                'type'             => 'Apartment',
                'status'           => 'Available',
                'price'            => 650000.00,
                'bedrooms'         => 2,
                'bathrooms'        => 2,
                'size'             => 110.00,
                'unit_measurement' => 'sqm',
                'description'      => 'Sophisticated executive suites ideal for diplomats and expats, located minutes from major embassies and the Convention Centre. Features fully furnished interiors with contemporary African design elements.',
                'amenities'        => ['Furnished Interior', 'High-Speed Internet', 'Business Centre', 'Restaurant', 'Laundry Service', 'CCTV', 'Visitor Parking'],
                'main_image'       => 'properties/kimihurura-suites/main.jpg',
                'gallery'          => [
                    'properties/kimihurura-suites/gallery-1.jpg',
                    'properties/kimihurura-suites/gallery-2.jpg',
                    'properties/kimihurura-suites/gallery-3.jpg',
                ],
                'room_360_image'   => 'properties/kimihurura-suites/panorama.jpg',
            ],
            [
                'name'             => 'Musanze Countryside Lodge',
                'location'         => 'Musanze',
                'address'          => 'RN4, Kinigi Sector, Musanze District, Northern Province',
                'type'             => 'House',
                'status'           => 'Available',
                'price'            => 480000.00,
                'bedrooms'         => 4,
                'bathrooms'        => 3,
                'size'             => 280.00,
                'unit_measurement' => 'sqm',
                'description'      => 'Charming countryside residence at the foot of the Virunga volcanoes with panoramic views of rolling hills and lava plains. A rare opportunity to live near Volcanoes National Park with easy gorilla trekking access.',
                'amenities'        => ['Mountain View', 'Fireplace', 'Large Garden', 'Outdoor Kitchen', 'Water Reservoir', 'Vegetable Farm', 'Parking'],
                'main_image'       => 'properties/musanze-lodge/main.jpg',
                'gallery'          => [
                    'properties/musanze-lodge/gallery-1.jpg',
                    'properties/musanze-lodge/gallery-2.jpg',
                    'properties/musanze-lodge/gallery-3.jpg',
                ],
                'room_360_image'   => 'properties/musanze-lodge/panorama.jpg',
            ],
            [
                'name'             => 'Huye Modern Apartments',
                'location'         => 'Huye',
                'address'          => 'RN1, Tumba Sector, Huye District, Southern Province',
                'type'             => 'Apartment',
                'status'           => 'Available',
                'price'            => 320000.00,
                'bedrooms'         => 2,
                'bathrooms'        => 1,
                'size'             => 85.00,
                'unit_measurement' => 'sqm',
                'description'      => 'Affordable modern apartments near the University of Rwanda, Huye campus. Perfect for academics, students, and young professionals seeking comfortable living in Rwanda\'s intellectual capital of the South.',
                'amenities'        => ['Study Room', 'High-Speed Internet', 'Backup Power', 'Water Tank', 'Secure Parking', 'Common Garden', 'Waste Management'],
                'main_image'       => 'properties/huye-apartments/main.jpg',
                'gallery'          => [
                    'properties/huye-apartments/gallery-1.jpg',
                    'properties/huye-apartments/gallery-2.jpg',
                    'properties/huye-apartments/gallery-3.jpg',
                ],
                'room_360_image'   => 'properties/huye-apartments/panorama.jpg',
            ],
        ];

        foreach ($properties as $index => $data) {
            $owner = $owners[$index % $owners->count()];

            Property::create([
                'name'             => $data['name'],
                'slug'             => Str::slug($data['name']) . '-' . time() . $index,
                'location'         => $data['location'],
                'address'          => $data['address'],
                'type'             => $data['type'],
                'status'           => $data['status'],
                'price'            => $data['price'],
                'bedrooms'         => $data['bedrooms'],
                'bathrooms'        => $data['bathrooms'],
                'size'             => $data['size'],
                'unit_measurement' => $data['unit_measurement'],
                'owner_id'         => $owner->id,
                'main_image'       => $data['main_image'],
                'gallery'          => $data['gallery'],
                'description'      => $data['description'],
                'amenities'        => $data['amenities'],
                'room_360_image'   => $data['room_360_image'],
            ]);
        }
    }
}