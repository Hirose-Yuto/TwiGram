<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTwigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* Schema::create('users_twigs', function (Blueprint $table) {
            $table->id("ownership_id");
            $table->foreignId("user_id")->constrained("users", "user_id");
            $table->foreignId("twig_id")->constrained("twigs", "twig_id");
            $table->boolean("is_retwig");
            $table->string("retwig_comment", 840);
            $table->timestamps();
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_twigs');
    }
}
