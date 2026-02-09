<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('name');
            $table->string('vehicle_number')->nullable();
            $table->enum('vehicle_type', ['bike', 'car', 'scooter', 'other']);
            $table->integer('cc');
            $table->integer('mileage')->nullable();
            $table->year('manufacture_year');
            $table->enum('condition', ['new', 'used', 'excellent', 'good', 'fair']);
            $table->string('color')->nullable();
            
            // Identification Numbers
            $table->string('engine_number')->unique();
            $table->string('chassis_number')->unique();
            
            // Pricing
            $table->decimal('purchase_price', 12, 2);
            $table->decimal('selling_price', 12, 2)->nullable();
            
            // Registration Details
            $table->string('registered_name');
            $table->string('transferred_by');
            $table->date('purchase_date');
            
            // Technical Details
            $table->string('fuel_type')->nullable();
            $table->string('transmission')->nullable();
            $table->integer('owner_count')->default(1);
            
            // Documentation
            $table->date('insurance_valid_until')->nullable();
            $table->date('tax_paid_until')->nullable();
            $table->string('bluebook_copy')->nullable();
            $table->string('insurance_copy')->nullable();
            
            // Status and Images
            $table->enum('status', ['available', 'sold', 'under_maintenance', 'reserved'])->default('available');
            $table->json('images')->nullable();
            $table->text('description')->nullable();
            $table->text('remarks')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};