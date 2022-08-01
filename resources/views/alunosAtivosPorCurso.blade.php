@extends('main')

@section('content')

<div class="mb-5">
    <label for="curso" class="form-label">Filtrar por:</label>
    <select id="curso" class="form-select" onchange="location = this.value;">
        
            <option 
                @if($tipvin == 'ALUNOGR')
                    selected="selected"
                @endif    
                value="/alunosAtivosPorCurso?tipvin=ALUNOGR">
                Alunos da Graduação
            </option>
            <option 
                @if($tipvin == 'ALUNOPD')
                    selected="selected"
                @endif    
                value="/alunosAtivosPorCurso?tipvin=ALUNOPD">
                Alunos Pós-doutorando
            </option>
       
    </select>

    

    <a href="{{ config('app.url') }}/api/alunosAtivosPorCurso?tipvin={{request()->tipvin ?? 'ALUNOGR'}}" class="export-json">
        <span data-toggle="tooltip" data-placement="left" title="Exportar em JSON" role="button">
            <img src="{{ asset('assets/img/json_icon.png') }}">
        </span>
    </a>
    <a href="/alunosAtivosPorCurso/export/excel?tipvin={{request()->tipvin ?? 'ALUNOGR'}}" class="ml-5 btn-dl-excel">
        <i class="fas fa-file-excel"></i> Download Excel</a> 


</div>

<center>{{$texto}}</center>


<div id="chart-div"></div>

{!! $lava->render('ColumnChart', 'Ativos por curso', 'chart-div') !!}
@endsection
