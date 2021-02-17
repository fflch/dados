<?php

return [
    'title' => config('app.name'),
    'skin' => env('USP_THEME_SKIN', 'uspdev'),
    'app_url' => config('app.url'),
    'logout_method' => 'POST',
    'logout_url' => config('app.url') . '/logout',
    'login_url' => config('app.url') . '/login',
    'menu' => [
        [
            'text' => 'Início',
            'url'  => '/',
        ],
        [
            'text' => 'Sobre',
            'url'  => '/sobre',
        ],
    ],
    'right_menu' => [],
];
