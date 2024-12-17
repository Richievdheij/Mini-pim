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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('height', 8, 2)->nullable(true);
            $table->decimal('width', 8, 2)->nullable(true);
            $table->decimal('depth', 8, 2)->nullable(true);
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['height', 'width', 'depth']);
        });
    }
};
