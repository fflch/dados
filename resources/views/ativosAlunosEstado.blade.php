@extends('main')

@section('content')
<a href="/ativosAlunosEstado/export/excel">
    <i class="fas fa-file-excel"></i> Download Excel</a>
<center>Quantidade de Alunos de Gradução, Pós Graduação, Pós Doutorado e de Cultura e Extensão da FFLCH por estado.</center>
<center>Sigla do estado onde foi expedido o documento de identificação.</center>

<div id="pop-div"></div>

{!! $lava->render('GeoChart', 'Popularity', 'pop-div') !!}
@endsection

