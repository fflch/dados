<tr>
    <td>
        <div class="md-step-circle">
            @if($pedido->status == 'Finalizado')
                <i class="fas fa-check"></i>
            @else
                <i class="fas fa-envelope"></i>
            @endif
        </div>
    </td>

    <td class="text-break">{{ $pedido->assunto }}</td>

    <td class="text-break">{{ $pedido->descricao }}</td>
    
    @can('admin')
    <td><a href="pedidos/{{ $pedido->id }}/edit"><button class="btn btn-info"><i class="fas fa-pen"></i></button></a></td>
    
    <td>
        <form action="pedidos/{{ $pedido->id }}" method="post">
            @csrf
            @method('delete')
            <button class="btn btn-danger" type="submit" onclick="return confirm('Você tem certeza que quer apagar essa solicitação?')"><i class="fas fa-trash"></i></button>
        </form>
    </td>
    
    @endcan
    
    <td><a href="pedidos/{{ $pedido->id }}"><button class="btn btn-primary"><i class="fas fa-eye"></i></button></a></td>
</tr>