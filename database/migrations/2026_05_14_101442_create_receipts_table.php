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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id('receipt_id');
            $table->foreignId('order_id')->unique()->constrained('orders', 'order_id')->onDelete('cascade');
            $table->string('invoice_number', 20)->unique();
            $table->decimal('vat_amount', 10, 2);
            $table->decimal('vat_exempt_sales', 10, 2)->default(0);
            $table->decimal('zero_rated_sales', 10, 2)->default(0);
            $table->decimal('cash_tendered', 10, 2)->nullable();
            $table->decimal('change_amount', 10, 2)->nullable();
            $table->timestamp('date_created')->useCurrent();
            $table->index('invoice_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
