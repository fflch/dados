@extends('pedidos')

@section('content')
<div class="row d-flex flex-column align-items-center">
    <h1>Editar solicitação</h1>
    <form action="pedidos/{{ $pedido->id }}" method="post" class="w-50">
        @csrf
        @method('patch')
        @include('pedido.partials.form')
    </form>
</div>

@endsection('content')