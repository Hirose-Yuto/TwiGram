<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowFollowedRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow_followed_relationships', function (Blueprint $table) {
            $table->id("following_user_id")->primary();
            $table->id("followed_user_id")->primary();
            $table->timestamps();

            $table->foreignId("following_user_id")->constrained("users", "user_id");
            $table->foreignId("followed_user_id")->constrained("users", "user_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follow_followed_relationships');
    }
}
