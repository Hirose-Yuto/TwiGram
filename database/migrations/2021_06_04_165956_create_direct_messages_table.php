<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_messages', function (Blueprint $table) {
            $table->id("direct_message_id")->unique()->primary();
            $table->id("sent_from");
            $table->id("sent_to");
            $table->string("message", 840);
            $table->timestamp("read_at")->nullable();
            $table->timestamps();

            $table->foreignId("sent_from")->constrained("users", "user_id");
            $table->foreignId("sent_to")->constrained("users", "user_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('direct_messages');
    }
}
