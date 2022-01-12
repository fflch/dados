@extends('main')

@section('content')

<div>
    <a class="btn-dl-excel" href="/exAlunos/export/excel/">
        <i class="fas fa-file-csv"></i> Download Excel</a> 
</div>

<div id="chart-div"></div>

{!! $lava->render('PieChart', 'Ex Alunos', 'chart-div') !!}
@endsection