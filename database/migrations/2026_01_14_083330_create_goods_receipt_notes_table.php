<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('goods_receipt_notes', function (Blueprint $table) {
            $table->id();
            $table->string('memo_number'); //foreign key in the select item$ numberofitems table         
            $table->string('order_number');       
            $table->string('folder_number');         
            $table->string('bill_number');      
            $table->date('date');                
            $table->string('financial_memo_number');
            $table->date('bill_date');         
            $table->date('order_date');   
            $table->string('deliver');   
            $table->string('description');              
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_receipt_notes');
    }
};
