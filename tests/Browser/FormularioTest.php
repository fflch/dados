<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class FormularioTest extends DuskTestCase
{
    public function test_criar_e_visualizar_formulario(): void
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
 
            // Read
            $browser->pause(2000)
                    ->press('@btn-visualizar')
                    ->assertSee('Planilha de estagiarios')
                    ->assertSee('Solicita-se a disponibilidade de uma planilha com a quantidade de estagiarios por departamento');
        });
    }
}