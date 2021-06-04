<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTwigsOwnershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_twigs_ownerships', function (Blueprint $table) {
            $table->id("user_id")->primary();
            $table->id("twig_id")->primary();
            $table->boolean("is_retwig");
            $table->string("retwig_comment", 840);
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
        Schema::dropIfExists('users_twigs_ownerships');
    }
}
