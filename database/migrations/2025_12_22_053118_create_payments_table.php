<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transfer_id')->constrained('vehicle_transfers')->onDelete('cascade');
            
            // Amount Details
            $table->decimal('total_price', 12, 2);
            $table->decimal('amount_paid', 12, 2)->default(0);
            $table->decimal('amount_received', 12, 2)->default(0);
            
            // Payment Method
            $table->enum('payment_method', ['cash', 'cheque', 'bank_transfer', 'online', 'other'])->default('cash');
            $table->enum('payment_type', ['full', 'advance', 'installment', 'balance'])->default('full');
            
            // Payment Details
            $table->string('transaction_id')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('cheque_number')->nullable();
            $table->date('cheque_date')->nullable();
            $table->string('online_transaction_id')->nullable();
            
            // Status
            $table->enum('payment_status', ['paid', 'partial', 'pending', 'failed'])->default('pending');
            
            // Additional Info
            $table->text('payment_notes')->nullable();
            $table->date('payment_date');
            $table->foreignId('received_by')->constrained('users')->onDelete('cascade');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};