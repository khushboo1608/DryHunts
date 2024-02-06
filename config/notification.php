<?php

return [
    'ios' => [
        'push_notification' => [
            'file_path'         => base_path() .'/public/notification/',
            'password'          => 'welcome',
            'bundle_id'         => 'com.app.',
            'development_url'   => 'https://api.sandbox.push.apple.com/3/device/',
            'production_url'    => 'https://api.push.apple.com/3/device/'
        ]
    ],
    'android' => [
        'push_notification' => [
            'url'           => 'https://fcm.googleapis.com/fcm/send',
            'server_key'    => env('FIREBASE_SERVER_KEY')
        ]
    ]
];
