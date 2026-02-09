@extends('layouts.app')

@section('title', 'Vehicle Transfers')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-exchange-alt text-primary"></i> Vehicle Transfers
            </h1>
            <p class="mb-0">Manage all vehicle transfer transactions</p>
        </div>
        <div>
            <a href="{{ route('vehicle-transfers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> New Transfer
            </a>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="fas fa-filter"></i> Filters
            </button>
            @if(request()->hasAny(['search', 'status', 'from_date', 'to_date', 'vehicle_type']))
                <a href="{{ route('vehicle-transfers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Clear Filters
                </a>
            @endif
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Transfers</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTransfers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exchange-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Completed</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $completedTransfers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingTransfers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Cancelled</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $cancelledTransfers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Revenue</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rs. {{ number_format($totalRevenue) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-rupee-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                This Month</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $thisMonthTransfers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('vehicle-transfers.index') }}" method="GET" class="row g-3">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" 
                               placeholder="Search by transfer number, vehicle, buyer, seller, citizenship..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Transfers Table -->
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list"></i> Recent Transfers
            </h6>
            <div>
                <span class="text-muted">Showing {{ $transfers->firstItem() }} to {{ $transfers->lastItem() }} of {{ $transfers->total() }} transfers</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th width="120">Transfer No.</th>
                            <th>Vehicle Details</th>
                            <th>Buyer</th>
                            <th>Seller</th>
                            <th width="100">Date</th>
                            <th width="120">Amount</th>
                            <th width="100">Status</th>
                            <th width="120" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transfers as $transfer)
                        <tr>
                            <td>
                                <strong class="text-primary">{{ $transfer->transfer_number }}</strong><br>
                                <small class="text-muted">{{ $transfer->created_at->format('M d, Y') }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($transfer->vehicle->first_image)
                                        <img src="{{ asset('storage/' . $transfer->vehicle->first_image) }}" 
                                             class="img-thumbnail me-3" 
                                             style="width: 60px; height: 45px; object-fit: cover;"
                                             alt="{{ $transfer->vehicle->name }}">
                                    @else
                                        <div class="img-thumbnail me-3 d-flex align-items-center justify-content-center"
                                             style="width: 60px; height: 45px; background: #f8f9fa;">
                                            <i class="fas fa-motorcycle text-muted"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <strong>{{ $transfer->vehicle->name }}</strong><br>
                                        <small class="text-muted">
                                            {{ $transfer->vehicle->cc }}cc • 
                                            {{ $transfer->vehicle->manufacture_year }} • 
                                            {{ $transfer->vehicle->engine_number }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <strong>{{ $transfer->buyer->name }}</strong><br>
                                <small class="text-muted">
                                    {{ $transfer->buyer->citizenship_number }}<br>
                                    {{ $transfer->buyer->phone }}
                                </small>
                            </td>
                            <td>
                                <strong>{{ $transfer->seller->name }}</strong><br>
                                <small class="text-muted">
                                    {{ $transfer->seller->citizenship_number }}<br>
                                    {{ $transfer->seller->phone }}
                                </small>
                            </td>
                            <td>
                                {{ $transfer->transfer_date->format('Y-m-d') }}<br>
                                <small class="text-muted">{{ $transfer->transfer_date->diffForHumans() }}</small>
                            </td>
                            <td>
                                <strong class="text-success">Rs. {{ number_format($transfer->total_amount) }}</strong><br>
                                <small class="{{ $transfer->amount_due > 0 ? 'text-warning' : 'text-success' }}">
                                    {{ $transfer->is_fully_paid ? 'Fully Paid' : 'Due: Rs. ' . number_format($transfer->amount_due) }}
                                </small>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-pill py-2 px-3 bg-{{ $transfer->status_badge }}">
                                    <i class="fas fa-circle fa-xs me-1"></i>
                                    {{ $transfer->status_text }}
                                </span>
                                @if(!$transfer->is_fully_paid && $transfer->status == 'pending')
                                    <div class="progress mt-1" style="height: 5px;">
                                        <div class="progress-bar bg-warning" 
                                             role="progressbar" 
                                             style="width: {{ $transfer->payment ? $transfer->payment->payment_percentage : 0 }}%">
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ $transfer->payment ? number_format($transfer->payment->payment_percentage, 0) : 0 }}% Paid</small>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('vehicle-transfers.show', $transfer) }}" 
                                       class="btn btn-info" 
                                       title="View Details" 
                                       data-bs-toggle="tooltip">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('vehicle-transfers.edit', $transfer) }}" 
                                       class="btn btn-warning" 
                                       title="Edit" 
                                       data-bs-toggle="tooltip">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('vehicle-transfers.print', $transfer) }}" 
                                       class="btn btn-secondary" 
                                       title="Print Form" 
                                       data-bs-toggle="tooltip"
                                       target="_blank">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    @if(auth()->user()->isAdmin() && $transfer->status != 'cancelled')
                                        <form action="{{ route('vehicle-transfers.destroy', $transfer) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this transfer?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-danger" 
                                                    title="Delete"
                                                    data-bs-toggle="tooltip">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                <div class="mt-2">
                                    <small>
                                        <a href="{{ route('payments.transfer', $transfer->id) }}" 
                                           class="text-primary">
                                            <i class="fas fa-money-bill-wave"></i> Payments
                                        </a>
                                    </small>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                                    <h5>No transfers found</h5>
                                    <p class="text-muted">No vehicle transfers have been recorded yet.</p>
                                    @if(request()->hasAny(['search', 'status', 'from_date', 'to_date']))
                                        <a href="{{ route('vehicle-transfers.index') }}" class="btn btn-primary">
                                            <i class="fas fa-times"></i> Clear Filters
                                        </a>
                                    @endif
                                    <a href="{{ route('vehicle-transfers.create') }}" class="btn btn-success">
                                        <i class="fas fa-plus"></i> Create First Transfer
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Showing {{ $transfers->firstItem() }} to {{ $transfers->lastItem() }} of {{ $transfers->total() }} entries
                </div>
                <div>
                    {{ $transfers->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-chart-bar"></i> Monthly Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($monthlyStats as $stat)
                        <div class="col-md-2 col-sm-4 mb-3">
                            <div class="text-center p-3 border rounded">
                                <div class="text-muted small">{{ $stat->month }}</div>
                                <div class="h5 mb-1">{{ $stat->count }}</div>
                                <div class="text-success small">Rs. {{ number_format($stat->revenue) }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="filterModalLabel">
                    <i class="fas fa-filter"></i> Advanced Filters
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('vehicle-transfers.index') }}" method="GET">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date Range</label>
                            <div class="input-group">
                                <span class="input-group-text">From</span>
                                <input type="date" name="from_date" class="form-control" 
                                       value="{{ request('from_date') }}">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="input-group">
                                <span class="input-group-text">To</span>
                                <input type="date" name="to_date" class="form-control" 
                                       value="{{ request('to_date') }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Vehicle Type</label>
                            <select name="vehicle_type" class="form-control">
                                <option value="">All Types</option>
                                <option value="bike" {{ request('vehicle_type') == 'bike' ? 'selected' : '' }}>Bike</option>
                                <option value="car" {{ request('vehicle_type') == 'car' ? 'selected' : '' }}>Car</option>
                                <option value="scooter" {{ request('vehicle_type') == 'scooter' ? 'selected' : '' }}>Scooter</option>
                                <option value="other" {{ request('vehicle_type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Payment Status</label>
                            <select name="payment_status" class="form-control">
                                <option value="">All</option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Fully Paid</option>
                                <option value="partial" {{ request('payment_status') == 'partial' ? 'selected' : '' }}>Partial Payment</option>
                                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending Payment</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price Range</label>
                            <div class="input-group">
                                <span class="input-group-text">Min</span>
                                <input type="number" name="min_price" class="form-control" 
                                       placeholder="Min Price" value="{{ request('min_price') }}">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="input-group">
                                <span class="input-group-text">Max</span>
                                <input type="number" name="max_price" class="form-control" 
                                       placeholder="Max Price" value="{{ request('max_price') }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sort By</label>
                            <select name="sort_by" class="form-control">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Date Created</option>
                                <option value="transfer_date" {{ request('sort_by') == 'transfer_date' ? 'selected' : '' }}>Transfer Date</option>
                                <option value="total_price" {{ request('sort_by') == 'total_price' ? 'selected' : '' }}>Amount</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sort Order</label>
                            <select name="sort_order" class="form-control">
                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <a href="{{ route('vehicle-transfers.index') }}" class="btn btn-warning">
                        <i class="fas fa-undo"></i> Reset
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Auto-submit form when filter changes
        $('select[name="status"]').change(function() {
            if ($(this).val()) {
                $(this).closest('form').submit();
            }
        });

        // Date range validation
        $('input[name="to_date"]').change(function() {
            var fromDate = $('input[name="from_date"]').val();
            var toDate = $(this).val();
            
            if (fromDate && toDate && new Date(toDate) < new Date(fromDate)) {
                alert('To date cannot be earlier than from date');
                $(this).val('');
            }
        });

        // Price range validation
        $('input[name="max_price"]').change(function() {
            var minPrice = $('input[name="min_price"]').val();
            var maxPrice = $(this).val();
            
            if (minPrice && maxPrice && parseFloat(maxPrice) < parseFloat(minPrice)) {
                alert('Maximum price cannot be less than minimum price');
                $(this).val('');
            }
        });

        // Quick status update
        $('.status-update').click(function(e) {
            e.preventDefault();
            var transferId = $(this).data('id');
            var newStatus = $(this).data('status');
            var url = $(this).data('url');
            
            if (confirm('Are you sure you want to change the status?')) {
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: newStatus
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        alert('Error updating status');
                    }
                });
            }
        });
    });
</script>
@endsection

@section('styles')
<style>
    .empty-state {
        padding: 40px 20px;
        text-align: center;
    }
    
    .empty-state i {
        opacity: 0.5;
    }
    
    .badge-pill {
        border-radius: 50rem;
    }
    
    .progress {
        border-radius: 10px;
    }
    
    .img-thumbnail {
        border-radius: 5px;
        border: 1px solid #dee2e6;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    
    .bg-pending { background-color: #ffc107 !important; color: #000; }
    .bg-completed { background-color: #198754 !important; color: #fff; }
    .bg-cancelled { background-color: #dc3545 !important; color: #fff; }
    .bg-in_progress { background-color: #0dcaf0 !important; color: #000; }
    
    .status-badge {
        display: inline-block;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
    }
    
    .action-buttons .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .btn-group .btn {
            padding: 0.2rem 0.4rem;
            font-size: 0.75rem;
        }
        
        .stat-card .h5 {
            font-size: 1rem;
        }
    }
</style>
@endsection