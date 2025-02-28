<?php

return [
    'file_url' => config('app.url').'/storage',
    'main_account_id' => 1,
    'currency_icon' => 'ri-vip-diamond-fill',
    'after_tax' => 0.9,
    'panel_access_min_power' => 200,
    'renderer_url' => env('RENDERER_URL', 'http://localhost:3000/render'),

    // also have to change manually in bootstrap/app.php
    'renderer_callback' => '/renderer_callback',

    // defualts in db
    'item_types' => [
        0 => null,

        1 => 'figure', // bundle
        2 => 'head',
        3 => 'torso',
        4 => 'arm_left',
        5 => 'arm_right',
        6 => 'leg_left',
        7 => 'leg_right',
        
        8 => 'pack', // bundle
        9 => 'face',
        10 => 'hat',
        11 => 'shirt',
        12 => 'pants',
    ],
    'private_item_types' => [
        'torso',
        'arm_left',
        'arm_right',
        'leg_left',
        'leg_right'
    ],

    'roles' => [
        [
            'id' => 1,
            'name' => 'Owner',
            'description' => null,
            'icon' => 'ri-auction-fill',
            'color' => '#fefefe',
            'power' => 255,
            'is_public' => 0
        ],
        [
            'id' => 2,
            'name' => 'Admin',
            'description' => 'Site administrator',
            'icon' => 'ri-auction-fill',
            'color' => '#E02D2D',
            'power' => 250,
            'is_public' => 1
        ],
        [
            'id' => 3,
            'name' => 'Market Designer',
            'description' => 'Design items for the market',
            'icon' => 'ri-artboard-fill',
            'color' => '#AABBCC',
            'power' => 100,
            'is_public' => 1
        ],
    ]
];