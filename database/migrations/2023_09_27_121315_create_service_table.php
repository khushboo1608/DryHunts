<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service', function (Blueprint $table) {
            $table->string('service_id')->unique()->primary();
            $table->string('category_id');
            $table->string('service_name');
            $table->text('service_description')->nullable();
            $table->string('service_single_image')->nullable();
            $table->string('service_multiple_image')->nullable();
            $table->string('service_sku');            
            $table->string('service_price');   
            $table->tinyInteger('is_popular')->default('0');       
            $table->tinyInteger('service_status')->default('0');
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
        Schema::dropIfExists('service');
    }
}
