<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('settings');
        Schema::create('settings', function (Blueprint $table) {
            $table->string('setting_id')->unique()->primary();
            $table->string('email_from')->nullable();
            $table->string('firebase_server_key')->nullable();
            $table->string('onesignal_app_id')->nullable();
            $table->string('onesignal_rest_key')->nullable();
            $table->string('app_name')->nullable();
            $table->string('app_logo')->nullable();
            $table->string('app_email')->nullable();
            $table->string('app_author')->nullable();
            $table->string('app_contact')->nullable();
            $table->string('app_website')->nullable();
            $table->text('app_description')->nullable();
            $table->text('app_developed_by')->nullable();
            $table->text('app_privacy_policy')->nullable();
            $table->text('app_terms_condition')->nullable();
            $table->text('app_cancellation_refund')->nullable();
            $table->text('app_about_us')->nullable();
            $table->text('app_contact_us')->nullable();
            $table->string('agent_onboard_commission')->nullable();
            $table->string('agent_approve_commission')->nullable();
            $table->string('add_min_wallet_amount')->nullable();
            $table->string('contribution')->nullable();
            $table->string('radius')->nullable();
            $table->string('reffer_earn_amount')->nullable();
            $table->string('app_version')->nullable();
            $table->string('app_update_status')->nullable();      
            $table->tinyInteger('app_maintenance_status')->default(0)->comment('1: yes, 2:no');
            $table->text('app_maintenance_description')->nullable();
            $table->text('app_update_description')->nullable();
            $table->tinyInteger('app_update_cancel_button')->default(0)->comment('1: yes, 2:no');
            $table->tinyInteger('app_update_factor_button')->default(0)->comment('1: yes, 2:no');
            $table->string('factor_apikey')->nullable();
            $table->string('app_address')->nullable();
            $table->string('app_gstin')->nullable();
            $table->string('app_pan')->nullable();
            $table->string('app_bank_name')->nullable();
            $table->string('app_acount_no')->nullable();
            $table->string('app_ifsc')->nullable();
            $table->string('app_branch')->nullable();
            $table->string('app_upi_image')->nullable();
            $table->text('app_notes_desc')->nullable();
            $table->string('map_api_key')->nullable();
            $table->string('razorpay_key')->nullable();
            $table->string('cash_on_delivery_available')->nullable();
            $table->string('gst_charge')->nullable();
            $table->string('app_facebook')->nullable();
            $table->string('app_youtube')->nullable();
            $table->string('app_twitter')->nullable();
            $table->string('app_instagram')->nullable();
            $table->string('app_whatsapp')->nullable();
            $table->string('app_linkedin')->nullable();
            $table->tinyInteger('is_disable')->default(0)->comment('0: enable, 1:disable');
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
        Schema::dropIfExists('settings');
    }
}
