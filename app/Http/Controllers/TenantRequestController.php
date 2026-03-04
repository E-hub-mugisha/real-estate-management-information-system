<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;

class TenantRequestController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Check if tenant exists AND profile is complete
        if (!$user->tenant || !$user->tenant->profile_complete) {
            return redirect()
                ->route('tenants.profile')
                ->with('warning', 'Please complete your profile before submitting requests');
        }

        $requests = MaintenanceRequest::with(['tenant.user', 'unit.property'])
            ->latest()
            ->get();

        return view('requests.index', compact('requests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'unit_id'   => 'required|exists:units,id',
            'title'     => 'required|string|max:255',
            'description' => 'required|string',
            'priority'  => 'nullable|in:Low,Medium,High',
            'status'    => 'required|in:Pending,In Progress,Completed',
        ]);

        MaintenanceRequest::create($request->only(
            'tenant_id',
            'unit_id',
            'title',
            'description',
            'priority',
            'status'
        ));

        return back()->with('success', 'Maintenance request created');
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

        return view('requests.show', compact('maintenance'));
    }
}
