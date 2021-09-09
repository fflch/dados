@extends('main')

@section('content')
<a href="/ativos/export/excel">
    <i class="fas fa-file-excel"></i> Download Excel</a>

<center>Quantidade de pessoas com vínculos ativos na unidade.</center>

<div id="chart-div"></div>

{!! $lava_col->render('ColumnChart', 'AtivosCOL', 'chart-div') !!}

@endsection
