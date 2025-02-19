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
            $table->foreignId('type_id')->nullable()->constrained('product_types'); // Tied to product type, allows NULL
            $table->foreignId('profile_id')->constrained('profiles'); // Scoped to a profile
            $table->float('weight', 8, 2)->default(0.00)->nullable(false); // Weight as float with default 0.00
            $table->float('height', 8, 2)->default(0.00)->nullable(false); // Height as float with default 0.00
            $table->float('depth', 8, 2)->default(0.00)->nullable(false); // Depth as float with default 0.00
            $table->decimal('price', 10, 2)->default(0.00)->nullable(false); // Price as decimal with default 0.00
            $table->float('width', 8, 2)->default(0.00)->nullable(false); // Width as float with default 0.00
            $table->text('description')->nullable();
            $table->integer('stock_quantity')->default(0); // Default stock quantity as 0
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}
