<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\TransferStatus;


return new class extends Migration
{
 
    public function up(): void
    {
        Schema::create('stock_transfers', function (Blueprint $table) {
            $table->id();
  $table->string('transfer_number')->unique();
            $table->date('transfer_date');
            
             $table->foreignId('from_warehouse_id')->constrained('warehouses');
            $table->foreignId('to_warehouse_id')->constrained('warehouses');
            
            //  $table->string('status')->default('pending'); // pending/in_transit/completed/cancelled
            $table->string('status')->default(TransferStatus::PENDING->value);

             $table->foreignId('requested_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->foreignId('received_by')->nullable()->constrained('users');
            
             $table->timestamp('approved_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('received_at')->nullable();
            
             $table->text('notes')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('transfer_number');
            $table->index('transfer_date');
            $table->index('status');
            $table->index(['from_warehouse_id', 'to_warehouse_id']);        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('stock_transfers');
    }
};
