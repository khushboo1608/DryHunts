<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    public $table = "settings";
    protected $primaryKey = 'setting_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'setting_id',
        'email_from',
        'firebase_server_key',
        'onesignal_app_id',
        'onesignal_rest_key',
        'app_name',
        'app_logo',
        'app_email',
        'app_author',
        'app_contact',
        'app_website',
        'app_description',
        'app_developed_by',
        'app_privacy_policy',
        'app_terms_condition',
        'app_cancellation_refund',
        'app_about_us',
        'app_contact_us',
        'agent_onboard_commission',
        'agent_approve_commission',
        'add_min_wallet_amount',
        'contribution',
        'radius',
        'reffer_earn_amount',
        'app_version',
        'app_update_status',
        'app_maintenance_status',
        'app_maintenance_description',
        'app_update_description',
        'app_update_cancel_button',
        'app_update_factor_button',
        'factor_apikey',
        'app_address',
        'app_gstin',
        'app_pan',
        'app_bank_name',
        'app_acount_no',
        'app_ifsc',
        'app_branch',
        'app_upi_image',
        'app_notes_desc',
        'map_api_key',
        'razorpay_key',
        'cash_on_delivery_available',
        'gst_charge',
        'app_facebook',
        'app_youtube',
        'app_twitter',
        'app_instagram',
        'app_whatsapp',
        'app_linkedin',
    ];
}
