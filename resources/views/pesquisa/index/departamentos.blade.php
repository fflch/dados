@foreach ($departamentos as $key=>$item)
    <tr>
    <td>
        {{ $item['nome_departamento'] }}
    </td>
    <td class="text-center">
        @if($item['ic_com_bolsa'] > 0)
            <a href="/iniciacao_cientifica?departamento={{$key}}&bolsa=true">
            {{$item['ic_com_bolsa']}}
            </a>
        @else
            0
        @endif
    </td>
    <td class="text-center">
        @if($item['ic_sem_bolsa'] > 0)
        <a href="/iniciacao_cientifica?departamento={{$key}}&bolsa=false">
            {{$item['ic_sem_bolsa']}}
        </a>
        @else
        0
        @endif
    </td>
    <td class="text-center">
        @if($item['pesquisas_pos_doutorado_com_bolsa'] > 0)
        <a href="/pesquisa_pos_doutorandos?departamento={{$key}}&bolsa=true">
            {{$item['pesquisas_pos_doutorado_com_bolsa']}}
        </a>
        @else
        0
        @endif
    </td>
    <td class="text-center">
        @if($item['pesquisas_pos_doutorado_sem_bolsa'] > 0)
        <a href="/pesquisa_pos_doutorandos?departamento={{$key}}&bolsa=false">
            {{$item['pesquisas_pos_doutorado_sem_bolsa']}}
        </a>
        @else
        0
    @endif
    </td>
    <td class="text-center">
        
        @if($item['pesquisadores_colab'] > 0)
        <a href="/pesquisadores_colaboradores?departamento={{$key}}">
            {{$item['pesquisadores_colab']}}
        </a>
        @else
        0
        @endif
    </td>
    <td class="text-center">
        
        @if($item['projetos_pesquisa'] > 0)
        <a href="/projetos_pesquisa?departamento={{$key}}">
            {{$item['projetos_pesquisa']}}
        </a>
        @else
        0
        @endif
    </td>
    
    </tr>
@endforeach