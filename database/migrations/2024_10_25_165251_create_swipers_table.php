<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSwipersTable extends Migration
{
    public function up()
    {
        Schema::create('swipers', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('file_path', 255);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('swipers');
    }
}
