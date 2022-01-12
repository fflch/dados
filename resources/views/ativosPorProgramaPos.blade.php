@extends('main')

@section('content')
<div class="content-options">
    <a class="btn-dl-excel" href="/ativosPorProgramaPos/export/excel">
        <i class="fas fa-file-excel"></i> Download Excel</a> 
</div>


<center>Quantidade de alunos ativos da Pós Graduação contabilizados por departamento.</center>

<div id="chart-div"></div>
{!! $lava->render('ColumnChart', 'Ativos', 'chart-div') !!}


@endsection