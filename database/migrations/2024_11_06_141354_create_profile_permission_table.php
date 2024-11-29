<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilePermissionTable extends Migration
{
    public function up()
    {
        Schema::create('profile_permission', function (Blueprint $table) {
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->primary(['profile_id', 'permission_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('profile_permission');
    }
}
