@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="fas fa-edit"></i> Edit Customer: {{ $customer->name }}
                    </h4>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('customers.update', $customer) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Customer Type -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label required">Customer Type</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="customer_type" 
                                           id="type_buyer" value="buyer" 
                                           {{ old('customer_type', $customer->customer_type) == 'buyer' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="type_buyer">Buyer</label>
                                </div>
                                <!-- Add other radio buttons similarly -->
                            </div>
                        </div>
                        
                        <!-- All other form fields with existing values -->
                        <!-- Example: -->
                        <div class="form-group mb-3">
                            <label class="required">Full Name</label>
                            <input type="text" name="name" class="form-control" 
                                   value="{{ old('name', $customer->name) }}" required>
                        </div>
                        
                        <!-- Form Actions -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('customers.show', $customer) }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Update Customer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection