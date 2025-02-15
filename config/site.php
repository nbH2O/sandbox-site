<?php

return [
    'file_url' => config('app.url').'/storage',
    'main_account_id' => 1,
    'currency_icon' => 'ri-vip-diamond-fill',
    'after_tax' => 0.9,
    'panel_access_min_power' => 200,
    'renderer_url' => 'http://localhost:3000/render',

    // also have to change manually in bootstrap/app.php
    'renderer_callback' => '/renderer_callback',


    // defualts in db
    'item_types' => [
        1 => 'face',
        2 => 'hat',
        3 => 'shirt',
        4 => 'pants'
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
        ]
    ]
];