<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Lease;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
{
    $user = auth()->user();

    $leases = Lease::with(['tenant.user','unit.property','payments'])
        ->when($user->role !== 'admin', function ($query) use ($user) {

            if ($user->role == 'tenant') {
                // Only the tenant's own leases
                $query->whereHas('tenant', fn($q) => $q->where('user_id', $user->id));
            }

            if ($user->role == 'owner') {
                // Only leases for properties they own
                $query->whereHas('unit.property', fn($q) => $q->where('owner_id', $user->id));
            }

        })
        ->get();

    return view('payments.index', compact('leases'));
}

    public function store(Request $request)
    {
        $request->validate([
            'lease_id' => 'required',
            'amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'method' => 'required'
        ]);

        Payment::create($request->all());

        return back()->with('success','Payment recorded successfully');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return back()->with('success','Payment deleted');
    }
}
