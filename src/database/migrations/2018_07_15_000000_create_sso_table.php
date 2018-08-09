<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSsoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sso', function (Blueprint $table) {
            $table->increments('id');
            // $table->unsignedInteger('user_id')->index(); support specific user login in as sso
            $table->string('name')->comment('application name');
            $table->string('app_id')->unique();
            $table->string('secret');
            $table->string('remember_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sso');
    }
}
