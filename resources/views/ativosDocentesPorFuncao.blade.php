@extends('main')


@section('content')
<a href="/ativosDocentesPorFuncao/export/excel">
    <i class="fas fa-file-excel"></i> Download Excel</a> 

<center>
    Quantidade de professores titulares, doutores e associados ativos na Faculdade de Filosofia, Letras e Ciências Humanas.
    </center>

    <div id="chart-div"></div>

    {!! $lava->render('ColumnChart', 'Ativos', 'chart-div') !!}


@endsection