<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    DashboardController,
    VehicleTransferController,
    VehicleController,
    CustomerController,
    PaymentController,
    ReportController,
    PdfController
};

// Home & Auth Routes
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Protected Routes (Require Login)
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // VEHICLE TRANSFERS (Main CRUD)
    Route::prefix('vehicle-transfers')->name('vehicle-transfers.')->group(function () {
        Route::get('/', [VehicleTransferController::class, 'index'])->name('index');
        Route::get('/create', [VehicleTransferController::class, 'create'])->name('create');
        Route::post('/', [VehicleTransferController::class, 'store'])->name('store');
        Route::get('/{vehicleTransfer}', [VehicleTransferController::class, 'show'])->name('show');
        Route::get('/{vehicleTransfer}/edit', [VehicleTransferController::class, 'edit'])->name('edit');
        Route::put('/{vehicleTransfer}', [VehicleTransferController::class, 'update'])->name('update');
        Route::delete('/{vehicleTransfer}', [VehicleTransferController::class, 'destroy'])->name('destroy');
        Route::get('/vehicle-transfers/{id}/print', [VehicleTransferController::class, 'print'])->name('vehicle-transfers.print');
        // Additional Routes for Transfers
        Route::get('/{id}/print', [VehicleTransferController::class, 'print'])->name('print');
        Route::post('/{id}/complete', [VehicleTransferController::class, 'complete'])->name('complete');
        Route::post('/{id}/cancel', [VehicleTransferController::class, 'cancel'])->name('cancel');
    });

    // VEHICLES CRUD
    Route::resource('vehicles', VehicleController::class);
    Route::prefix('vehicles')->name('vehicles.')->group(function () {
        Route::post('/{id}/status', [VehicleController::class, 'updateStatus'])->name('status.update');
        Route::get('/category/{type}', [VehicleController::class, 'byCategory'])->name('category');
    });

    // CUSTOMERS CRUD
    Route::resource('customers', CustomerController::class);
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/type/{type}', [CustomerController::class, 'byType'])->name('type');
        Route::get('/search/{query}', [CustomerController::class, 'search'])->name('search');
    });

    // PAYMENTS CRUD
    Route::resource('payments', PaymentController::class)->except(['create', 'store']);
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::post('/transfer/{transfer_id}', [PaymentController::class, 'store'])->name('store');
        Route::get('/transfer/{transfer_id}', [PaymentController::class, 'byTransfer'])->name('transfer');
        Route::post('/{id}/receipt', [PaymentController::class, 'generateReceipt'])->name('receipt');
    });

    // REPORTS
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('/customers', [ReportController::class, 'customers'])->name('customers');
        Route::get('/vehicles', [ReportController::class, 'vehicles'])->name('vehicles');
        Route::get('/payments', [ReportController::class, 'payments'])->name('payments');
        Route::post('/generate', [ReportController::class, 'generate'])->name('generate');
    });

    // PDF GENERATION
    Route::prefix('pdf')->name('pdf.')->group(function () {
        Route::get('/transfer/{id}', [PdfController::class, 'transferForm'])->name('transfer');
        Route::get('/receipt/{id}', [PdfController::class, 'paymentReceipt'])->name('receipt');
        Route::get('/customer/{id}', [PdfController::class, 'customerDetails'])->name('customer');
    });

    // SEARCH
    Route::get('/search', [DashboardController::class, 'search'])->name('search');

    // SETTINGS (Future Implementation)
    Route::get('/settings', function () {
        return view('settings.index');
    })->name('settings');
});

// API Routes (if needed for AJAX)
Route::prefix('api')->middleware('auth')->group(function () {
    Route::get('/vehicles/available', [VehicleController::class, 'available']);
    Route::get('/customers/lookup', [CustomerController::class, 'lookup']);
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
});
