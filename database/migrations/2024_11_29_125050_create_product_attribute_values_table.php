<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAttributeValuesTable extends Migration
{
    public function up(): void
    {
        Schema::create('product_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products'); // Product reference
            $table->foreignId('attribute_id')->constrained('attributes'); // Attribute reference
            $table->foreignId('profile_id')->constrained('profiles'); // Profile reference
            $table->string('value'); // Specific value
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_attribute_values');
    }
}
