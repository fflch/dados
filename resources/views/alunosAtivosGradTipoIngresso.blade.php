@extends('main')

@section('content')

<a href="{{ config('app.url') }}/api/alunosAtivosGradTipoIngresso" class="export-json">
    <span data-toggle="tooltip" data-placement="left" title="Exportar em JSON" role="button">
        <img src="{{ asset('assets/img/json_icon.png') }}">
    </span>
</a>

<a class="btn-dl-excel"  href="/alunosAtivosGradTipoIngresso/export/excel">
    <i class="fas fa-file-excel"></i> Download Excel</a>

<center>*Foram omitidos os dados de alunos que não dispõem da informação em seu cadastro.</center>

<div id="chart-div"></div>

{!! $lava->render('ColumnChart', 'Ingresso', 'chart-div') !!}

@endsection