@extends('main')

@section('content')
<a href="/ativosDocentesPorFuncao/export/excel">
    <i class="fas fa-file-excel"></i> Download Excel</a> 

<div id="chart-div"></div>

{!! $lava->render('PieChart', 'Docentes por função', 'chart-div') !!}
@endsection