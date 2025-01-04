<?php

return [
    'file_url' => config('app.url').'/storage',
    'main_account_id' => 1,
    'panel_access_min_power' => 200,
    'renderer_url' => 'http://localhost:3000/render',

    // also have to change manually in bootstrap/app.php
    'renderer_callback' => '/renderer_callback'
];