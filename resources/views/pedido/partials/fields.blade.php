<div>
    <ul>
        <li>Pedido feito por: {{ $pedido->user->name ?? ''}}</li>
        <li>Assunto: {{ $pedido->assunto }}</li>
        <li>Descrição: {{ $pedido->descricao }}</li>
        <a href="pedidos/{{ $pedido->id }}/edit">Editar Solicitação</a>
            <form action="pedidos/{{ $pedido->id }}" method="post">
                @csrf
                @method('delete')
                <button class="btn btn-danger" type="submit" onclick="return confirm('Você tem certeza que quer apagar essa solicitação?')">Apagar</button>
            </form>
    </ul>
</div>