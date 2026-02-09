@extends('layouts.app')

@section('title', 'Customers')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-users"></i> Customers
        </h1>
        <div>
            <a href="{{ route('customers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Customer
            </a>
            <div class="btn-group ml-2">
                <a href="{{ route('customers.type', 'buyer') }}" class="btn btn-outline-info">Buyers</a>
                <a href="{{ route('customers.type', 'seller') }}" class="btn btn-outline-success">Sellers</a>
                <a href="{{ route('customers.type', 'witness') }}" class="btn btn-outline-warning">Witnesses</a>
            </div>
        </div>
    </div>

    <!-- Customer Statistics -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Customers</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCustomers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                Buyers</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $buyersCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
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
                                Sellers</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sellersCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-gray-300"></i>
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
                                Witnesses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $witnessesCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('customers.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control"
                        placeholder="Search by name, citizenship, phone..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="type" class="form-control">
                        <option value="">All Types</option>
                        <option value="buyer" {{ request('type') == 'buyer' ? 'selected' : '' }}>Buyers</option>
                        <option value="seller" {{ request('type') == 'seller' ? 'selected' : '' }}>Sellers</option>
                        <option value="witness" {{ request('type') == 'witness' ? 'selected' : '' }}>Witnesses</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="municipality" class="form-control">
                        <option value="">All Municipalities</option>
                        <option value="metropolitan_city" {{ request('municipality') == 'metropolitan_city' ? 'selected' : '' }}>Metropolitan City</option>
                        <option value="sub_metropolitan_city" {{ request('municipality') == 'sub_metropolitan_city' ? 'selected' : '' }}>Sub-Metropolitan City</option>
                        <option value="municipality" {{ request('municipality') == 'municipality' ? 'selected' : '' }}>Municipality</option>
                        <option value="rural_municipality" {{ request('municipality') == 'rural_municipality' ? 'selected' : '' }}>Rural Municipality</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Customers Table -->
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Citizenship No.</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Type</th>
                            <th>Total Transactions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $customer->name }}</strong><br>
                                <small class="text-muted">Father: {{ $customer->father_name }}</small>
                            </td>
                            <td>{{ $customer->citizenship_number }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>
                                <small>{{ $customer->address }}</small><br>
                                <small class="text-muted">Ward {{ $customer->ward_no }}, {{ ucfirst(str_replace('_', ' ', $customer->municipality_type)) }}</small>
                            </td>
                            <td>
                                <span class="badge bg-{{ $customer->customer_type == 'buyer' ? 'success' : ($customer->customer_type == 'seller' ? 'info' : 'warning') }}">
                                    {{ ucfirst($customer->customer_type) }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($customer->customer_type == 'buyer')
                                <span class="badge bg-primary">{{ $customer->bought_transfers_count }} bought</span>
                                @elseif($customer->customer_type == 'seller')
                                <span class="badge bg-info">{{ $customer->sold_transfers_count }} sold</span>
                                @else
                                <span class="badge bg-secondary">{{ $customer->witnessed_transfers_count }} witnessed</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete"
                                            onclick="return confirm('Are you sure you want to delete this customer?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $customers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection