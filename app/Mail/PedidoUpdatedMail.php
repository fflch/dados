<?php

namespace App\Mail;

use app\Models\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Settings\GeneralSettings;

class PedidoUpdatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private Pedido $pedido;
    private GeneralSettings $settings;

    /**
     * Create a new message instance.
     */
    public function __construct(Pedido $pedido)
    {
        $this->pedido   = $pedido;
        $this->settings = app(GeneralSettings::class);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Portal de Dados | Solicitação Alterada: ' . $this->pedido->status . ' | ' . $this->pedido->assunto,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.pedidos.update',
            with: [
                'pedido'   => $this->pedido,
                'settings' => $this->settings
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
