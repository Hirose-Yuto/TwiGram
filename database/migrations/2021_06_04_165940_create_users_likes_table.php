<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_likes', function (Blueprint $table) {
            $table->id("like_id")->unique()->primary();
            $table->id("user_id");
            $table->id("twig_id");
            $table->timestamps();

            $table->foreignId("user_id")->constrained("users", "user_id");
            $table->foreignId("twig_id")->constrained("twigs", "twig_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_likes');
    }
}
