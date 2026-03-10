<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'System Admin',
            'email' => 'admin@irems.com',
            'password' => Hash::make('password'),
            'role' => 'Admin',
        ]);

        // Owners
        $owners = [
            ['name' => 'Uwimana Jean Pierre', 'email' => 'jeanpierre.uwimana@irems.com'],
            ['name' => 'Mukamana Chantal', 'email' => 'chantal.mukamana@irems.com'],
            ['name' => 'Habimana Eric', 'email' => 'eric.habimana@irems.com'],
        ];

        foreach ($owners as $ownerData) {
            $owner = User::create([
                'name' => $ownerData['name'],
                'email' => $ownerData['email'],
                'password' => Hash::make('password'),
                'role' => 'Owner',
            ]);
        }

        // Tenants
        $tenants = [
            ['name' => 'Niyonzima Patrick', 'email' => 'patrick.niyonzima@irems.com'],
            ['name' => 'Uwase Diane', 'email' => 'diane.uwase@irems.com'],
            ['name' => 'Hakizimana Yves', 'email' => 'yves.hakizimana@irems.com'],
            ['name' => 'Mukagasana Solange', 'email' => 'solange.mukagasana@irems.com'],
            ['name' => 'Bizimana Claude', 'email' => 'claude.bizimana@irems.com'],
            ['name' => 'Nyiransabimana Grace', 'email' => 'grace.nyiransabimana@irems.com'],
            ['name' => 'Tuyisenge Aimable', 'email' => 'aimable.tuyisenge@irems.com'],
        ];

        foreach ($tenants as $tenantData) {
            $tenant = User::create([
                'name' => $tenantData['name'],
                'email' => $tenantData['email'],
                'password' => Hash::make('password'),
                'role' => 'Tenant',
            ]);
        }
    }
}