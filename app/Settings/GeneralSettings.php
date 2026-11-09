<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{   
    public string $criacao_pedido_mail;
    public string $alteracao_pedido_mail;

    public static function group(): string
    {
        return 'general';
    }
}