<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up(): void
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
              $table->string('code')->unique();          //   NUMERO
            $table->string('name');                    //   NAMEINV
            $table->string('type')->default('central'); // central/branch
            $table->foreignId('parent_id')->nullable()->constrained('warehouses')->onDelete('cascade');
                    
            $table->text('location')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true);
            
             $table->integer('total_items')->default(0);
            $table->decimal('total_value', 15, 2)->default(0);
            
            $table->timestamps();
            $table->softDeletes();
            
             $table->index('code');
            $table->index('type');
            $table->index('is_active');
             
         });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
