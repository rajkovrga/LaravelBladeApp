<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table)
        {
           $table->bigIncrements('id');
           $table->string('username',160)->unique();
           $table->string('email')->unique();
           $table->rememberToken();
           $table->timestamp('email_verified_at')->nullable();
           $table->string('password');
           $table->string('image_url',255)->nullable();
           $table->timestamps();
           $table->boolean('active')->default(true);
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
