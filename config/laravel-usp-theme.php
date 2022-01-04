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
    'container' => 'container container-fflch',
    'skin' => env('USP_THEME_SKIN', 'uspdev'),
    'app_url' => config('app.url'),
    'logout_method' => 'POST',
    'logout_url' => config('app.url') . '/logout',
    'login_url' => config('app.url') . '/login',
    'right_menu' => $right_menu,
    'menu' => [
        [
            'text' => 'Catálogo',
            'submenu' => [
                [
                    'type' => 'header',
                    'text' => 'Dados de produção acadêmica',
                ],
                [
                    'text' => 'Programas de Pós-Graduação',
                    'url' =>  config('app.url') .'/programas',
                ],
                [
                    'text' => 'Defesas',
                    'url' =>  config('app.url').'/defesas',
                ],
                [
                    'text' => 'Pesquisa',
                    'url' =>  config('app.url').'/pesquisa?filtro=departamento',
                ],
                [
                    'type' => 'divider',
                ],
                [
                    'type' => 'header',
                    'text' => 'Dados institucionais',
                ],
                [
                    'text' => 'Colegiados',
                    'url' =>  config('app.url').'/colegiados',
                ],
                
            ],
        ],
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
            'text' => 'Api',
            'url'  => '/docs',
        ],
    ],
];
