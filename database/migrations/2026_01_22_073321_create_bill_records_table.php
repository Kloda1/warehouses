<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     
    public function up(): void
    {
        Schema::create('bill_records', function (Blueprint $table) { //  DETBILSRC/DETBILCST
            $table->id();
  $table->foreignId('bill_id')->constrained('bills')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items');
            $table->foreignId('warehouse_id')->nullable()->constrained('warehouses');
            
            // الكميات
            $table->decimal('quantity', 15, 2);        // كان QUANTITE
            $table->decimal('received_quantity', 15, 2)->default(0); // للإستلام
            
            // الأسعار
            $table->decimal('unit_price', 15, 2);      // كان PRICE
            $table->decimal('total_price', 15, 2)->storedAs('quantity * unit_price');
            
            // التكلفة
            $table->decimal('cost_price', 15, 2)->nullable();
            
            // المخزون بعد الحركة
            $table->decimal('stock_before', 15, 2)->default(0);
            $table->decimal('stock_after', 15, 2)->default(0);
            
             $table->string('batch_number')->nullable(); //   NUMBITAKA
            $table->date('expiry_date')->nullable();
            $table->text('notes')->nullable();          //   REMARQUE
            
            $table->timestamps();
            
             $table->index('bill_id');
            $table->index('item_id');
            $table->index('warehouse_id');
            $table->index('batch_number');        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('bill_records');
    }
};
