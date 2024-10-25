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
    [
            'key' => 'senhaunica-socialite',
    ],
];

return [
    'title' => config('app.name'),
    'container' => 'container container-fflch',
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
            'text' => 'Contato',
            'url'  => '/contato',
        ],
        [
            'text' => 'Restrito',
            'url'  => '/restrito',
            'can'  => 'admins'
        ],
        [
            'text' => 'Documentação API',
            'url'  => '/docs',
        ],
        [
            'text' => 'Departamentos',
            'url' => '/departamentos',
        ]
    ],
];
