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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('email')->nullable()->after('name');
            $table->string('tax_number')->nullable();
            $table->string('commercial_register')->nullable();
            $table->decimal('balance', 15, 2)->default(0);
            $table->integer('total_sales')->nullable();
            $table->integer('total_orders')->nullable();
            $table->string('notes')->nullable()->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            //
        });
    }
};
