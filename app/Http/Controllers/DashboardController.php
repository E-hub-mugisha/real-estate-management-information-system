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
        $totalUnits = Unit::count();

        $occupiedUnits = Unit::whereHas('leases', function ($q) {
            $q->where('end_date', '>=', now());
        })->count();

        $vacantUnits = $totalUnits - $occupiedUnits;

        $totalRevenue = Payment::sum('amount');
        $pendingMaintenance = MaintenanceRequest::where('status', 'Pending')->count();

        // Monthly Analytics (Current Year)
        $payments = Payment::whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $occupancy = Lease::whereYear('start_date', now()->year)
            ->selectRaw('MONTH(start_date) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $maintenance = MaintenanceRequest::whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $requests = MaintenanceRequest::with(['tenant.user', 'unit.property'])->latest()->get();

        return view('dashboard', compact(
            'totalUnits',
            'occupiedUnits',
            'vacantUnits',
            'totalRevenue',
            'pendingMaintenance',
            'payments',
            'occupancy',
            'maintenance',
            'requests'
        ));
    }
}
