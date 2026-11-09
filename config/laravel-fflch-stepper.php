<?php

return [ 
    'steps' => [
        'Em Análise' => [
            'icon'     => '<i class="fas fa-envelope"></i>',
            'description' => 'sua solicitação foi enviada para análise'
        ],
        'Em Produção' => [
            'icon'     => '<i class="fas fa-cogs"></i>',
            'description' => 'estamos buscando os dados do pedido'
        ],
        'Esperando Validação' => [
            'icon'     => '<i class="fas fa-clock"></i>',
            'description' => 'estamos validando os dados obtidos'
        ],
        'Finalizado' => [
            'icon'     => '<i class="fas fa-clipboard-check"></i>',
            'description' => 'sua solicitação foi finalizada',
        ],
        'Rejeitado' => [
            'icon'          => '<i class="fas fa-ban"></i>',
            'description'   => 'sua solicitação foi rejeitada',
        ]
    ]
];