<?php

namespace Database\Seeders;

use App\Models\Lease;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lease = Lease::first();

        for ($i = 1; $i <= 3; $i++) {
            Payment::create([
                'lease_id' => $lease->id,
                'amount' => $lease->monthly_rent,
                'payment_date' => Carbon::now()->subMonths($i),
                'method' => 'Bank Transfer',
            ]);
        }
    }
}
