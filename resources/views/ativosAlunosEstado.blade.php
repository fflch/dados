@extends('main')

@section('content')
<a href="/ativosAlunosEstado/export/excel">
    <i class="fas fa-file-excel"></i> Download Excel</a>

<div id="pop-div"></div>

{!! $lava->render('PieChart', 'Estados', 'pop-div') !!}
@endsection

