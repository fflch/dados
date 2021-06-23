@extends('main')

@section('content')
<a href="/ativosPorProgramaPos/export/excel">
    <i class="fas fa-file-excel"></i> Download Excel</a> 


<center>Quantidade de alunos ativos da Pós Graduação contabilizados por departamento.</center>

<div id="chart-div"></div>
{!! $lava->render('ColumnChart', 'Ativos', 'chart-div') !!}


@endsection