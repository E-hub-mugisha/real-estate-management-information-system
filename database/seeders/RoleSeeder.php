<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Roles
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Manager']);
        Role::firstOrCreate(['name' => 'Tenant']);

        // Example permissions
        Permission::firstOrCreate(['name' => 'manage users']);
        Permission::firstOrCreate(['name' => 'manage properties']);
        Permission::firstOrCreate(['name' => 'manage tenants']);
        Permission::firstOrCreate(['name' => 'manage leases']);
        Permission::firstOrCreate(['name' => 'manage payments']);
        Permission::firstOrCreate(['name' => 'manage maintenance']);
    }
}
