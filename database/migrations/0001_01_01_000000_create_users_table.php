<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullname', 50);
            $table->string('email', 50)->unique();
            $table->string('password', 255);
            $table->string('default_shipping_address')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('reset_password_token', 255)->unique()->nullable();
            $table->bigInteger('reset_password_expire')->nullable();
            $table->enum('role', ['SUPERADMIN', 'ADMIN', 'MODERATOR', 'CUSTOMER'])->default('CUSTOMER');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
