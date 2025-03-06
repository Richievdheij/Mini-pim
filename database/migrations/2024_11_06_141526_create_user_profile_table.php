<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// Run it with: php artisan migrate --path=database/migrations/name_of_file.php
class CreateUserProfileTable extends Migration
{
    public function up()
    {
        Schema::create('user_profile', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->primary(['user_id', 'profile_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_profile');
    }
}
