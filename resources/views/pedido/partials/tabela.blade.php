<table class="table table-striped">
    <thead>
        <tr>
            <th>Status</th>
            <th>Autor</th>
            <th>Assunto</th>
            <th>Descrição</th>
        @can('admin')
            <th class="text-center w-1">Editar</th>
            <th class="text-center w-1">Apagar</th>
        @endcan
            <th class="text-center w-1">Visualizar</th>
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