@extends('layouts.app')

@section('title', 'Add New Vehicle')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-motorcycle"></i> Add New Vehicle
                    </h4>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('vehicles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Basic Information -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="border-bottom pb-2">Basic Information</h5>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="required">Vehicle Name</label>
                                    <input type="text" name="name" class="form-control" 
                                           value="{{ old('name') }}" required placeholder="e.g., Hero Splendor Plus">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="required">Vehicle Type</label>
                                    <select name="vehicle_type" class="form-control" required>
                                        <option value="">Select Type</option>
                                        <option value="bike" {{ old('vehicle_type') == 'bike' ? 'selected' : '' }}>Bike</option>
                                        <option value="car" {{ old('vehicle_type') == 'car' ? 'selected' : '' }}>Car</option>
                                        <option value="scooter" {{ old('vehicle_type') == 'scooter' ? 'selected' : '' }}>Scooter</option>
                                        <option value="other" {{ old('vehicle_type') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="required">CC</label>
                                    <input type="number" name="cc" class="form-control" 
                                           value="{{ old('cc') }}" required placeholder="e.g., 100">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="required">Manufacture Year</label>
                                    <input type="number" name="manufacture_year" class="form-control" 
                                           value="{{ old('manufacture_year') }}" required 
                                           min="1900" max="{{ date('Y') + 1 }}">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="required">Condition</label>
                                    <select name="condition" class="form-control" required>
                                        <option value="">Select Condition</option>
                                        <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>New</option>
                                        <option value="excellent" {{ old('condition') == 'excellent' ? 'selected' : '' }}>Excellent</option>
                                        <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>Good</option>
                                        <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Used</option>
                                        <option value="fair" {{ old('condition') == 'fair' ? 'selected' : '' }}>Fair</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label>Color</label>
                                    <input type="text" name="color" class="form-control" 
                                           value="{{ old('color') }}" placeholder="e.g., Black">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label>Mileage (km)</label>
                                    <input type="number" name="mileage" class="form-control" 
                                           value="{{ old('mileage') }}" placeholder="e.g., 15000">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Identification Numbers -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="border-bottom pb-2">Identification Numbers</h5>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="required">Engine Number</label>
                                    <input type="text" name="engine_number" class="form-control" 
                                           value="{{ old('engine_number') }}" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="required">Chassis Number</label>
                                    <input type="text" name="chassis_number" class="form-control" 
                                           value="{{ old('chassis_number') }}" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Vehicle Number</label>
                                    <input type="text" name="vehicle_number" class="form-control" 
                                           value="{{ old('vehicle_number') }}">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pricing Information -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="border-bottom pb-2">Pricing Information</h5>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="required">Purchase Price (रु)</label>
                                    <input type="number" name="purchase_price" class="form-control" 
                                           value="{{ old('purchase_price') }}" required step="0.01">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label>Selling Price (रु)</label>
                                    <input type="number" name="selling_price" class="form-control" 
                                           value="{{ old('selling_price') }}" step="0.01">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="required">Purchase Date</label>
                                    <input type="date" name="purchase_date" class="form-control" 
                                           value="{{ old('purchase_date', date('Y-m-d')) }}" required>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Technical Details -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="border-bottom pb-2">Technical Details</h5>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label>Fuel Type</label>
                                    <select name="fuel_type" class="form-control">
                                        <option value="">Select Fuel Type</option>
                                        <option value="petrol" {{ old('fuel_type') == 'petrol' ? 'selected' : '' }}>Petrol</option>
                                        <option value="diesel" {{ old('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                        <option value="electric" {{ old('fuel_type') == 'electric' ? 'selected' : '' }}>Electric</option>
                                        <option value="hybrid" {{ old('fuel_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label>Transmission</label>
                                    <select name="transmission" class="form-control">
                                        <option value="">Select Transmission</option>
                                        <option value="manual" {{ old('transmission') == 'manual' ? 'selected' : '' }}>Manual</option>
                                        <option value="automatic" {{ old('transmission') == 'automatic' ? 'selected' : '' }}>Automatic</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label>Owner Count</label>
                                    <input type="number" name="owner_count" class="form-control" 
                                           value="{{ old('owner_count', 1) }}" min="1">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Registration Details -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="border-bottom pb-2">Registration Details</h5>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="required">Registered Name</label>
                                    <input type="text" name="registered_name" class="form-control" 
                                           value="{{ old('registered_name') }}" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="required">Transferred By</label>
                                    <input type="text" name="transferred_by" class="form-control" 
                                           value="{{ old('transferred_by') }}" required>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Documentation -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="border-bottom pb-2">Documentation</h5>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label>Insurance Valid Until</label>
                                    <input type="date" name="insurance_valid_until" class="form-control" 
                                           value="{{ old('insurance_valid_until') }}">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label>Tax Paid Until</label>
                                    <input type="date" name="tax_paid_until" class="form-control" 
                                           value="{{ old('tax_paid_until') }}">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="required">Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                                        <option value="under_maintenance" {{ old('status') == 'under_maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                                        <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Images -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="border-bottom pb-2">Vehicle Images</h5>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label>Upload Images (Max 5 images, 2MB each)</label>
                                    <input type="file" name="images[]" class="form-control" multiple 
                                           accept="image/*">
                                    <small class="text-muted">You can upload multiple images at once</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Description -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label>Remarks</label>
                                    <textarea name="remarks" class="form-control" rows="2">{{ old('remarks') }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Form Actions -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Back
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Save Vehicle
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

<style>
.required:after {
    content: " *";
    color: red;
}
</style>