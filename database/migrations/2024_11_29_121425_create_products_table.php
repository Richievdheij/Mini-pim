<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Run it with: php artisan migrate --path=database/migrations/name_of_file.php
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
            $table->float('weight', 8, 2)->nullable(); // Weight as float with NULL allowed
            $table->float('height', 8, 2)->nullable(); // Height as float with NULL allowed
            $table->float('depth', 8, 2)->nullable(); // Depth as float with NULL allowed
            $table->decimal('price', 10, 2)->nullable(); // Price as decimal with NULL allowed
            $table->float('width', 8, 2)->nullable(); // Width as float with NULL allowed
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

