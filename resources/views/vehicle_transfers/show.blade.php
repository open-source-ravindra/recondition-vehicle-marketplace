@extends('layouts.app')

@section('title', 'Transfer Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                    <div>
                        <h4 class="mb-0">
                            <i class="fas fa-file-contract"></i> Transfer Details
                        </h4>
                        <p class="mb-0">Transfer Number: {{ $vehicleTransfer->transfer_number }}</p>
                    </div>
                    <div>
                        <a href="{{ route('vehicle-transfers.print', $vehicleTransfer) }}" class="btn btn-light" target="_blank">
                            <i class="fas fa-print"></i> Print
                        </a>
                        <a href="{{ route('vehicle-transfers.edit', $vehicleTransfer) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('vehicle-transfers.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Status Badge -->
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            <span class="badge bg-{{ $vehicleTransfer->status_badge }} p-3 fs-6">
                                <i class="fas fa-info-circle"></i> Status: {{ $vehicleTransfer->status_text }}
                            </span>
                            @if($vehicleTransfer->payment)
                                <span class="badge bg-{{ $vehicleTransfer->is_fully_paid ? 'success' : 'warning' }} p-3 fs-6 ms-2">
                                    <i class="fas fa-money-bill-wave"></i> 
                                    Payment: {{ $vehicleTransfer->is_fully_paid ? 'Fully Paid' : 'Partial' }}
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Vehicle Information -->
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0"><i class="fas fa-motorcycle"></i> Vehicle Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th>Vehicle:</th>
                                            <td>{{ $vehicleTransfer->vehicle->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>CC:</th>
                                            <td>{{ $vehicleTransfer->vehicle->cc }} cc</td>
                                        </tr>
                                        <tr>
                                            <th>Engine No:</th>
                                            <td>{{ $vehicleTransfer->vehicle->engine_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Chassis No:</th>
                                            <td>{{ $vehicleTransfer->vehicle->chassis_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Registered Name:</th>
                                            <td>{{ $vehicleTransfer->vehicle->registered_name }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Buyer Information -->
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="fas fa-user"></i> Buyer Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th>Name:</th>
                                            <td>{{ $vehicleTransfer->buyer->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Citizenship:</th>
                                            <td>{{ $vehicleTransfer->buyer->citizenship_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone:</th>
                                            <td>{{ $vehicleTransfer->buyer->phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Address:</th>
                                            <td>{{ $vehicleTransfer->buyer->address }}</td>
                                        </tr>
                                        <tr>
                                            <th>Ward/Municipality:</th>
                                            <td>Ward {{ $vehicleTransfer->buyer->ward_no }}, {{ ucfirst(str_replace('_', ' ', $vehicleTransfer->buyer->municipality_type)) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Seller Information -->
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-header bg-warning text-dark">
                                    <h5 class="mb-0"><i class="fas fa-user-tie"></i> Seller Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th>Name:</th>
                                            <td>{{ $vehicleTransfer->seller->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Citizenship:</th>
                                            <td>{{ $vehicleTransfer->seller->citizenship_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone:</th>
                                            <td>{{ $vehicleTransfer->seller->phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Address:</th>
                                            <td>{{ $vehicleTransfer->seller->address }}</td>
                                        </tr>
                                        <tr>
                                            <th>Ward/Municipality:</th>
                                            <td>Ward {{ $vehicleTransfer->seller->ward_no }}, {{ ucfirst(str_replace('_', ' ', $vehicleTransfer->seller->municipality_type)) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Transfer Details -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="mb-0"><i class="fas fa-exchange-alt"></i> Transfer Details</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th>Transfer Date:</th>
                                            <td>{{ $vehicleTransfer->formatted_transfer_date }}</td>
                                        </tr>
                                        <tr>
                                            <th>Transferred By:</th>
                                            <td>{{ $vehicleTransfer->vehicle->transferred_by }}</td>
                                        </tr>
                                        <tr>
                                            <th>Expenses Borne By:</th>
                                            <td>{{ $vehicleTransfer->expenses_borne_by_buyer ? 'Buyer' : 'Seller' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Created By:</th>
                                            <td>{{ $vehicleTransfer->creator->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Created At:</th>
                                            <td>{{ $vehicleTransfer->created_at->format('Y-m-d H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Payment Details -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="fas fa-money-bill-wave"></i> Payment Details</h5>
                                </div>
                                <div class="card-body">
                                    @if($vehicleTransfer->payment)
                                    <table class="table table-sm">
                                        <tr>
                                            <th>Total Price:</th>
                                            <td class="fs-5 text-success">Rs. {{ number_format($vehicleTransfer->payment->total_price) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Amount Paid:</th>
                                            <td class="fs-5">Rs. {{ number_format($vehicleTransfer->payment->amount_paid) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Amount Due:</th>
                                            <td class="fs-5 {{ $vehicleTransfer->amount_due > 0 ? 'text-danger' : 'text-success' }}">
                                                Rs. {{ number_format($vehicleTransfer->amount_due) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Payment Method:</th>
                                            <td>{{ $vehicleTransfer->payment->payment_method_text }}</td>
                                        </tr>
                                        <tr>
                                            <th>Payment Date:</th>
                                            <td>{{ $vehicleTransfer->payment->formatted_payment_date }}</td>
                                        </tr>
                                        <tr>
                                            <th>Payment Status:</th>
                                            <td>
                                                <span class="badge bg-{{ $vehicleTransfer->payment->payment_status == 'paid' ? 'success' : ($vehicleTransfer->payment->payment_status == 'partial' ? 'warning' : 'danger') }}">
                                                    {{ $vehicleTransfer->payment->payment_status_text }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                    @else
                                    <p class="text-center text-muted">No payment details available</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Information -->
                    <div class="row">
                        <!-- Witness Information -->
                        @if($vehicleTransfer->witness)
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0"><i class="fas fa-user-check"></i> Witness Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th>Name:</th>
                                            <td>{{ $vehicleTransfer->witness->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Citizenship:</th>
                                            <td>{{ $vehicleTransfer->witness->citizenship_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone:</th>
                                            <td>{{ $vehicleTransfer->witness->phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Address:</th>
                                            <td>{{ $vehicleTransfer->witness->address }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Spouse Information -->
                        @if($vehicleTransfer->buyerSpouse)
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="mb-0"><i class="fas fa-user-friends"></i> Spouse Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th>Name:</th>
                                            <td>{{ $vehicleTransfer->buyerSpouse->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Citizenship:</th>
                                            <td>{{ $vehicleTransfer->buyerSpouse->citizenship_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone:</th>
                                            <td>{{ $vehicleTransfer->buyerSpouse->phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Address:</th>
                                            <td>{{ $vehicleTransfer->buyerSpouse->address }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Notes -->
                    @if($vehicleTransfer->notes)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fas fa-sticky-note"></i> Notes</h5>
                                </div>
                                <div class="card-body">
                                    {{ $vehicleTransfer->notes }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-center">
                                @if($vehicleTransfer->status == 'pending' && auth()->user()->isAdmin())
                                <form action="{{ route('vehicle-transfers.complete', $vehicleTransfer) }}" method="POST" class="me-2">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success" onclick="return confirm('Mark this transfer as completed?')">
                                        <i class="fas fa-check-circle"></i> Mark as Completed
                                    </button>
                                </form>
                                @endif
                                
                                @if($vehicleTransfer->status != 'cancelled')
                                <form action="{{ route('vehicle-transfers.cancel', $vehicleTransfer) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Cancel this transfer?')">
                                        <i class="fas fa-times-circle"></i> Cancel Transfer
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection