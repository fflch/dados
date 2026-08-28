<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    public function test_login(): void
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
        });
    }
}
