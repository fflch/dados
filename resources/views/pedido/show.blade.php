@extends('pedidos')

@section('content')
<table class="table table-striped">
    <thead>
        <tr>
            <th>Aussunto</th>
            <th>Descrição</th>
            <th>Editar</th>
            <th>Apagar</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $pedido->assunto }}</td>
            <td>{{ $pedido->descricao }}</td>
            <td><a href="pedidos/{{ $pedido->id }}/edit">Editar</a></td>
            <td>
                <form action="pedidos/{{ $pedido->id }}" method="post">
                    @csrf
                    @method('delete')
                    <button class="btn btn-danger" type="submit" onclick="return confirm('Você tem certeza que quer apagar essa solicitação?')">Apagar</button>
                </form>
            </td>
        </tr>
    </tbody>
</table>
@endsection('content')