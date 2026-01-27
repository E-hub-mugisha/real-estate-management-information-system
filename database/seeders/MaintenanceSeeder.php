<?php

namespace Database\Seeders;

use App\Models\MaintenanceRequest;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = Tenant::first();
        $unit = Tenant::first();

        MaintenanceRequest::create([
            'tenant_id' => $tenant->id,
            'unit_id' => $unit->id,
            'description' => 'Water leakage in the kitchen',
            'title' => 'Water leakage in the kitchen',
            'priority' => 'high',
            'status' => 'Pending',
        ]);
    }
}
