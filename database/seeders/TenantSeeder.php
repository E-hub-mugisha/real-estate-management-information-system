<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenantUser = User::role('Tenant')->first();

        Tenant::create([
            'user_id' => $tenantUser->id,
            'phone' => '0788000000',
            'id_document' => 'documents/id_sample.pdf',
        ]);
    }
}
