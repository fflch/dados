@extends('pedidos')

@section('content')
<a href="pedidos/create"><button class="btn btn-primary">Criar nova solicitação</button></a>
@forelse($pedidos as $pedido)

@include('pedido.partials.fields')
@empty
<div>
    <p>SEM PEDIDOS REGISTRADOS</p>    
</div>


@endforelse
@endsection('content')