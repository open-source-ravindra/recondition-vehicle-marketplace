@extends('layouts.app')

@section('title', $vehicle->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">
                            <i class="fas fa-motorcycle"></i> {{ $vehicle->name }}
                            <span class="badge bg-{{ $vehicle->status == 'available' ? 'success' : ($vehicle->status == 'sold' ? 'danger' : 'warning') }} ms-2">
                                {{ ucfirst($vehicle->status) }}
                            </span>
                        </h4>
                        <p class="mb-0 text-muted">{{ $vehicle->cc }}cc • {{ $vehicle->manufacture_year }} • {{ $vehicle->color }}</p>
                    </div>
                    <div>
                        <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <!-- Vehicle Images -->
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Vehicle Images</h5>
                                </div>
                                <div class="card-body text-center">
                                    @if($vehicle->hasImages())
                                        <div id="vehicleImages" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                @foreach($vehicle->images_array as $key => $image)
                                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                    <img src="{{ asset('storage/' . $image) }}" 
                                                         class="d-block w-100" 
                                                         alt="Vehicle Image {{ $key + 1 }}"
                                                         style="height: 300px; object-fit: cover;">
                                                </div>
                                                @endforeach
                                            </div>
                                            @if(count($vehicle->images_array) > 1)
                                            <button class="carousel-control-prev" type="button" data-bs-target="#vehicleImages" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#vehicleImages" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                            @endif
                                        </div>
                                    @else
                                        <div class="no-image text-center py-5">
                                            <i class="fas fa-image fa-5x text-muted mb-3"></i>
                                            <p class="text-muted">No images available</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Basic Information -->
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">Basic Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-sm">
                                                <tr>
                                                    <th width="40%">Vehicle Name:</th>
                                                    <td>{{ $vehicle->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Vehicle Type:</th>
                                                    <td>{{ $vehicle->vehicle_type_text }}</td>
                                                </tr>
                                                <tr>
                                                    <th>CC:</th>
                                                    <td>{{ $vehicle->cc }} cc</td>
                                                </tr>
                                                <tr>
                                                    <th>Manufacture Year:</th>
                                                    <td>{{ $vehicle->manufacture_year }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Condition:</th>
                                                    <td>{{ ucfirst($vehicle->condition) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Color:</th>
                                                    <td>{{ $vehicle->color ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Mileage:</th>
                                                    <td>{{ $vehicle->mileage ? number_format($vehicle->mileage) . ' km' : 'N/A' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Identification Numbers -->
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">Identification Numbers</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-sm">
                                                <tr>
                                                    <th width="40%">Engine Number:</th>
                                                    <td>{{ $vehicle->engine_number }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Chassis Number:</th>
                                                    <td>{{ $vehicle->chassis_number }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Vehicle Number:</th>
                                                    <td>{{ $vehicle->vehicle_number ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Registered Name:</th>
                                                    <td>{{ $vehicle->registered_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Transferred By:</th>
                                                    <td>{{ $vehicle->transferred_by }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Owner Count:</th>
                                                    <td>{{ $vehicle->owner_count }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Pricing Information -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">Pricing Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-sm">
                                                <tr>
                                                    <th width="40%">Purchase Price:</th>
                                                    <td class="text-danger">Rs. {{ number_format($vehicle->purchase_price) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Selling Price:</th>
                                                    <td class="text-success">Rs. {{ number_format($vehicle->selling_price) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Profit:</th>
                                                    <td class="{{ $vehicle->profit >= 0 ? 'text-success' : 'text-danger' }}">
                                                        Rs. {{ number_format($vehicle->profit) }}
                                                        @if($vehicle->profit_percentage)
                                                            <small>({{ number_format($vehicle->profit_percentage, 1) }}%)</small>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Purchase Date:</th>
                                                    <td>{{ $vehicle->purchase_date->format('Y-m-d') }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Age:</th>
                                                    <td>{{ $vehicle->age }} years</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Technical Details -->
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">Technical Details</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-sm">
                                                <tr>
                                                    <th width="40%">Fuel Type:</th>
                                                    <td>{{ ucfirst($vehicle->fuel_type) ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Transmission:</th>
                                                    <td>{{ ucfirst($vehicle->transmission) ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Insurance Valid Until:</th>
                                                    <td>{{ $vehicle->insurance_valid_until ? $vehicle->insurance_valid_until->format('Y-m-d') : 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Tax Paid Until:</th>
                                                    <td>{{ $vehicle->tax_paid_until ? $vehicle->tax_paid_until->format('Y-m-d') : 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Status:</th>
                                                    <td>
                                                        <span class="badge bg-{{ $vehicle->status == 'available' ? 'success' : ($vehicle->status == 'sold' ? 'danger' : 'warning') }}">
                                                            {{ ucfirst($vehicle->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Description and Remarks -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Description</h5>
                                </div>
                                <div class="card-body">
                                    {{ $vehicle->description ?? 'No description available' }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Remarks</h5>
                                </div>
                                <div class="card-body">
                                    {{ $vehicle->remarks ?? 'No remarks available' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Transfer History -->
                    @if($vehicle->transfers->count() > 0)
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Transfer History</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Transfer No.</th>
                                                    <th>Buyer</th>
                                                    <th>Seller</th>
                                                    <th>Date</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($vehicle->transfers as $transfer)
                                                <tr>
                                                    <td>{{ $transfer->transfer_number }}</td>
                                                    <td>{{ $transfer->buyer->name ?? 'N/A' }}</td>
                                                    <td>{{ $transfer->seller->name ?? 'N/A' }}</td>
                                                    <td>{{ $transfer->transfer_date->format('Y-m-d') }}</td>
                                                    <td>Rs. {{ number_format($transfer->payment->total_price ?? 0) }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $transfer->status == 'completed' ? 'success' : ($transfer->status == 'pending' ? 'warning' : 'danger') }}">
                                                            {{ ucfirst($transfer->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection