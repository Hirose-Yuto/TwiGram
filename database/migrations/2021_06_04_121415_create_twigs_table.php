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
            $table->id("twig_id")->unique()->primary();
            $table->timestamps();
            $table->string("program", 1024);
            $table->string("program_result", 512);
            $table->id("program_language_id");
            $table->integer("num_of_likes");
            $table->integer("num_of_retwigs");
            $table->integer("num_of_retwigs_with_comment");
            $table->id("twig_from");
            $table->id("reply_for")->nullable();

            $table->foreignId("program_language_id")->constrained("program_languages", "program_language_id");
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
