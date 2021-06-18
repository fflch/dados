@extends('main')

@section('content')
<a href="/alunosEspeciaisPosGrDpto/export/excel">
<i class="fas fa-file-excel"></i> Download Excel</a>

<div id="chart-div"></div>

{!! $lava->render('PieChart', 'IMDB', 'chart-div') !!}
@endsection
