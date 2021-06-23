@extends('main')

@section('content')
<a href="/ativosMicrosNotes/export/excel">
    <i class="fas fa-file-excel"></i> Download Excel</a> 

<div id="chart-div"></div>

{!! $lava->render('ColumnChart', 'MicroNotes', 'chart-div') !!}

@endsection