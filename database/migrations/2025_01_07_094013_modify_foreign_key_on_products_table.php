<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyForeignKeyOnProductsTable extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['type_id']);

            // Set the foreign key to null when the referenced row is deleted
            $table->foreign('type_id')->references('id')->on('product_types')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['type_id']);

            // Set the foreign key to cascade when the referenced row is deleted
            $table->foreign('type_id')->references('id')->on('product_types')->onDelete('cascade');
        });
    }
}
