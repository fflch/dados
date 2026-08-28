<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class VisualizarPedidosTest extends DuskTestCase
{
    public function test_visualizar_meus_pedidos(): void
    {
        $this->browse(function (Browser $browser) {
 
            // Login
            $browser->visit('/')
                    ->clickLink('Entrar')
                    ->waitFor('#loginUsuario')
                    ->typeSlowly('#loginUsuario', '10025')
                    ->press('Login')
                    ->waitForText('Sair')
                    ->assertSee('Sair');
 
            // Create
            $browser->visit('/pedidos/create')
                    ->pause(2000)
                    ->typeSlowly('assunto', 'Planilha de estagiarios')
                    ->typeSlowly('descricao', 'Solicita-se a disponibilidade de uma planilha com a quantidade de estagiarios por departamento', 5)
                    ->press('Enviar')
                    ->waitForText('Planilha de estagiarios', 10)
                    ->assertSee('Planilha de estagiarios');
 
            // Navegar em Pedidos (dropdown) > Meus Pedidos
            $browser->pause(2000)
                    ->clickLink('Pedidos')
                    ->pause(1000)
                    ->waitForLink('Meus Pedidos', 5)
                    ->clickLink('Meus Pedidos')
                    ->pause(2000)
                    ->assertSee('Planilha de estagiarios');
        });
    }
}