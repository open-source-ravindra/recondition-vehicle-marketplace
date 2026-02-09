@extends('layouts.app')

@section('title', 'Add New Customer')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user-plus"></i> Add New Customer
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('customers.store') }}" method="POST">
                        @csrf

                        <!-- Customer Type -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label required">Customer Type</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="customer_type"
                                        id="type_buyer" value="buyer" checked>
                                    <label class="form-check-label" for="type_buyer">
                                        <i class="fas fa-shopping-cart"></i> Buyer
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="customer_type"
                                        id="type_seller" value="seller">
                                    <label class="form-check-label" for="type_seller">
                                        <i class="fas fa-store"></i> Seller
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="customer_type"
                                        id="type_witness" value="witness">
                                    <label class="form-check-label" for="type_witness">
                                        <i class="fas fa-user-friends"></i> Witness
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Personal Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="required">Full Name</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Date of Birth</label>
                                    <input type="date" name="date_of_birth" class="form-control"
                                        value="{{ old('date_of_birth') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="required">Citizenship Number</label>
                                    <input type="text" name="citizenship_number" class="form-control"
                                        value="{{ old('citizenship_number') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="required">Phone Number</label>
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ old('phone') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="required">Father's Name</label>
                                    <input type="text" name="father_name" class="form-control"
                                        value="{{ old('father_name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="required">Grandfather's Name</label>
                                    <input type="text" name="grandfather_name" class="form-control"
                                        value="{{ old('grandfather_name') }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="required">Ward No.</label>
                                    <input type="text" name="ward_no" class="form-control"
                                        value="{{ old('ward_no') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="required">Municipality Type</label>
                                    <select name="municipality_type" class="form-control" required>
                                        <option value="">Select Type</option>
                                        <option value="metropolitan_city" {{ old('municipality_type') == 'metropolitan_city' ? 'selected' : '' }}>Metropolitan City</option>
                                        <option value="sub_metropolitan_city" {{ old('municipality_type') == 'sub_metropolitan_city' ? 'selected' : '' }}>Sub-Metropolitan City</option>
                                        <option value="municipality" {{ old('municipality_type') == 'municipality' ? 'selected' : '' }}>Municipality</option>
                                        <option value="rural_municipality" {{ old('municipality_type') == 'rural_municipality' ? 'selected' : '' }}>Rural Municipality</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label>Additional Phone</label>
                                    <input type="text" name="additional_phone" class="form-control"
                                        value="{{ old('additional_phone') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="required">Address</label>
                                    <textarea name="address" class="form-control" rows="2" required>{{ old('address') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Permanent Address</label>
                                    <textarea name="permanent_address" class="form-control" rows="2">{{ old('permanent_address') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Temporary Address</label>
                                    <textarea name="temporary_address" class="form-control" rows="2">{{ old('temporary_address') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Occupation</label>
                                    <input type="text" name="occupation" class="form-control"
                                        value="{{ old('occupation') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Back
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Save Customer
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

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
</style>