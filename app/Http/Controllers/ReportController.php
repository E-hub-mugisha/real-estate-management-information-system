<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Unit;
use App\Models\Tenant;
use App\Models\Lease;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PaymentsExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $properties = Property::all();
        $tenants = Tenant::all();

        // Filters
        $propertyId = $request->property_id;
        $month = $request->month;
        $year = $request->year;
        $tenantId = $request->tenant_id;

        $leasesQuery = Lease::query()->with(['tenant.user','unit.property']);
        $paymentsQuery = Payment::query()->with(['lease.tenant.user','lease.unit.property']);
        $maintenanceQuery = MaintenanceRequest::query()->with(['unit.property','tenant.user']);

        if($propertyId){
            $leasesQuery->whereHas('unit', fn($q)=>$q->where('property_id',$propertyId));
            $paymentsQuery->whereHas('lease.unit', fn($q)=>$q->where('property_id',$propertyId));
            $maintenanceQuery->whereHas('unit', fn($q)=>$q->where('property_id',$propertyId));
        }

        if($tenantId){
            $leasesQuery->where('tenant_id', $tenantId);
            $paymentsQuery->whereHas('lease', fn($q)=>$q->where('tenant_id',$tenantId));
            $maintenanceQuery->where('tenant_id', $tenantId);
        }

        if($month){
            $leasesQuery->whereMonth('start_date',$month);
            $paymentsQuery->whereMonth('created_at',$month);
            $maintenanceQuery->whereMonth('created_at',$month);
        }

        if($year){
            $leasesQuery->whereYear('start_date',$year);
            $paymentsQuery->whereYear('created_at',$year);
            $maintenanceQuery->whereYear('created_at',$year);
        }

        $leases = $leasesQuery->get();
        $payments = $paymentsQuery->get();
        $maintenanceRequests = $maintenanceQuery->get();

        // Occupancy trend data
        $occupancyTrend = Lease::selectRaw('MONTH(start_date) as month, COUNT(*) as total')
                            ->groupBy('month')->pluck('total','month')->all();

        // Payment collection trend
        $paymentTrend = Payment::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
                            ->groupBy('month')->pluck('total','month')->all();

        // Maintenance trend
        $maintenanceTrend = MaintenanceRequest::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                            ->groupBy('month')->pluck('total','month')->all();

        return view('reports.index', compact(
            'properties','tenants','leases','payments','maintenanceRequests',
            'occupancyTrend','paymentTrend','maintenanceTrend'
        ));
    }

    // Export Excel
    public function exportExcel(Request $request)
    {
        return Excel::download(new \App\Exports\PaymentsExport($request), 'payments.xlsx');
    }

    // Export PDF
    public function exportPDF(Request $request)
    {
        $payments = Payment::with('lease.tenant.user','lease.unit.property')->get();
        $pdf = Pdf::loadView('reports.pdf', compact('payments'));
        return $pdf->download('payments.pdf');
    }
}
