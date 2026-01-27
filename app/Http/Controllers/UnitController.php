<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Property;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::with('property')->get();
        $properties = Property::all();

        return view('units.index', compact('units', 'properties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required',
            'unit_number' => 'required',
            'rent' => 'required|numeric',
            'status' => 'required'
        ]);

        Unit::create($request->all());

        return back()->with('success', 'Unit added successfully');
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'property_id' => 'required',
            'unit_number' => 'required',
            'rent' => 'required|numeric',
            'status' => 'required'
        ]);

        $unit->update($request->all());

        return back()->with('success', 'Unit updated successfully');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();

        return back()->with('success', 'Unit deleted successfully');
    }
}
