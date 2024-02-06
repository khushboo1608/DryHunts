<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('login_type')->default(1)->comment('1:Admin,2:User,3:DistrictAdmin,4:TalukaAdmin');            
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique();
            $table->tinyInteger('is_verified')->default('0');
            $table->string('otp')->nullable();
            $table->integer('wallet')->default(0);
            $table->string('password')->nullable();
            $table->string('imageurl')->nullable(); 
            $table->string('state_id');
            $table->string('district_id');
            $table->string('taluka_id');
            $table->string('pincode_id');
            $table->string('gst_number')->nullable();
            $table->string('firebase_uid')->nullable();   
            $table->tinyInteger('is_disable')->default(0)->comment('0: enable, 1:disable');                   
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
