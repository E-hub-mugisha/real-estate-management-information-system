<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::with('owner')->get();
        $owners = User::role('Owner')->get();

        return view('properties.index', compact('properties', 'owners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'type' => 'required',
            'owner_id' => 'required'
        ]);

        Property::create($request->all());

        return back()->with('success', 'Property added successfully');
    }

    public function update(Request $request, Property $property)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'type' => 'required',
            'owner_id' => 'required'
        ]);

        $property->update($request->all());

        return back()->with('success', 'Property updated successfully');
    }

    public function destroy(Property $property)
    {
        $property->delete();

        return back()->with('success', 'Property deleted successfully');
    }
}
