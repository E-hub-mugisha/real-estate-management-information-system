<?php

namespace App\Http\Controllers;

use App\Models\Lease;
use App\Models\Tenant;
use App\Models\Unit;
use Illuminate\Http\Request;

class LeaseController extends Controller
{
    public function index()
{
    $user = auth()->user();

    $leases = Lease::with(['tenant.user','unit.property'])
        ->when($user->role !== 'admin', function ($query) use ($user) {

            if ($user->role == 'tenant') {
                $query->whereHas('tenant', fn($q) => $q->where('user_id',$user->id));
            }

            if ($user->role == 'owner') {
                $query->whereHas('unit.property', fn($q) => $q->where('owner_id',$user->id));
            }

        })
        ->get();

    $tenants = Tenant::where('status','Active')->get();
    $units = Unit::all();

    return view('leases.index', compact('leases','tenants','units'));
}

    public function store(Request $request)
    {
        $request->validate([
            'tenant_id' => 'required',
            'unit_id' => 'required',
            'rent_amount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        Lease::create($request->all());

        // Mark unit as occupied
        Unit::where('id',$request->unit_id)
            ->update(['status'=>'Occupied']);

        return back()->with('success','Lease created successfully');
    }

    public function update(Request $request, Lease $lease)
    {
        $lease->update($request->only([
            'rent_amount','start_date','end_date','status'
        ]));

        // If lease ends → free unit
        if ($request->status !== 'Active') {
            Unit::where('id',$lease->unit_id)
                ->update(['status'=>'Vacant']);
        }

        return back()->with('success','Lease updated');
    }

    public function destroy(Lease $lease)
    {
        Unit::where('id',$lease->unit_id)
            ->update(['status'=>'Vacant']);

        $lease->delete();

        return back()->with('success','Lease deleted');
    }
}
