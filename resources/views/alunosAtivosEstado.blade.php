@extends('main')

@section('content')

<a href="{{ config('app.url') }}/api/alunosAtivosEstado" class="export-json">
    <span data-toggle="tooltip" data-placement="left" title="Exportar em JSON" role="button">
        <img src="{{ asset('assets/img/json_icon.png') }}">
    </span>
</a>

<a class="btn-dl-excel" href="/alunosAtivosEstado/export/excel">
    <i class="fas fa-file-excel"></i> Download Excel</a>

<center>Quantidade de Alunos de Gradução, Pós Graduação, Pós Doutorado e de Cultura e Extensão da FFLCH por estado.</center>
<center>Sigla do estado onde foi expedido o documento de identificação.</center>

<div id="chart-div"></div>


<center>*Estado de São Paulo: {{$alunos_sp}} discentes</center>

{!! $lava->render('GeoChart', 'Alunos', 'chart-div') !!}


@endsection

