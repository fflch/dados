@extends('chart')

@section('content_top')
<a href="/ativos/export/excel">
    <i class="fas fa-file-excel"></i> Download Excel</a>
@endsection

@section('content_footer')
<center>Quantidade de pessoas com vínculos ativos na unidade.</center>

Teste Teste Teste Teste Teste Teste Teste

<div id="chart-div"></div>

{!! $lava->render('PieChart', 'IMDB', 'chart-div') !!}

@endsection
