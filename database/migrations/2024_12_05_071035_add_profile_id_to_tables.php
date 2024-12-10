<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->foreignId('profile_id')->nullable()->constrained('profiles')->onDelete('cascade');
        });

        Schema::table('product_types', function (Blueprint $table) {
            $table->foreignId('profile_id')->nullable()->constrained('profiles')->onDelete('cascade');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('profile_id')->nullable()->constrained('profiles')->onDelete('cascade');
        });

        Schema::table('attribute_values', function (Blueprint $table) {
            $table->foreignId('profile_id')->nullable()->constrained('profiles')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->dropForeign(['profile_id']);
            $table->dropColumn('profile_id');
        });

        Schema::table('product_types', function (Blueprint $table) {
            $table->dropForeign(['profile_id']);
            $table->dropColumn('profile_id');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['profile_id']);
            $table->dropColumn('profile_id');
        });

        Schema::table('attribute_values', function (Blueprint $table) {
            $table->dropForeign(['profile_id']);
            $table->dropColumn('profile_id');
        });
    }
};
