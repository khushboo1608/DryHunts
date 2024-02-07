<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->string('cart_id')->unique()->primary();
            $table->integer('user_id');
            $table->string('category_id');
            $table->string('sub_categories_id');
            $table->string('service_id');
            $table->string('service_detail_id');
            $table->string('cart_service_unit');            
            $table->integer('cart_service_quantity')->default(0);
            $table->float('cart_service_original_price', 8, 2);
            $table->float('cart_service_discount_price', 8, 2);
            $table->tinyInteger('cart_status')->default(0)->comment('0: enable, 1:disable');
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
        Schema::dropIfExists('carts');
    }
}
