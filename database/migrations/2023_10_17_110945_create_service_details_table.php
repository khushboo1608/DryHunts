<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_details', function (Blueprint $table) {
            $table->string('service_detail_id')->unique()->primary();
            $table->string('service_id');
            $table->float('service_original_price', 8, 2);
            $table->float('service_discount_price', 8, 2);
            $table->string('service_unit')->default('0');
            $table->integer('service_quantity')->default('0');
            $table->tinyInteger('service_detail_status')->default(0)->comment('0: enable, 1:disable');
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
        Schema::dropIfExists('service_details');
    }
}
