@extends('pedidos')

@section('content')
<div class="row d-flex flex-column align-items-center">
    <h1>Editar solicitação</h1>
    <form action="pedidos/{{ $pedido->id }}" method="post" class="w-50" name="status">
        @csrf
        @method('patch')
        @include('pedido.partials.form')
        <button type="submit" name="status" value="Rejeitado" class="btn btn-danger">Rejeitar</button>
        <button type="submit" name="status" value="Aprovado"  class="btn btn-success">Aprovar</button>
    </form>
</div>

@endsection('content')