@extends('chart')


@section('content_top')

    <div>
        <label for="curso" class="form-label">Filtrar por:</label>
        <select id="curso" class="form-select" onchange="location = this.value;">
            @foreach($filtro as $key => $value)
                <option 
                    @if($key == $tipvin)
                        selected="selected"
                    @endif    
                    value="{{$value['url']}}">
                    {{ $value['nome'] }}
                </option>
            @endforeach
        </select>
    
        
        <a href="/ativosGenero/export/excel/{{$tipvin}}/{{$cod_curso}}" class="float-right">
            <i class="fas fa-file-excel"></i> Download Excel
        </a>

    </div>

@endsection



@section('content_top')

@endsection

@section('content_footer')
<center>Quantidade de {{$texto}} ativos na Faculdade de Filosofia, Letras e Ciências Humanas contabilizados por gênero.</center>
@endsection