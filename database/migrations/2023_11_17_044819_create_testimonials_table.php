<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestimonialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('testimonials', function (Blueprint $table) {
            $table->string('testimonial_id')->unique()->primary();
            $table->string('testimonial_title');
            $table->string('testimonial_image');
            $table->text('testimonial_description');
            $table->string('pincode_id');
            $table->string('taluka_id');
            $table->string('district_id');
            $table->string('state_id');
            $table->string('category_id');
            $table->string('service_id');
            $table->tinyInteger('testimonial_status')->default('0');
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
        Schema::dropIfExists('testimonials');
    }
}
