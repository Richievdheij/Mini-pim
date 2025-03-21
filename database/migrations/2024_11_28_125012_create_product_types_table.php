<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Run it with: php artisan migrate --path=database/migrations/name_of_file.php
class CreateProductTypesTable extends Migration
{
    public function up(): void
    {
        Schema::create('product_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Product type name (e.g., Shoes)
            $table->foreignId('profile_id')->constrained('profiles'); // Scoped to a profile
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('product_types');
    }
}
