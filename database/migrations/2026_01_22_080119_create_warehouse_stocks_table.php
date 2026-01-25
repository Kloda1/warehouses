<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('warehouse_stocks', function (Blueprint $table) {
            $table->id();
             $table->foreignId('item_id')->constrained('items');
            $table->foreignId('warehouse_id')->constrained('warehouses');
            
             $table->decimal('opening_balance', 15, 2)->default(0);
            $table->decimal('current_quantity', 15, 2)->default(0);
            $table->decimal('reserved_quantity', 15, 2)->default(0);
            $table->decimal('available_quantity', 15, 2)
                  ->storedAs('current_quantity - reserved_quantity');
            
             $table->decimal('minimum_quantity', 15, 2)->default(0);
            $table->decimal('maximum_quantity', 15, 2)->nullable();
            
             $table->decimal('average_cost', 15, 2)->default(0);
            $table->decimal('total_value', 15, 2)
                  ->storedAs('current_quantity * average_cost');
            
             $table->timestamp('last_received_at')->nullable();
            $table->timestamp('last_issued_at')->nullable();
            
            $table->timestamps();
            
             $table->unique(['item_id', 'warehouse_id']);
            
             $table->index('item_id');
            $table->index('warehouse_id');
            $table->index('available_quantity');
            $table->index('minimum_quantity');        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('warehouse_stocks');
    }
};
