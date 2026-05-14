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
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->id('log_id');
            $table->foreignId('product_id')->constrained('products', 'product_id')->onDelete('cascade');
            $table->integer('quantity_changed');
            $table->enum('action_type', ['added', 'sold', 'adjusted', 'returned']);
            $table->integer('previous_quantity')->nullable();
            $table->integer('new_quantity')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('date_logged')->useCurrent();
            $table->index('product_id');
            $table->index('date_logged');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_logs');
    }
};
