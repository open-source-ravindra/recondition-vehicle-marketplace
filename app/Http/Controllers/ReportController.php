<?php

namespace App\Http\Controllers;

use App\Models\VehicleTransfer;
use App\Models\Vehicle;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $query = VehicleTransfer::with(['vehicle', 'buyer', 'seller', 'payment'])
            ->where('status', 'completed');

        // Date filtering
        if ($request->has('from_date')) {
            $query->whereDate('transfer_date', '>=', $request->from_date);
        }
        if ($request->has('to_date')) {
            $query->whereDate('transfer_date', '<=', $request->to_date);
        }

        $transfers = $query->latest()->paginate(20);

        // Summary
        $totalSales = $transfers->count();
        $totalRevenue = $transfers->sum(function ($transfer) {
            return $transfer->payment ? $transfer->payment->total_price : 0;
        });

        return view('reports.sales', compact('transfers', 'totalSales', 'totalRevenue'));
    }

    public function customers()
    {
        $customers = Customer::withCount(['boughtTransfers', 'soldTransfers'])
            ->orderBy('bought_transfers_count', 'desc')
            ->paginate(20);

        return view('reports.customers', compact('customers'));
    }

    public function vehicles()
    {
        $vehicles = Vehicle::with(['transfers'])
            ->withCount(['transfers'])
            ->orderBy('transfers_count', 'desc')
            ->paginate(20);

        $vehicleTypes = Vehicle::selectRaw('vehicle_type, count(*) as count')
            ->groupBy('vehicle_type')
            ->get();

        return view('reports.vehicles', compact('vehicles', 'vehicleTypes'));
    }

    public function payments(Request $request)
    {
        $query = Payment::with(['transfer', 'transfer.vehicle']);

        if ($request->has('month')) {
            $month = Carbon::parse($request->month);
            $query->whereMonth('payment_date', $month->month)
                ->whereYear('payment_date', $month->year);
        }

        $payments = $query->latest()->paginate(20);

        $totalAmount = $payments->sum('total_price');
        $totalPaid = $payments->sum('amount_paid');
        $totalPending = $totalAmount - $totalPaid;

        return view('reports.payments', compact('payments', 'totalAmount', 'totalPaid', 'totalPending'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:sales,customers,vehicles,payments',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'format' => 'required|in:pdf,excel,view',
        ]);

        // Generate report based on type
        // This is a simplified version - you'd implement full logic here

        return response()->json([
            'message' => 'Report generated successfully',
            'data' => []
        ]);
    }
}
