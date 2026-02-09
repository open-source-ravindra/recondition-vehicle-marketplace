<?php

namespace App\Http\Controllers;

use App\Models\VehicleTransfer;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Payment;
use Illuminate\Http\Request;

class VehicleTransferController extends Controller
{
    public function index(Request $request)
    {
        // Start query
        $query = VehicleTransfer::with(['vehicle', 'buyer', 'seller', 'payment'])
            ->withCount(['payment'])
            ->latest();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('transfer_number', 'like', "%{$search}%")
                    ->orWhereHas('vehicle', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('engine_number', 'like', "%{$search}%")
                            ->orWhere('chassis_number', 'like', "%{$search}%");
                    })
                    ->orWhereHas('buyer', function ($q3) use ($search) {
                        $q3->where('name', 'like', "%{$search}%")
                            ->orWhere('citizenship_number', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    })
                    ->orWhereHas('seller', function ($q4) use ($search) {
                        $q4->where('name', 'like', "%{$search}%")
                            ->orWhere('citizenship_number', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('from_date') && !empty($request->from_date)) {
            $query->whereDate('transfer_date', '>=', $request->from_date);
        }

        if ($request->has('to_date') && !empty($request->to_date)) {
            $query->whereDate('transfer_date', '<=', $request->to_date);
        }

        // Filter by vehicle type
        if ($request->has('vehicle_type') && !empty($request->vehicle_type)) {
            $query->whereHas('vehicle', function ($q) use ($request) {
                $q->where('vehicle_type', $request->vehicle_type);
            });
        }

        // Filter by payment status
        if ($request->has('payment_status') && !empty($request->payment_status)) {
            $query->whereHas('payment', function ($q) use ($request) {
                if ($request->payment_status == 'paid') {
                    $q->whereRaw('amount_paid >= total_price');
                } elseif ($request->payment_status == 'partial') {
                    $q->whereRaw('amount_paid > 0 AND amount_paid < total_price');
                } elseif ($request->payment_status == 'pending') {
                    $q->where('amount_paid', 0);
                }
            });
        }

        // Filter by price range
        if ($request->has('min_price') && !empty($request->min_price)) {
            $query->whereHas('payment', function ($q) use ($request) {
                $q->where('total_price', '>=', $request->min_price);
            });
        }

        if ($request->has('max_price') && !empty($request->max_price)) {
            $query->whereHas('payment', function ($q) use ($request) {
                $q->where('total_price', '<=', $request->max_price);
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        if ($sortBy == 'total_price') {
            $query->join('payments', 'vehicle_transfers.id', '=', 'payments.transfer_id')
                ->orderBy('payments.total_price', $sortOrder)
                ->select('vehicle_transfers.*');
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Paginate results
        $transfers = $query->paginate(15)->withQueryString();

        // Statistics
        $totalTransfers = VehicleTransfer::count();
        $completedTransfers = VehicleTransfer::where('status', 'completed')->count();
        $pendingTransfers = VehicleTransfer::where('status', 'pending')->count();
        $cancelledTransfers = VehicleTransfer::where('status', 'cancelled')->count();

        // Total revenue from completed transfers
        $totalRevenue = Payment::whereHas('transfer', function ($q) {
            $q->where('status', 'completed');
        })->sum('total_price');

        // This month transfers
        $thisMonthTransfers = VehicleTransfer::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();

        // Monthly statistics for last 6 months
        $monthlyStats = VehicleTransfer::selectRaw('
            DATE_FORMAT(transfer_date, "%b %Y") as month,
            COUNT(*) as count,
            COALESCE(SUM(payments.total_price), 0) as revenue
        ')
            ->leftJoin('payments', 'vehicle_transfers.id', '=', 'payments.transfer_id')
            ->where('transfer_date', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderByRaw('MIN(transfer_date) DESC')
            ->get();

        return view('vehicle_transfers.index', compact(
            'transfers',
            'totalTransfers',
            'completedTransfers',
            'pendingTransfers',
            'cancelledTransfers',
            'totalRevenue',
            'thisMonthTransfers',
            'monthlyStats'
        ));
    }



    public function create()
    {
        // Get available vehicles
        $vehicles = Vehicle::where('status', 'available')->get();

        // Get existing customers
        $customers = Customer::all();

        return view('vehicle_transfers.create', compact('vehicles', 'customers'));
    }

    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            // Vehicle Details
            'vehicle_id' => 'required|exists:vehicles,id',
            'purchase_price' => 'required|numeric|min:0',
            'registered_name' => 'required|string|max:255',
            'transferred_by' => 'required|string|max:255',
            'transfer_date' => 'required|date',
            'expenses_borne_by_buyer' => 'boolean',

            // Buyer Details
            'buyer_name' => 'required|string|max:255',
            'buyer_dob' => 'required|date',
            'buyer_citizenship' => 'required|string|max:50',
            'buyer_father_name' => 'required|string|max:255',
            'buyer_grandfather_name' => 'required|string|max:255',
            'buyer_phone' => 'required|string|max:15',
            'buyer_ward_no' => 'required|string|max:10',
            'buyer_municipality_type' => 'required|string',
            'buyer_address' => 'required|string|max:500',

            // Spouse Details (optional)
            'spouse_name' => 'nullable|string|max:255',
            'spouse_citizenship' => 'nullable|string|max:50',
            'spouse_father_name' => 'nullable|string|max:255',
            'spouse_grandfather_name' => 'nullable|string|max:255',
            'spouse_phone' => 'nullable|string|max:15',
            'spouse_ward_no' => 'nullable|string|max:10',
            'spouse_municipality_type' => 'nullable|string',
            'spouse_address' => 'nullable|string|max:500',

            // Seller Details
            'seller_name' => 'required|string|max:255',
            'seller_citizenship' => 'required|string|max:50',
            'seller_father_name' => 'required|string|max:255',
            'seller_grandfather_name' => 'required|string|max:255',
            'seller_phone' => 'required|string|max:15',
            'seller_ward_no' => 'required|string|max:10',
            'seller_municipality_type' => 'required|string',
            'seller_address' => 'required|string|max:500',

            // Witness Details (optional)
            'witness_name' => 'nullable|string|max:255',
            'witness_citizenship' => 'nullable|string|max:50',
            'witness_father_name' => 'nullable|string|max:255',
            'witness_grandfather_name' => 'nullable|string|max:255',
            'witness_phone' => 'nullable|string|max:15',
            'witness_ward_no' => 'nullable|string|max:10',
            'witness_municipality_type' => 'nullable|string',
            'witness_address' => 'nullable|string|max:500',

            // Payment Details
            'total_price' => 'required|numeric|min:0',
            'amount_paid' => 'required|numeric|min:0',
            'amount_received' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:100',
            'payment_date' => 'required|date',
            'payment_notes' => 'nullable|string',

            // Notes
            'notes' => 'nullable|string',
        ]);

        // Start database transaction
        DB::beginTransaction();

        try {
            // 1. Create or find Buyer
            $buyer = Customer::firstOrCreate(
                ['citizenship_number' => $validated['buyer_citizenship']],
                [
                    'name' => $validated['buyer_name'],
                    'date_of_birth' => $validated['buyer_dob'],
                    'father_name' => $validated['buyer_father_name'],
                    'grandfather_name' => $validated['buyer_grandfather_name'],
                    'phone' => $validated['buyer_phone'],
                    'ward_no' => $validated['buyer_ward_no'],
                    'municipality_type' => $validated['buyer_municipality_type'],
                    'address' => $validated['buyer_address'],
                    'customer_type' => 'buyer'
                ]
            );

            // 2. Create or find Seller
            $seller = Customer::firstOrCreate(
                ['citizenship_number' => $validated['seller_citizenship']],
                [
                    'name' => $validated['seller_name'],
                    'father_name' => $validated['seller_father_name'],
                    'grandfather_name' => $validated['seller_grandfather_name'],
                    'phone' => $validated['seller_phone'],
                    'ward_no' => $validated['seller_ward_no'],
                    'municipality_type' => $validated['seller_municipality_type'],
                    'address' => $validated['seller_address'],
                    'customer_type' => 'seller'
                ]
            );

            // 3. Create or find Spouse (if provided)
            $spouse = null;
            if (!empty($validated['spouse_citizenship'])) {
                $spouse = Customer::firstOrCreate(
                    ['citizenship_number' => $validated['spouse_citizenship']],
                    [
                        'name' => $validated['spouse_name'],
                        'father_name' => $validated['spouse_father_name'],
                        'grandfather_name' => $validated['spouse_grandfather_name'],
                        'phone' => $validated['spouse_phone'],
                        'ward_no' => $validated['spouse_ward_no'] ?? $validated['buyer_ward_no'],
                        'municipality_type' => $validated['spouse_municipality_type'] ?? $validated['buyer_municipality_type'],
                        'address' => $validated['spouse_address'] ?? $validated['buyer_address'],
                        'customer_type' => 'buyer'
                    ]
                );
            }

            // 4. Create or find Witness (if provided)
            $witness = null;
            if (!empty($validated['witness_citizenship'])) {
                $witness = Customer::firstOrCreate(
                    ['citizenship_number' => $validated['witness_citizenship']],
                    [
                        'name' => $validated['witness_name'],
                        'father_name' => $validated['witness_father_name'],
                        'grandfather_name' => $validated['witness_grandfather_name'],
                        'phone' => $validated['witness_phone'],
                        'ward_no' => $validated['witness_ward_no'],
                        'municipality_type' => $validated['witness_municipality_type'],
                        'address' => $validated['witness_address'],
                        'customer_type' => 'witness'
                    ]
                );
            }

            // 5. Create Vehicle Transfer
            $transfer = VehicleTransfer::create([
                'vehicle_id' => $validated['vehicle_id'],
                'buyer_id' => $buyer->id,
                'seller_id' => $seller->id,
                'witness_id' => $witness ? $witness->id : null,
                'buyer_spouse_id' => $spouse ? $spouse->id : null,
                'created_by' => auth()->id(),
                'notes' => $validated['notes'] ?? null,
                'expenses_borne_by_buyer' => $request->has('expenses_borne_by_buyer'),
                'transfer_date' => $validated['transfer_date'],
                'registered_name' => $validated['registered_name'],
                'transferred_by' => $validated['transferred_by'],
                'status' => 'pending'
            ]);

            // 6. Create Payment Record
            $payment = Payment::create([
                'transfer_id' => $transfer->id,
                'total_price' => $validated['total_price'],
                'amount_paid' => $validated['amount_paid'],
                'amount_received' => $validated['amount_received'],
                'payment_method' => $validated['payment_method'],
                'payment_type' => $validated['amount_paid'] >= $validated['total_price'] ? 'full' : 'advance',
                'payment_status' => $validated['amount_paid'] >= $validated['total_price'] ? 'paid' : 'partial',
                'payment_notes' => $validated['payment_notes'] ?? null,
                'payment_date' => $validated['payment_date'],
                'received_by' => auth()->id(),
            ]);

            // 7. Update Vehicle Status and Purchase Price
            $vehicle = Vehicle::find($validated['vehicle_id']);
            $vehicle->update([
                'purchase_price' => $validated['purchase_price'],
                'selling_price' => $validated['total_price'],
                'status' => $validated['amount_paid'] >= $validated['total_price'] ? 'sold' : 'reserved',
                'registered_name' => $validated['registered_name'],
            ]);

            // Commit transaction
            DB::commit();

            return redirect()->route('vehicle-transfers.show', $transfer)
                ->with('success', 'Vehicle transfer created successfully! Transfer Number: ' . $transfer->transfer_number);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error creating transfer: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(VehicleTransfer $vehicleTransfer)
    {
        $vehicleTransfer->load(['vehicle', 'buyer', 'seller', 'witness', 'buyerSpouse', 'payment']);
        return view('vehicle_transfers.show', compact('vehicleTransfer'));
    }

    public function edit(VehicleTransfer $vehicleTransfer)
    {
        $vehicles = Vehicle::all();
        $customers = Customer::all();
        $vehicleTransfer->load(['vehicle', 'buyer', 'seller', 'witness', 'buyerSpouse', 'payment']);

        return view('vehicle_transfers.edit', compact('vehicleTransfer', 'vehicles', 'customers'));
    }

    public function update(Request $request, VehicleTransfer $vehicleTransfer)
    {
        // Similar validation as store method
        $validated = $request->validate([
            // Add validation rules
        ]);

        // Update logic
        $vehicleTransfer->update($validated);

        return redirect()->route('vehicle-transfers.show', $vehicleTransfer)
            ->with('success', 'Transfer updated successfully!');
    }

    public function destroy(VehicleTransfer $vehicleTransfer)
    {
        $vehicleTransfer->delete();
        return redirect()->route('vehicle-transfers.index')
            ->with('success', 'Transfer deleted successfully!');
    }

    // public function print($id)
    // {
    //     $transfer = VehicleTransfer::with(['vehicle', 'buyer', 'seller', 'witness', 'payment'])->findOrFail($id);
    //     return view('vehicle_transfers.print', compact('transfer'));
    // }

    public function print($id)
    {
        $transfer = VehicleTransfer::with([
            'vehicle',
            'buyer',
            'seller',
            'witness',
            'buyerSpouse',
            'payment',
            'creator'
        ])->findOrFail($id);

        // You can use a PDF library here, but for now just return a view
        return view('vehicle_transfers.print', compact('transfer'));
    }
}
