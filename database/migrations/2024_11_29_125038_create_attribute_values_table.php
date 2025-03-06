<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Run it with: php artisan migrate --path=database/migrations/name_of_file.php
class CreateAttributeValuesTable extends Migration
{
    public function up(): void
    {
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_id')->constrained('attributes'); // Tied to an attribute
            $table->foreignId('profile_id')->constrained('profiles'); // Scoped to a profile
            $table->string('value'); // Value for the attribute (e.g., Red)
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('attribute_values');
    }
}
