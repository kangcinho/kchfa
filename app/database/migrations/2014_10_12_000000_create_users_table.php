<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('userID')->primary();
            $table->string('username')->unique();
            $table->string('name');
            $table->string('password');
            $table->boolean('isAdmin')->default(0);
            $table->boolean('isMaster')->default(0);
            $table->boolean('isFA')->default(0);
            $table->boolean('isCreate')->default(0);
            $table->boolean('isUpdate')->default(0);
            $table->boolean('isDelete')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
