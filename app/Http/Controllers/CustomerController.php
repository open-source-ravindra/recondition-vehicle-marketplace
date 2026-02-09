<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::withCount(['boughtTransfers', 'soldTransfers', 'witnessedTransfers']);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('citizenship_number', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by type
        if ($request->has('type') && $request->type != '') {
            $query->where('customer_type', $request->type);
        }

        // Filter by municipality
        if ($request->has('municipality') && $request->municipality != '') {
            $query->where('municipality_type', $request->municipality);
        }

        $customers = $query->latest()->paginate(15);

        // Statistics
        $totalCustomers = Customer::count();
        $buyersCount = Customer::where('customer_type', 'buyer')->count();
        $sellersCount = Customer::where('customer_type', 'seller')->count();
        $witnessesCount = Customer::where('customer_type', 'witness')->count();

        return view('customers.index', compact(
            'customers',
            'totalCustomers',
            'buyersCount',
            'sellersCount',
            'witnessesCount'
        ));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'citizenship_number' => 'required|string|unique:customers',
            'father_name' => 'required|string|max:255',
            'grandfather_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'ward_no' => 'required|string|max:10',
            'municipality_type' => 'required|in:metropolitan_city,sub_metropolitan_city,municipality,rural_municipality',
            'address' => 'required|string|max:500',
            'customer_type' => 'required|in:buyer,seller,witness',
            'email' => 'nullable|email',
            'occupation' => 'nullable|string|max:100',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully!');
    }

    public function show(Customer $customer)
    {
        $customer->load([
            'boughtTransfers.vehicle',
            'soldTransfers.vehicle',
            'witnessedTransfers.vehicle'
        ]);

        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'citizenship_number' => 'required|string|unique:customers,citizenship_number,' . $customer->id,
            'father_name' => 'required|string|max:255',
            'grandfather_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'ward_no' => 'required|string|max:10',
            'municipality_type' => 'required|in:metropolitan_city,sub_metropolitan_city,municipality,rural_municipality',
            'address' => 'required|string|max:500',
            'customer_type' => 'required|in:buyer,seller,witness',
            'email' => 'nullable|email',
            'occupation' => 'nullable|string|max:100',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.show', $customer)
            ->with('success', 'Customer updated successfully!');
    }

    public function destroy(Customer $customer)
    {
        // Check if customer has associated transfers
        if (
            $customer->boughtTransfers()->count() > 0 ||
            $customer->soldTransfers()->count() > 0
        ) {
            return redirect()->back()
                ->with('error', 'Cannot delete customer with associated transfers!');
        }

        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully!');
    }

    // Additional Methods
    public function byType($type)
    {
        $customers = Customer::where('customer_type', $type)
            ->latest()
            ->paginate(15);

        return view('customers.type', compact('customers', 'type'));
    }

    public function search($query)
    {
        $customers = Customer::where('name', 'like', "%{$query}%")
            ->orWhere('citizenship_number', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->take(10)
            ->get();

        return response()->json($customers);
    }

    public function lookup(Request $request)
    {
        $query = $request->get('q');
        $customers = Customer::where('name', 'like', "%{$query}%")
            ->orWhere('citizenship_number', 'like', "%{$query}%")
            ->get();

        return response()->json($customers);
    }
}
