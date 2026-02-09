<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vehicle_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_number')->unique();
            
            // Foreign Keys
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->foreignId('buyer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('witness_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->foreignId('buyer_spouse_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            
            // Transfer Details
            $table->text('notes')->nullable();
            $table->boolean('expenses_borne_by_buyer')->default(true);
            $table->date('transfer_date');
            
            // Expenses
            $table->decimal('registration_fee', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('commission', 10, 2)->default(0);
            $table->decimal('other_expenses', 10, 2)->default(0);
            $table->decimal('total_expenses', 10, 2)->default(0);
            
            // Handover Status
            $table->boolean('bluebook_received')->default(false);
            $table->boolean('insurance_transferred')->default(false);
            $table->boolean('key_handover')->default(false);
            $table->boolean('documents_handover')->default(false);
            
            // Status
            $table->enum('status', ['pending', 'completed', 'cancelled', 'in_progress'])->default('pending');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicle_transfers');
    }
};