<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    // Display all vehicles
    public function index()
    {
        $vehicles = Vehicle::latest()->paginate(10);

        // Get statistics
        $availableCount = Vehicle::where('status', 'available')->count();
        $soldCount = Vehicle::where('status', 'sold')->count();
        $maintenanceCount = Vehicle::where('status', 'under_maintenance')->count();
        $totalValue = Vehicle::where('status', 'available')->sum('selling_price');

        return view('vehicles.index', compact(
            'vehicles',
            'availableCount',
            'soldCount',
            'maintenanceCount',
            'totalValue'
        ));
    }

    // Show create form
    public function create()
    {
        return view('vehicles.create');
    }

    // Store new vehicle
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'vehicle_type' => 'required|in:bike,car,scooter,other',
            'cc' => 'required|integer|min:50',
            'manufacture_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'condition' => 'required|in:new,used,excellent',
            'color' => 'nullable|string|max:50',
            'engine_number' => 'required|string|unique:vehicles',
            'chassis_number' => 'required|string|unique:vehicles',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'registered_name' => 'required|string|max:255',
            'transferred_by' => 'required|string|max:255',
            'purchase_date' => 'required|date',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|max:2048',
            'status' => 'required|in:available,sold,under_maintenance',
        ]);

        // Handle image upload
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('vehicles', 'public');
                $imagePaths[] = $path;
            }
            $validated['images'] = json_encode($imagePaths);
        }

        $vehicle = Vehicle::create($validated);

        return redirect()->route('vehicles.show', $vehicle)
            ->with('success', 'Vehicle added successfully!');
    }

    // Show single vehicle
    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['transfers', 'transfers.buyer', 'transfers.seller']);
        return view('vehicles.show', compact('vehicle'));
    }

    // Edit vehicle
    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    // Update vehicle
    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'vehicle_type' => 'required|in:bike,car,scooter,other',
            'cc' => 'required|integer|min:50',
            'manufacture_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'condition' => 'required|in:new,used,excellent',
            'color' => 'nullable|string|max:50',
            'engine_number' => 'required|string|unique:vehicles,engine_number,' . $vehicle->id,
            'chassis_number' => 'required|string|unique:vehicles,chassis_number,' . $vehicle->id,
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'status' => 'required|in:available,sold,under_maintenance',
            'description' => 'nullable|string',
        ]);

        $vehicle->update($validated);

        return redirect()->route('vehicles.show', $vehicle)
            ->with('success', 'Vehicle updated successfully!');
    }

    // Delete vehicle
    public function destroy(Vehicle $vehicle)
    {
        // Delete associated images
        if ($vehicle->images) {
            $images = json_decode($vehicle->images);
            foreach ($images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $vehicle->delete();

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle deleted successfully!');
    }

    // Additional Methods
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:available,sold,under_maintenance'
        ]);

        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }

    public function byCategory($type)
    {
        $vehicles = Vehicle::where('vehicle_type', $type)
            ->where('status', 'available')
            ->paginate(12);

        return view('vehicles.category', compact('vehicles', 'type'));
    }

    public function available()
    {
        $vehicles = Vehicle::where('status', 'available')->get();
        return response()->json($vehicles);
    }
}
