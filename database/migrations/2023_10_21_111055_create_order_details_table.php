<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->string('order_detail_id')->unique()->primary();
            $table->string('order_id');
            $table->string('service_id');
            $table->string('service_detail_id');
            $table->float('order_original_price', 8, 2);
            $table->float('order_discount_price', 8, 2);            
            $table->string('order_unit');
            $table->integer('order_quantity');
            $table->tinyInteger('order_details_status')->default(0)->comment('0: enable, 1:disable');
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
        Schema::dropIfExists('order_details');
    }
}
