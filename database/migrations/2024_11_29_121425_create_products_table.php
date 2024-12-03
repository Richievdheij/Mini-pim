<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_id')->unique();
            $table->string('name');
            $table->foreignId('type_id')->constrained('product_types'); // Product type relation
            $table->decimal('weight', 8, 2)->nullable(); // Weight in kg or g
            $table->text('description')->nullable(); // Product description
            $table->decimal('price', 10, 2); // Price of the product
            $table->integer('stock_quantity')->default(0); // Quantity in stock
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}
