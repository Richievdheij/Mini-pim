<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributesTable extends Migration
{
    public function up(): void
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Attribute name (e.g., Color)
            $table->foreignId('type_id')->constrained('product_types'); // Tied to product type
            $table->foreignId('profile_id')->constrained('profiles'); // Scoped to a profile
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
}
