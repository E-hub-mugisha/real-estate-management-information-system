<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    public function adminIndex()
{
    $inquiries = Inquiry::with(['property', 'tenant.user'])
        ->latest()
        ->paginate(10);

    return view('properties.inquiries-index', compact('inquiries'));
}
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'owner') {
            $properties = Property::where('owner_id', $user->id)->with('owner')->get();
            return view('properties.index', compact('properties'));
        }

        $properties = Property::with('owner')->get();
        $owners = User::where('role', 'owner')->get();

        return view('properties.index', compact('properties', 'owners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'type' => 'required|in:Residential,Commercial',
            'status' => 'required|in:Available,Rented,Sold,Pending',
            'price' => 'nullable|numeric|min:0',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'size' => 'nullable|integer|min:0',
            'unit_measurement' => 'nullable|string|max:10',
            'owner_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
            'amenities' => 'nullable',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png',
            'main_image' => 'nullable|image|mimes:jpg,jpeg,png',
            'room_360_image' => 'nullable|image', // 360° image
        ]);

        // Ensure non-admins cannot set owner_id
        if (auth()->user()->role !== 'admin') {
            $request->merge(['owner_id' => auth()->id()]);
        }

        $data = $request->except(['main_image', 'gallery']);

        // Handle main image upload
        if ($request->hasFile('main_image')) {
            $data['main_image'] = $request->file('main_image')->store('properties', 'public');
        }

        // Handle gallery images
        if ($request->hasFile('gallery')) {
            $gallery = [];
            foreach ($request->file('gallery') as $image) {
                $gallery[] = $image->store('properties/gallery', 'public');
            }
            $data['gallery'] = $gallery;
        }

        // Convert amenities to JSON if array
        if (!empty($data['amenities']) && is_array($data['amenities'])) {
            $data['amenities'] = $data['amenities'];
        }

        // Handle 360° room image upload
        if ($request->hasFile('room_360_image')) {
            $data['room_360_image'] = $request->file('room_360_image')->store('properties/360rooms', 'public');
        }

        // Generate slug if not provided
        $data['slug'] = Str::slug($data['name']) . '-' . time();

        $property = Property::create($data);

        return back()->with('success', 'Property added successfully');
    }

    public function update(Request $request, Property $property)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'type' => 'required|in:Residential,Commercial',
            'status' => 'required|in:Available,Rented,Sold,Pending',
            'price' => 'nullable|numeric|min:0',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'size' => 'nullable|integer|min:0',
            'unit_measurement' => 'nullable|string|max:10',
            'owner_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
            'amenities' => 'nullable',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png',
            'main_image' => 'nullable|image|mimes:jpg,jpeg,png',
            'room_360_image' => 'nullable|image', // 360° image
        ]);

        // Non-admins cannot change owner
        if (auth()->user()->role !== 'admin') {
            $request->merge(['owner_id' => auth()->id()]);
        }

        $data = $request->except(['main_image', 'gallery']);

        if ($request->hasFile('main_image')) {
            $data['main_image'] = $request->file('main_image')->store('properties', 'public');
        }

        if ($request->hasFile('gallery')) {
            $gallery = [];
            foreach ($request->file('gallery') as $image) {
                $gallery[] = $image->store('properties/gallery', 'public');
            }
            $data['gallery'] = $gallery;
        }

        if (!empty($data['amenities']) && is_array($data['amenities'])) {
            $data['amenities'] = $data['amenities'];
        }

        // Handle 360° room image upload
        if ($request->hasFile('room_360_image')) {
            $data['room_360_image'] = $request->file('room_360_image')->store('properties/360rooms', 'public');
        }

        $property->update($data);

        return back()->with('success', 'Property updated successfully');
    }

    public function destroy(Property $property)
    {
        $property->delete();

        return back()->with('success', 'Property deleted successfully');
    }
    public function show(Property $property)
    {
        $property->load([
            'owner',
            'units.leases.tenant.user'
        ]);

        return view('properties.show', compact('property'));
    }

    public function create()
    {
        $owners = User::where('role', 'owner')->get();
        return view('properties.create', compact('owners'));
    }

    public function edit(Property $property)
    {
        $owners = User::where('role', 'owner')->get();
        return view('properties.edit', compact('property', 'owners'));
    }

    public function storeInquiry(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'message' => 'required|string|min:10'
        ]);

        $user = auth()->user();

        if (!$user->tenant) {
            return back()->with('error', 'Tenant profile not found.');
        }

        Inquiry::create([
            'property_id' => $request->property_id,
            'tenant_id'   => $user->tenant->id,
            'message'     => $request->message,
            'status'      => 'pending',
        ]);

        return redirect()->route('properties.show', $request->property_id)
            ->with('success', 'Inquiry sent successfully.');
    }

    public function createInquiry(Request $request)
    {
        $property = Property::findOrFail($request->property_id);

        return view('properties.inquiry', compact('property'));
    }
}
