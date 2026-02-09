@extends('layouts.app')

@section('title', 'Vehicles')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-motorcycle"></i> Vehicles
        </h1>
        <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Vehicle
        </a>
    </div>

    <!-- Vehicle Statistics -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Available</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $availableCount ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Sold</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $soldCount ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Value</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rs. {{ number_format($totalValue ?? 0) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-rupee-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Under Maintenance</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $maintenanceCount ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tools fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vehicles Table -->
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>CC</th>
                            <th>Year</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vehicles as $vehicle)
                        <tr>
                            <td>
                                @if($vehicle->first_image)
                                    <img src="{{ asset('storage/' . $vehicle->first_image) }}" 
                                         alt="{{ $vehicle->name }}" 
                                         style="width: 80px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="no-image" style="width: 80px; height: 60px; background: #eee; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $vehicle->name }}</strong><br>
                                <small class="text-muted">{{ $vehicle->engine_number }}</small>
                            </td>
                            <td>{{ $vehicle->vehicle_type_text }}</td>
                            <td>{{ $vehicle->cc }} cc</td>
                            <td>{{ $vehicle->manufacture_year }}</td>
                            <td>
                                <strong>Rs. {{ number_format($vehicle->selling_price) }}</strong><br>
                                <small>Cost: Rs. {{ number_format($vehicle->purchase_price) }}</small>
                            </td>
                            <td>
                                <span class="badge bg-{{ $vehicle->status == 'available' ? 'success' : ($vehicle->status == 'sold' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($vehicle->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No vehicles found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $vehicles->links() }}
            </div>
        </div>
    </div>
</div>
@endsection