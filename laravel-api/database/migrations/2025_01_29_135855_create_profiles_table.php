<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    public function up()
{
    Schema::dropIfExists('profiles');
    Schema::create('profiles', function (Blueprint $table) {
        $table->id();
        $table->string('firstName');
        $table->string('lastName');
        $table->string('image')->nullable();
        $table->string('status')->default('en_attente');
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
