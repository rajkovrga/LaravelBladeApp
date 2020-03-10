<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Posts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts',function(Blueprint $table)
        {
           $table->bigIncrements('id');
           $table->string('title')->index();
           $table->string('desc')->index();
           $table->unsignedBigInteger('user_id')->nullable();
           $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('posts');
    }
}
