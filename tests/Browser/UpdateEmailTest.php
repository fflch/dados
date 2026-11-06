<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Mail\PedidoUpdatedMail;

class UpdateEmailTest extends DuskTestCase
{
    protected function setUp(): void
    {
        // Limpa as mensagens do Mailpit antes de cada teste
        parent::setUp();
        Http::delete('http://mailpit:8025/api/v1/messages');
    }

    public function test_update_email(): void
    {
        Mail::fake();
        $this->browse(function (Browser $browser) {

            // Login
            $browser->visit('/')
                    ->clickLink('Entrar')
                    ->waitFor('#loginUsuario')
                    ->typeSlowly('#loginUsuario', '1111')
                    ->press('Login')
                    ->waitForText('Sair');
            
            // Create
            $browser->visit('/pedidos/create')
                    ->typeSlowly('assunto', 'Planilha de estagiarios')
                    ->typeSlowly('descricao', 'Solicita-se a disponibilidade de uma planilha com a quantidade de estagiarios por departamento', 5)
                    ->press('Enviar')
                    ->pause(1000);

            // Se está em análise, vai para produção
            $browser->press('@btn-editar')
                    ->assertSee('Enviar para Produção')
                    ->press('@btn-update')
                    ->acceptDialog()
                    ->pause(500);

            // Verifica se o e-mail foi enviado
            $response = Http::get('http://mailpit:8025/api/v1/messages');
            $messages = $response->json('messages');
            $latestMail = $messages[0];

            //valida assunto
            $this->assertStringContainsString('Portal de Dados | Solicitação Alterada:', $latestMail['Subject']);

            //Valida destinatario
            $this->assertEquals('destinatario@email.com', $latestMail['To'][0]['Address']);
        });
        
    }
}