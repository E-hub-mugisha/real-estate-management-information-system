<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Unit;
use App\Models\Tenant;
use App\Models\Lease;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use Illuminate\Support\Facades\Request;

class DashboardController extends Controller
{
    public function index()
{
    $user = auth()->user();

    $totalProperties = 0;
    $totalUnits = 0;
    $totalRevenue = 0;
    $pendingMaintenance = 0;
    $leasesCount = 0;

    $payments = [];
    $occupancy = [];
    $maintenance = [];

    // ================= ADMIN =================
    if ($user->role === 'admin') {

        $totalProperties = Property::count();
        $totalUnits = Unit::count();
        $totalRevenue = Payment::sum('amount');
        $pendingMaintenance = MaintenanceRequest::where('status','Pending')->count();

        $payments = Payment::whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) month, SUM(amount) total')
            ->groupBy('month')
            ->pluck('total','month')
            ->toArray();

        $occupancy = Lease::whereYear('start_date', now()->year)
            ->selectRaw('MONTH(start_date) month, COUNT(*) total')
            ->groupBy('month')
            ->pluck('total','month')
            ->toArray();

        $maintenance = MaintenanceRequest::whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) month, COUNT(*) total')
            ->groupBy('month')
            ->pluck('total','month')
            ->toArray();
    }

    // ================= OWNER =================
    elseif ($user->role === 'owner') {

        $totalProperties = $user->properties()->count();

        $totalUnits = Unit::whereHas('property', function ($q) use ($user) {
            $q->where('owner_id', $user->id);
        })->count();

        $totalRevenue = Payment::whereHas('lease.unit.property', function ($q) use ($user) {
            $q->where('owner_id', $user->id);
        })->sum('amount');

        $pendingMaintenance = MaintenanceRequest::whereHas('unit.property', function ($q) use ($user) {
            $q->where('owner_id', $user->id);
        })
        ->where('status','Pending')
        ->count();

        $payments = Payment::whereHas('lease.unit.property', function ($q) use ($user) {
            $q->where('owner_id', $user->id);
        })
        ->whereYear('created_at', now()->year)
        ->selectRaw('MONTH(created_at) month, SUM(amount) total')
        ->groupBy('month')
        ->pluck('total','month')
        ->toArray();

        $occupancy = Lease::whereHas('unit.property', function ($q) use ($user) {
            $q->where('owner_id', $user->id);
        })
        ->whereYear('start_date', now()->year)
        ->selectRaw('MONTH(start_date) month, COUNT(*) total')
        ->groupBy('month')
        ->pluck('total','month')
        ->toArray();

        $maintenance = MaintenanceRequest::whereHas('unit.property', function ($q) use ($user) {
            $q->where('owner_id', $user->id);
        })
        ->whereYear('created_at', now()->year)
        ->selectRaw('MONTH(created_at) month, COUNT(*) total')
        ->groupBy('month')
        ->pluck('total','month')
        ->toArray();
    }

    // ================= TENANT =================
    elseif ($user->role === 'tenant') {

        $tenant = $user->tenant;

        if($tenant){

            $leasesCount = $tenant->leases()->count();

            $totalRevenue = $tenant->payments()->sum('amount');

            $pendingMaintenance = $tenant->maintenanceRequests()
                ->where('status','Pending')
                ->count();
        }
    }

    return view('dashboard', compact(
        'totalProperties',
        'totalUnits',
        'totalRevenue',
        'pendingMaintenance',
        'leasesCount',
        'payments',
        'occupancy',
        'maintenance'
    ));
}
}
