@extends('main')

@section('content')
<div class="content-options">
    <label for="vinculo" class="form-label">Filtrar por:</label>
    <select id="vinculo" class="form-select" onchange="location = this.value;">
        <option @if($vinculo == 'ALUNOCEU') selected="selected" @endif value="/ativosPaisNascimento?vinculo=ALUNOCEU">
            Alunos de Cultura e Extensão
        </option>
        <option @if($vinculo == 'ALUNOPOS') selected="selected" @endif value="/ativosPaisNascimento?vinculo=ALUNOPOS">
            Alunos de Pós-Graduação
        </option>
        <option @if($vinculo == 'ALUNOGR') selected="selected" @endif value="/ativosPaisNascimento?vinculo=ALUNOGR">
            Alunos de Graduação 
        </option>
        <option @if($vinculo == 'ALUNOPD') selected="selected" @endif value="/ativosPaisNascimento?vinculo=ALUNOPD">
            Alunos de Pós-Doutorado 
        </option>
        <option @if($vinculo == 'DOCENTE') selected="selected" @endif value="/ativosPaisNascimento?vinculo=DOCENTE">
            Docentes
        </option>

    </select> 

<a  href="/ativosPaisNascimento/export/excel/{{$vinculo}}">

<a href="{{ config('app.url') }}/api/ativosPaisNascimento?vinculo={{request()->vinculo ?? 'ALUNOGR'}}" class="export-json">
    <span data-toggle="tooltip" data-placement="left" title="Exportar em JSON" role="button">
        <img src="{{ asset('assets/img/json_icon.png') }}">
    </span>
</a>
    <a href="/ativosPaisNascimento/export/excel?vinculo={{request()->vinculo ?? 'ALUNOGR'}}" class="ml-5 btn-dl-excel">
    <i class="fas fa-file-csv"></i> Download Excel</a> 

</div>


<div id="chart-div"></div>

{!! $lava->render('ColumnChart', 'Ativos', 'chart-div') !!}

<center>Distribuição de "{{$nome_vinculo}}" que contabiliza nascidos e não nascidos no Brasil.</center>
<center>Foram consideradas informações de nascimento, e não de nacionalidade. </center>
@endsection
