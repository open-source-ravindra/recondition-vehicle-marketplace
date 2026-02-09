<?php

namespace App\Http\Controllers;

use App\Models\VehicleTransfer;
use App\Models\Vehicle;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Total statistics
        $totalTransfers = VehicleTransfer::count();
        $totalVehicles = Vehicle::count();
        $totalCustomers = Customer::count();
        $totalRevenue = Payment::sum('total_price');

        // Recent transfers
        $recentTransfers = VehicleTransfer::with(['vehicle', 'buyer'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Monthly revenue
        $monthlyRevenue = Payment::selectRaw('
                YEAR(payment_date) as year,
                MONTH(payment_date) as month,
                SUM(total_price) as revenue
            ')
            ->whereYear('payment_date', date('Y'))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(6)
            ->get();

        // Vehicle status count
        $vehicleStatus = Vehicle::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();

        return view('dashboard', compact(
            'totalTransfers',
            'totalVehicles',
            'totalCustomers',
            'totalRevenue',
            'recentTransfers',
            'monthlyRevenue',
            'vehicleStatus'
        ));
    }
}
