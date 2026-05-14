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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_name');
            $table->string('generic_name')->nullable();
            $table->string('brand_name')->nullable();
            $table->foreignId('category_id')->constrained('categories', 'category_id')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->string('dosage_info')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock_quantity')->default(0);
            $table->date('expiration_date')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('barcode', 100)->unique()->nullable();
            $table->string('product_image')->nullable();
            $table->boolean('prescription_required')->default(false);
            $table->timestamp('date_added')->useCurrent();
            $table->timestamp('date_updated')->useCurrent()->useCurrentOnUpdate();
            $table->index('product_name');
            $table->index('barcode');
            $table->index('stock_quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
