@extends('layouts.app')

@section('title', $customer->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">
                            <i class="fas fa-user"></i> {{ $customer->name }}
                            <span class="badge bg-{{ $customer->customer_type == 'buyer' ? 'success' : ($customer->customer_type == 'seller' ? 'info' : 'warning') }} ms-2">
                                {{ ucfirst($customer->customer_type) }}
                            </span>
                        </h4>
                        <p class="mb-0 text-muted">Citizenship: {{ $customer->citizenship_number }}</p>
                    </div>
                    <div>
                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Customer Details -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Personal Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="40%">Full Name:</th>
                                            <td>{{ $customer->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Date of Birth:</th>
                                            <td>{{ $customer->date_of_birth ? $customer->date_of_birth->format('Y-m-d') : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Age:</th>
                                            <td>{{ $customer->age ? $customer->age . ' years' : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Father's Name:</th>
                                            <td>{{ $customer->father_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Grandfather's Name:</th>
                                            <td>{{ $customer->grandfather_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Citizenship No.:</th>
                                            <td>{{ $customer->citizenship_number }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Contact Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="40%">Phone:</th>
                                            <td>{{ $customer->phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Additional Phone:</th>
                                            <td>{{ $customer->additional_phone ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email:</th>
                                            <td>{{ $customer->email ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Occupation:</th>
                                            <td>{{ $customer->occupation ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Address:</th>
                                            <td>{{ $customer->address }}</td>
                                        </tr>
                                        <tr>
                                            <th>Ward/Municipality:</th>
                                            <td>Ward {{ $customer->ward_no }}, {{ ucfirst(str_replace('_', ' ', $customer->municipality_type)) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction History -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Transaction History</h5>
                                </div>
                                <div class="card-body">
                                    @if($customer->customer_type == 'buyer')
                                    <h6>Vehicles Bought ({{ $customer->boughtTransfers->count() }})</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Transfer No.</th>
                                                    <th>Vehicle</th>
                                                    <th>Date</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($customer->boughtTransfers as $transfer)
                                                <tr>
                                                    <td>{{ $transfer->transfer_number }}</td>
                                                    <td>{{ $transfer->vehicle->name ?? 'N/A' }}</td>
                                                    <td>{{ $transfer->transfer_date->format('Y-m-d') }}</td>
                                                    <td>Rs. {{ number_format($transfer->payment->total_price ?? 0) }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $transfer->status == 'completed' ? 'success' : ($transfer->status == 'pending' ? 'warning' : 'danger') }}">
                                                            {{ ucfirst($transfer->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No vehicles bought yet</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    @elseif($customer->customer_type == 'seller')
                                    <h6>Vehicles Sold ({{ $customer->soldTransfers->count() }})</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Transfer No.</th>
                                                    <th>Vehicle</th>
                                                    <th>Buyer</th>
                                                    <th>Date</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($customer->soldTransfers as $transfer)
                                                <tr>
                                                    <td>{{ $transfer->transfer_number }}</td>
                                                    <td>{{ $transfer->vehicle->name ?? 'N/A' }}</td>
                                                    <td>{{ $transfer->buyer->name ?? 'N/A' }}</td>
                                                    <td>{{ $transfer->transfer_date->format('Y-m-d') }}</td>
                                                    <td>Rs. {{ number_format($transfer->payment->total_price ?? 0) }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No vehicles sold yet</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <h6>Transactions Witnessed ({{ $customer->witnessedTransfers->count() }})</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Transfer No.</th>
                                                    <th>Vehicle</th>
                                                    <th>Buyer</th>
                                                    <th>Seller</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($customer->witnessedTransfers as $transfer)
                                                <tr>
                                                    <td>{{ $transfer->transfer_number }}</td>
                                                    <td>{{ $transfer->vehicle->name ?? 'N/A' }}</td>
                                                    <td>{{ $transfer->buyer->name ?? 'N/A' }}</td>
                                                    <td>{{ $transfer->seller->name ?? 'N/A' }}</td>
                                                    <td>{{ $transfer->transfer_date->format('Y-m-d') }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No transactions witnessed yet</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection