@extends('pedidos')

@section('content')
<div class="row d-flex flex-column align-items-center">
    <h1>Editar solicitação</h1>

    {!! $stepper !!}
    
    <form action="pedidos/{{ $pedido->id }}" method="post" class="w-50" name="status">
        @csrf
        @method('patch')
        @switch($pedido->status)
            @case('Em Análise')
                <button type="submit" name="status" value="Em Produção" dusk="btn-update" class="btn btn-secondary" onclick="return confirm('Você tem certeza?')">Enviar para Produção</button>
                @break
            @case('Em Produção')
                <button type="submit" name="status" value="Esperando Validação" dusk="btn-update" class="btn btn-info" onclick="return confirm('Você tem certeza?')">Enviar para Validação</button>
                @break
            @case('Esperando Validação')
                <button type="submit" name="status" value="Finalizado" dusk="btn-update-f" class="btn btn-success" onclick="return confirm('Você tem certeza?')">Finalizar</button>
                <button type="submit" name="status" value="Em Produção"dusk="btn-update-p" class="btn btn-secondary" onclick="return confirm('Você tem certeza?')">Encaminhar para Produção</button>
                <button type="submit" name="status" value="Rejeitado"  dusk="btn-update-r" class="btn btn-danger" onclick="return confirm('Você tem certeza?')">Rejeitar</button>
                @break
            @case('Rejeitado')
                <button type="submit" name="status" value="Em Produção" dusk="btn-update" class="btn btn-secondary" onclick="return confirm('Você tem certeza?')">Reabrir para produção</button>
                @break  
        @endswitch
        <br><br>
        @include('pedido.partials.form')
        
    </form>
</div>

@endsection('content')