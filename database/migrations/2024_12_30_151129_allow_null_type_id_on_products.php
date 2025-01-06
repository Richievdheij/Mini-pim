<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Drop the foreign key constraint on 'type_id'
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_type_id_foreign');
        });

        // Make the 'type_id' column nullable
        Schema::table('products', function (Blueprint $table) {
            $table->integer('type_id')->nullable()->change();
        });
    }

    public function down()
    {
        // Revert 'type_id' column to not nullable
        Schema::table('products', function (Blueprint $table) {
            $table->integer('type_id')->nullable(false)->change();
        });

        // Re-add the foreign key constraint on 'type_id'
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('type_id')->references('id')->on('product_types')->onDelete('cascade');
        });
    }
};
