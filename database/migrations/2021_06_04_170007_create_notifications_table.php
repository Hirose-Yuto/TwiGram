<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id("notification_id")->unique()->primary();
            $table->id("notification_to");
            $table->boolean("is_read");
            $table->id("notification_type_id");
            $table->timestamps();

            $table->foreignId("notification_type_id")->constrained("notification_types", "notification_type_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
