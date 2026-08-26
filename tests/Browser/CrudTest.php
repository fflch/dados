<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CrudTest extends DuskTestCase
{
    public function test_crud(): void
    {
        $this->browse(function (Browser $browser) {
            
            // Login
            $browser->visit('/')
                    ->clickLink('Entrar')
                    ->waitFor('#loginUsuario')
                    ->typeSlowly('#loginUsuario', '111111')
                    ->press('Login');

            // Create
            $browser->visit('/pedidos/create')
                     ->pause(2000)
                    ->typeSlowly('assunto', 'Planilha de estagiarios')
                    ->typeSlowly('descricao', 'Solicita-se a disponibilidade de uma planilha com a quantidade de estagiarios por departamento', 5)
                    ->press('Enviar')    
                    ->visit('pedidos') 
                    ->waitForText('Planilha de estagiaros')
                    ->assertSee('Planilha de estagiarios');

            //Read
            $browser->pause(2000)
                    ->press('@btn-visualizar')
                    ->assertSee('Planilha de estagiarios')
                    ->assertSee('Solicita-se a disponibilidade de uma planilha com a quantidade de estagiarios por departamento');

            //Upload
            $browser->press('@btn-editar')
                    ->typeSlowly('assunto', 'Planilha de estagiarios - Revisado')
                    ->typeSlowly('descricao', 'Nova descricao') 
                    ->press('Enviar')
                    ->assertSee('Planilha de estagiarios - Revisado')
                    ->assertSee('Nova descricao');

            //Delete
            $browser->pause(2000)
                    ->press('@btn-apagar')
                    ->acceptDialog()
                    ->assertDontSee('Planilha de estagiarios - Revisado');
        });
    }
}