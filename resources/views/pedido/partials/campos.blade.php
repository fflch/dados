<tr>
    <td>
        @foreach(@config('laravel-fflch-stepper.steps') as $step => $detalhes)
            @if($step == $pedido->status)
                {!! $detalhes['icon'] !!}
            @endif
        @endforeach
    </td>

    <td class="text-break">{{ $pedido->assunto }}</td>

    <td class="text-break">{{ $pedido->descricao }}</td>
    
    @can('admin')
    <td><a href="pedidos/{{ $pedido->id }}/edit" dusk="btn-editar"><button class="btn btn-info"><i class="fas fa-pen"></i></button></a></td>
    
    <td>
        <form action="pedidos/{{ $pedido->id }}" method="post">
            @csrf
            @method('delete')
            <button class="btn btn-danger" dusk="btn-apagar" type="submit" onclick="return confirm('Você tem certeza que quer apagar essa solicitação?')"><i class="fas fa-trash"></i></button>
        </form>
    </td>
    
    @endcan
    
    <td><a href="pedidos/{{ $pedido->id }}" dusk="btn-visualizar"><button class="btn btn-primary"><i class="fas fa-eye"></i></button></a></td>
</tr>