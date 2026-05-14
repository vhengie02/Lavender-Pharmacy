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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_method', 50);
            $table->enum('order_status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->timestamp('date_ordered')->useCurrent();
            $table->index('user_id');
            $table->index('date_ordered');
            $table->index('order_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
