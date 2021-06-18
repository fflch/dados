@extends('main')

@section('content_top')
<a href="/conveniosAtivos/export/excel">
    <i class="fas fa-file-excel"></i> Download Excel</a> 
@endsection

@section('content')

<a href="/conveniosAtivos/export/excel">
    <i class="fas fa-file-excel"></i> Download Excel</a> 
    
<center>
Quantidade de convênios ativos na Faculdade de Filosofia, Letras e Ciências Humanas.
</center>


<div id="chart-div"></div>

{!! $lava->render('ColumnChart', 'Convenios', 'chart-div') !!}
@endsection