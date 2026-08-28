<table class="table table-striped">
    <thead>
        <tr>
            <th>Status</th>
            <th>Assunto</th>
            <th>Descrição</th>
        @can('admin')
            <th>Editar</th>
            <th>Apagar</th>
        @endcan
            <th>Visualizar</th>
        </tr>
    </thead>
    <tbody>
        @isset($pedidos)
            @foreach($pedidos as $pedido)
                @include('pedido.partials.campos')
            @endforeach
        @else
            @include('pedido.partials.campos')
        @endisset
    </tbody>
</table>