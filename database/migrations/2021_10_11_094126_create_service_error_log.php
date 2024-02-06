<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceErrorLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_error_log', function (Blueprint $table) {
            $table->increments('service_log_id');
            $table->string('service_name');
            $table->integer('user_id')->default(0);
            $table->text('message');
            $table->text('requested_field');
            $table->text('response_data');
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
        Schema::dropIfExists('service_error_log');
    }
}
