@extends('layouts.app')

@section('title', 'Edit Vehicle')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="fas fa-edit"></i> Edit Vehicle: {{ $vehicle->name }}
                    </h4>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('vehicles.update', $vehicle) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Form content same as create.blade.php, but with value="{{ $vehicle->field_name }}" -->
                        <!-- Example for one field: -->
                        <div class="form-group mb-3">
                            <label class="required">Vehicle Name</label>
                            <input type="text" name="name" class="form-control" 
                                   value="{{ old('name', $vehicle->name) }}" required>
                        </div>
                        
                        <!-- Add all other fields similarly -->
                        
                        <!-- Form Actions -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Update Vehicle
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