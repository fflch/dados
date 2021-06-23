@extends('main')

@section('content')

<a href="/ativosAlunosGradTipoIngresso/export/excel">
    <i class="fas fa-file-excel"></i> Download Excel</a>

<center>* Foram omitidos os dados de alunos que não dispõem da informação em seu cadastro.</center>

<div id="chart-div"></div>

{!! $lava->render('ColumnChart', 'Ingresso', 'chart-div') !!}

@endsection