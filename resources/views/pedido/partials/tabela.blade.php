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
    @if(@isset($pedidos))
        @foreach($pedidos as $pedido)
            @include('pedido.partials.campos')
        @endforeach
    @else
        @include('pedido.partials.campos')
    @endif
    </tbody>
</table>