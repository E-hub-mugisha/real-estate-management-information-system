<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::with(['user', 'unit.property'])->get();
        $units = Unit::where('status', 'Vacant')->get();

        return view('tenants.index', compact('tenants', 'units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => 'required|email|unique:users',
            'phone' => 'required'
        ]);

        // Create user account
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('tenant123') // default password
        ]);

        // Create tenant profile
        Tenant::create([
            'user_id' => $user->id,
            'phone' => $request->phone,
            'national_id' => $request->national_id,
            'employment' => $request->employment,
            'unit_id' => $request->unit_id,
            'status' => 'Active'
        ]);

        // Update unit status
        if ($request->unit_id) {
            Unit::where('id', $request->unit_id)
                ->update(['status' => 'Occupied']);
        }

        return back()->with('success', 'Tenant onboarded successfully');
    }

    public function update(Request $request, Tenant $tenant)
    {
        $tenant->update($request->only([
            'phone',
            'national_id',
            'employment',
            'unit_id',
            'status'
        ]));

        return back()->with('success', 'Tenant updated');
    }

    public function destroy(Tenant $tenant)
    {
        if ($tenant->unit_id) {
            Unit::where('id', $tenant->unit_id)
                ->update(['status' => 'Vacant']);
        }

        $tenant->user->delete(); // removes account
        $tenant->delete();

        return back()->with('success', 'Tenant removed');
    }
    public function show(Tenant $tenant)
    {
        $tenant->load([
            'user',
            'unit.property',
            'leases',
            'payments'
        ]);

        return view('tenants.show', compact('tenant'));
    }

    public function editTenantProfile()
    {
        return view('tenants.profile');
    }

    public function updateTenantProfile(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'national_id' => 'nullable|string|max:20',
            'employment' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();

        $tenant = $user->tenant ?? new Tenant();
        $tenant->user_id = $user->id;
        $tenant->phone = $request->phone;
        $tenant->national_id = $request->national_id;
        $tenant->employment = $request->employment;

        // Optional: Add profile_complete column if you want
        $tenant->profile_complete = true;

        $tenant->save();

        return redirect()->route('dashboard')
            ->with('success', 'Profile completed successfully.');
    }
}
