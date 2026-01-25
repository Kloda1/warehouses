<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();          //   UNIT
            $table->string('name');                    //   ACCNAME
            $table->string('type')->nullable();        //   ACCTYPE
            $table->string('contact_person')->nullable(); //   CONTACTNAME
            $table->string('phone')->nullable();       //   TEL
            $table->text('address')->nullable();       //   ADDRESS
            
             $table->foreignId('primary_warehouse_id')->nullable()->constrained('warehouses'); // كان NUMINV1
            $table->foreignId('secondary_warehouse_id')->nullable()->constrained('warehouses'); // كان NUMINV2
            
             $table->decimal('credit_limit', 15, 2)->default(0);
            $table->decimal('current_balance', 15, 2)->default(0);
            $table->decimal('total_purchases', 15, 2)->default(0);
            
             $table->date('start_date')->nullable();    //   BEGINDATE
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('code');
            $table->index('name');
            $table->index('type');
            $table->index('is_active');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
