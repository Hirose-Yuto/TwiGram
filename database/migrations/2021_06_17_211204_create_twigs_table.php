<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('twigs', function (Blueprint $table) {
            $table->id("twig_id");
            $table->timestamps();
            $table->string("program", 3000);
            $table->string("program_result", 840);
            $table->foreignId("program_language_id")->constrained("program_languages", "program_language_id");
            $table->integer("execution_time");
            $table->integer("num_of_likes");
            $table->integer("num_of_retwigs");
            $table->integer("num_of_retwigs_with_comment");
            $table->foreignId("twig_from")->constrained("users", "user_id");
            $table->foreignId("reply_for")->constrained("twigs", "twig_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('twigs');
    }
}
