<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Lease;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $leases = Lease::with(['tenant.user','unit.property','payments'])->get();
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
