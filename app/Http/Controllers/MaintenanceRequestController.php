<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceRequestController extends Controller
{
    public function index()
    {
        $requests = MaintenanceRequest::with(['tenant.user', 'unit.property'])->latest()->get();
        return view('maintenance.index', compact('requests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $tenant = Auth::user()->tenant;

        MaintenanceRequest::create([
            'tenant_id' => $tenant->id,
            'unit_id' => $tenant->unit_id,
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority ?? 'Medium'
        ]);

        return back()->with('success', 'Maintenance request submitted');
    }

    public function update(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        $maintenanceRequest->update($request->only([
            'priority',
            'status'
        ]));

        return back()->with('success', 'Maintenance status updated');
    }

    public function destroy(MaintenanceRequest $maintenanceRequest)
    {
        $maintenanceRequest->delete();
        return back()->with('success', 'Maintenance request removed');
    }
    public function response(Request $request, MaintenanceRequest $maintenance)
    {
        $request->validate([
            'response' => 'required|string'
        ]);

        $maintenance->update([
            'response' => $request->response
        ]);

        return back()->with('success', 'Response sent to tenant');
    }

    public function updateStatus(Request $request, MaintenanceRequest $maintenance)
    {
        $request->validate([
            'status' => 'required|in:Pending,In Progress,Resolved'
        ]);

        $maintenance->update([
            'status' => $request->status,
            'resolved_at' => $request->status === 'Resolved' ? now() : null
        ]);

        return back()->with('success', 'Status updated successfully');
    }
    public function show(MaintenanceRequest $maintenance)
    {
        $maintenance->load('tenant.user', 'unit.property');

        return view('maintenance.show', compact('maintenance'));
    }
}
