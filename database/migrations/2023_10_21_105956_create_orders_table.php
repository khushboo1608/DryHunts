<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('order_id')->unique()->primary();
            $table->integer('user_id');
            $table->integer('rate')->default(0);
            $table->text('rate_comment')->nullable();
            $table->float('order_amount', 8, 2);
            $table->float('order_discount_amount', 8, 2);           
            $table->tinyInteger('payment_type')->default(0)->comment('1:COD, 2:onlinepament, 3:wallet');
            $table->string('payment_transection_id')->nullable();
            $table->tinyInteger('order_type')->default(1)->comment('1:pending, 2:accepted/confirmed, 3:inprogress, 4:delivered/completed, 5:cancelled');            
            $table->string('request_for')->default(0)->comment('1:quotation, 2:maintenance');
            $table->string('quotation_pdf')->nullable();
            $table->string('quotation_remark')->nullable();
            $table->string('cancel_reason')->nullable();
            $table->string('state_id')->nullable();
            $table->string('district_id')->nullable();
            $table->string('taluka_id')->nullable();
            $table->string('pincode_id')->nullable();
            $table->string('gst_number')->nullable();
            $table->string('order_status')->default(0)->comment('0: enable, 1:disable');
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
        Schema::dropIfExists('orders');
    }
}
