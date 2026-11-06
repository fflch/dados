<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.criacao_pedido_mail', file_get_contents(__DIR__ . "/defaults/criacao_pedido_mail.txt"));
        $this->migrator->add('general.alteracao_pedido_mail', file_get_contents(__DIR__ . "/defaults/alteracao_pedido_mail.txt"));

    }
};
