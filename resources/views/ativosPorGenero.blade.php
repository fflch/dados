@extends('main')



@section('content')

<div class="content-options">
    <label for="curso" class="form-label">Filtrar por:</label>
    <select id="curso" class="form-select" onchange="location = this.value;">
        @foreach($listaVinculos as $key => $value)
            <option 
                @if($value['vinculo'] == $vinculo && $value['codcur'] == $codcur)
                    selected="selected"
                @endif
                value="{{ 'ativosPorGenero?vinculo='.$value['vinculo'].(isset($value['codcur']) ? '&curso='.$value['codcur'] : '') }}">
                {{ $key }}
            </option>
        @endforeach
    </select>

    
    <a href="{{ config('app.url') }}/api/ativosPorGenero?vinculo={{ request()->vinculo ?? 'ALUNOGR' }}&curso={{ request()->curso ?? '' }}" class="export-json">
        <span data-toggle="tooltip" data-placement="left" title="Exportar em JSON" role="button">
            <img src="{{ asset('assets/img/json_icon.png') }}">
        </span>
    </a>
    <a href="/alunosAtivosPorCurso/export/excel?vinculo={{ request()->vinculo ?? 'ALUNOGR' }}&curso={{ request()->curso ?? '' }}" class="ml-5 btn-dl-excel">
        <i class="fas fa-file-excel"></i> Download Excel</a> 

</div>


<div id="chart-div"></div>

{!! $lava->render('ColumnChart', 'Genero', 'chart-div') !!}

<center>Quantidade de {{ $vinculoExt }} ativos na Faculdade de Filosofia, Letras e Ciências Humanas contabilizados por gênero.</center>



@endsection

