@extends('pedidos')

@section('content')
<table class="table table-striped">
    <thead>
        <tr>
            <th>Aussunto</th>
            <th>Descrição</th>
        </tr>
    </thead>
    <tbody>
    @foreach($pedidos as $pedido)
        <tr>
            <td>{{ $pedido->assunto }}</td>
            <td>{{ $pedido->descricao }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection('content')