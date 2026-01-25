<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();          //   NUMERO
            $table->string('name');                    //   ACCNAME
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();       //   TEL
            $table->string('email')->nullable();
            $table->text('address')->nullable();       //   ADDRESS
            
             $table->string('tax_number')->nullable();
            $table->string('commercial_register')->nullable();
            $table->decimal('total_purchases', 15, 2)->default(0);
            $table->decimal('balance', 15, 2)->default(0);
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('code');
            $table->index('name');
            $table->index('is_active');
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
