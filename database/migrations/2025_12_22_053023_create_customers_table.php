<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('name');
            $table->date('date_of_birth')->nullable();
            $table->string('citizenship_number')->unique();
            $table->string('father_name');
            $table->string('grandfather_name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('occupation')->nullable();
            
            // Address Information
            $table->string('ward_no');
            $table->enum('municipality_type', [
                'metropolitan_city',
                'sub_metropolitan_city',
                'municipality',
                'rural_municipality'
            ]);
            $table->string('address');
            $table->string('permanent_address')->nullable();
            $table->string('temporary_address')->nullable();
            
            // Customer Type
            $table->enum('customer_type', ['buyer', 'seller', 'witness']);
            
            // Additional Information
            $table->string('additional_phone')->nullable();
            $table->string('photo')->nullable();
            
            // Spouse Information (for buyers)
            $table->string('spouse_name')->nullable();
            $table->string('spouse_citizenship')->nullable();
            $table->string('spouse_father_name')->nullable();
            $table->string('spouse_phone')->nullable();
            $table->string('spouse_ward_no')->nullable();
            $table->enum('spouse_municipality_type', [
                'metropolitan_city',
                'sub_metropolitan_city',
                'municipality',
                'rural_municipality'
            ])->nullable();
            $table->string('spouse_address')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};