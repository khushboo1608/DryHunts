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
            $table->string('notifications_id')->unique()->primary();
            $table->integer('notification_click')->default(0)->comment('0: not click, 1:click');
            $table->integer('notification_type')->default(0)->comment('1:user');
            $table->integer('no_type')->default(0)->comment('order status');
            $table->integer('user_id')->default(0);
            $table->integer('order_id')->default(0);
            $table->string('notification_title')->nullable();
            $table->string('notification_msg')->nullable();
            $table->string('notification_image')->nullable();
            $table->string('notification_status')->default(0)->comment('0: enable, 1:disable');
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
        Schema::dropIfExists('notifications');
    }
}
