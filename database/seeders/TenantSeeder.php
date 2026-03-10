<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        $tenantUsers = User::where('role', 'Tenant')->get();

        $tenantData = [
            [
                'phone'       => '+250788123456',
                'national_id' => '1199780123456789',
                'employment'  => 'Teacher at GS Kacyiru',
                'status'      => 'active',
            ],
            [
                'phone'       => '+250722345678',
                'national_id' => '1200160234567890',
                'employment'  => 'Software Engineer at Andela',
                'status'      => 'active',
            ],
            [
                'phone'       => '+250733456789',
                'national_id' => '1199580345678901',
                'employment'  => 'Nurse at CHUK',
                'status'      => 'active',
            ],
            [
                'phone'       => '+250788567890',
                'national_id' => '1200260456789012',
                'employment'  => 'Accountant at BK',
                'status'      => 'active',
            ],
            [
                'phone'       => '+250722678901',
                'national_id' => '1199880567890123',
                'employment'  => 'Business Owner',
                'status'      => 'active',
            ],
            [
                'phone'       => '+250733789012',
                'national_id' => '1200060678901234',
                'employment'  => 'Civil Engineer at MININFRA',
                'status'      => 'active',
            ],
            [
                'phone'       => '+250788890123',
                'national_id' => '1199680789012345',
                'employment'  => 'Freelance Consultant',
                'status'      => 'inactive',
            ],
        ];

        foreach ($tenantUsers as $index => $user) {
            if (isset($tenantData[$index])) {
                Tenant::create([
                    'user_id'     => $user->id,
                    'phone'       => $tenantData[$index]['phone'],
                    'national_id' => $tenantData[$index]['national_id'],
                    'employment'  => $tenantData[$index]['employment'],
                    'unit_id'     => null,
                    'status'      => $tenantData[$index]['status'],
                ]);
            }
        }
    }
}