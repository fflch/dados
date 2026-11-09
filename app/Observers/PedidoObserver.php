<?php

namespace App\Observers;

use App\Models\Pedido;
use App\Mail\PedidoCreatedMail;
use App\Mail\PedidoUpdatedMail;
use Illuminate\Support\Facades\Mail;

class PedidoObserver
{
    /**
     * Handle the Pedido "created" event.
     */
    public function created(Pedido $pedido): void
    {
        Mail::to('destinatario@email.com')->queue(new PedidoCreatedMail($pedido));
    }

    /**
     * Handle the Pedido "updated" event.
     */
    public function updated(Pedido $pedido): void
    {
        Mail::to('destinatario@email.com')->queue(new PedidoUpdatedMail($pedido));
    }

    /**
     * Handle the Pedido "deleted" event.
     */
    public function deleted(Pedido $pedido): void
    {
        //
    }

    /**
     * Handle the Pedido "restored" event.
     */
    public function restored(Pedido $pedido): void
    {
        //
    }

    /**
     * Handle the Pedido "force deleted" event.
     */
    public function forceDeleted(Pedido $pedido): void
    {
        //
    }
}
