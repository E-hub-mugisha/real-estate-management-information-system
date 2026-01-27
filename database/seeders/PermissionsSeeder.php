<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'create user',
            'edit user',
            'delete user',
            'view user',
            'create property',
            'edit property',
            'delete property',
            'view property',
            'create unit',
            'edit unit',
            'delete unit',
            'view unit',
            'create tenant',
            'edit tenant',
            'delete tenant',
            'view tenant',
            'manage leases',
            'manage payments',
            'manage maintenance',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
