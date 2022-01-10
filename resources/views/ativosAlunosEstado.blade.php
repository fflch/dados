@extends('main')

@section('content')
<a class="btn-dl-excel" href="/ativosAlunosEstado/export/excel">
    <i class="fas fa-file-excel"></i> Download Excel</a>

<center>Quantidade de Alunos de Gradução, Pós Graduação, Pós Doutorado e de Cultura e Extensão da FFLCH por estado.</center>
<center>Sigla do estado onde foi expedido o documento de identificação.</center>

<div id="chart-div"></div>


<center><br> *Estado de São Paulo: {{$alunos_sp}} discentes</center>

{!! $lava->render('GeoChart', 'Alunos', 'chart-div') !!}



@endsection

