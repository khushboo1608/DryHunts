<?php

return [
    'file_path' => [
        // 'admin_user_profile' => 'storage/media/profile/',
        'admin_user_profile'    => 'images/admin/user_profile',
        'user_profile'       => 'images/app/user_profile',
        'service_image' => 'images/app/service_image',
        'category_image' => 'images/app/category_image',
        'sub_category_image' => 'images/app/sub_category_image',
        'app_logo' => 'images/app/app_logo',
        'app_upi_image'=> 'images/app/app_upi_image',
        'order_quotation' => 'images/app/order_quotation',
        'testimonial_image' => 'images/app/testimonial_image',
        'banner_image'  => 'images/app/banner_image',
        'gallary_image'  => 'images/app/gallary_image',
    ],
    'no_image' => [
        'no_user'   => env('APP_URL').'public/images/noimage/user-not-found.png',
        'no_image'  => env('APP_URL').'public/images/noimage/image-not-found.jpg'
    ],
    'static_image' => [
        'web_logo'      => env('APP_URL').'public/images/logo/logo.png',
        'admin_logo'      => env('APP_URL').'public/images/180.png',
        'favicon'   => env('APP_URL').'public/images/favicon/favicon-16x16.png',
        'logo'              => env('APP_URL').'public/storage/media/profile/Logo.png',
    ],
    'null_object'   => new \stdClass(),
    'null_array'    => [],
    'current_time_zone' => 'Asia/Kolkata'
];
