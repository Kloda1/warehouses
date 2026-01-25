<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();          //   PRTNO
            $table->string('name');                    //   PRTNAME
            $table->text('description')->nullable();   //   DESCRIPTION
            $table->foreignId('category_id')->nullable()->constrained('categories');
            
             $table->string('unit');                    //   WIHDA
            
             $table->decimal('purchase_price', 15, 2)->nullable(); //   MYPRICE
            $table->decimal('sale_price', 15, 2)->nullable();     //   PRICE3
            $table->decimal('wholesale_price', 15, 2)->nullable();
            
             $table->decimal('minimum_quantity', 15, 2)->default(0); //   MINQUANTITE
            $table->decimal('opening_balance', 15, 2)->default(0);  //   QUANTITEFRSTPERIODE
            $table->decimal('current_quantity', 15, 2)->default(0); //   QUANTITEONHAND
            $table->decimal('reserved_quantity', 15, 2)->default(0); //   QUANTITEMOUNA
            
             $table->string('barcode')->nullable()->unique(); //   BARCODE
            
             $table->boolean('is_active')->default(true);
            
             $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('last_updated_by')->nullable()->constrained('users');
            
            $table->timestamps();
            $table->softDeletes();
            
             $table->index('code');
            $table->index('name');
            $table->index('barcode');
            $table->index('category_id');
            $table->index('is_active');
        });
    }

 
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
