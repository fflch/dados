@extends('main')

@section('content')
<a href="/ativosPosNivelPgm/export/excel">
    <i class="fas fa-file-excel"></i> Download Excel</a> 


<center>Quantidade de alunos ativos da Pós Graduação na Faculdade de Filosofia, Letras e Ciências Humanas separados pelo nível do Programa.</center>

<div id="chart-div"></div>

{!! $lava->render('ColumnChart', 'Ativos Pós-Graduação', 'chart-div') !!}
@endsection