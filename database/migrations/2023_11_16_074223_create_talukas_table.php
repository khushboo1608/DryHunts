<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTalukasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talukas', function (Blueprint $table) {
            $table->string('taluka_id')->unique()->primary();
            $table->string('district_id');
            $table->string('state_id');
            $table->string('taluka_name');
            $table->tinyInteger('taluka_status')->default('0');
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
        Schema::dropIfExists('talukas');
    }
}
