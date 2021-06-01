<?php

$right_menu = [
    [
        'text'   => '<i class="fas fa-cog"></i>',
        'title'  => 'logs',
        'target' => '_blank',
        'url'    => config('app.url') . '/logs',
        'align'  => 'right',
        'can'    => 'admins',
    ],
];

return [
    'title' => config('app.name'),
    'skin' => env('USP_THEME_SKIN', 'uspdev'),
    'app_url' => config('app.url'),
    'logout_method' => 'POST',
    'logout_url' => config('app.url') . '/logout',
    'login_url' => config('app.url') . '/login',
    'right_menu' => $right_menu,
    'menu' => [
        [
            'text' => 'Início',
            'url'  => '/',
        ],
        [
            'text' => 'Sobre',
            'url'  => '/sobre',
        ],
        [
            'text' => 'Restrito',
            'url'  => '/restrito',
            'can'  => 'admins'
        ],
    ],
];
