<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'System Admin',
            'email' => 'admin@irems.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('Admin');

        $manager = User::create([
            'name' => 'Property Manager',
            'email' => 'manager@irems.com',
            'password' => Hash::make('password'),
        ]);
        $manager->assignRole('Manager');

        $owner = User::create([
            'name' => 'Property Owner',
            'email' => 'owner@irems.com',
            'password' => Hash::make('password'),
        ]);
        $owner->assignRole('Owner');

        $tenant = User::create([
            'name' => 'Test Tenant',
            'email' => 'tenant@irems.com',
            'password' => Hash::make('password'),
        ]);
        $tenant->assignRole('Tenant');
    }
}
