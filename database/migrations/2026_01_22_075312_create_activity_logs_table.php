<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\InventoryLogType;


return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
             $table->foreignId('item_id')->constrained('items');
            $table->foreignId('warehouse_id')->nullable()->constrained('warehouses');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('bill_id')->nullable()->constrained('bills');
            $table->string('type')->default(InventoryLogType::ADJUSTMENT->value);

            // $table->string('type'); // purchase/sale/transfer/adjustment/return/opening
            $table->string('reference_type')->nullable(); // bill/transfer/adjustment
            $table->string('reference_number')->nullable();
            
            $table->decimal('quantity_in', 15, 2)->default(0);
            $table->decimal('quantity_out', 15, 2)->default(0);
            $table->decimal('quantity_before', 15, 2)->default(0);
            $table->decimal('quantity_after', 15, 2)->default(0);
            
            $table->decimal('unit_price', 15, 2)->nullable();
            $table->decimal('total_value', 15, 2)->nullable();
            
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();  
            
            $table->timestamps();
            
 
            $table->index('item_id');
            $table->index('warehouse_id');
            $table->index('user_id');
            $table->index('type');
            $table->index('created_at');        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
