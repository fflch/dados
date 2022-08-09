@extends('main')

@section('content')

<div class="content-options">
    <label for="vinculo" class="form-label">Filtrar por:</label>
    <select id="vinculo" class="form-select" onchange="location = this.value;">
        <option @if($vinculo == 'ALUNOGR') selected="selected" @endif value="/alunosAtivosAutodeclarados?vinculo=ALUNOGR">
            Aluno de Graduação
        </option>
        <option @if($vinculo == 'ALUNOPOS') selected="selected" @endif value="/alunosAtivosAutodeclarados?vinculo=ALUNOPOS">
            Aluno de Pós-Graduação
        </option>
        <option @if($vinculo == 'ALUNOCEU') selected="selected" @endif value="/alunosAtivosAutodeclarados?vinculo=ALUNOCEU">
            Aluno de Cultura e Extensão
        </option>
        <option @if($vinculo == 'ALUNOPD') selected="selected" @endif value="/alunosAtivosAutodeclarados?vinculo=ALUNOPD">
            Aluno de Pós-Doutorado
        </option>

    </select> 

<a  href="/alunosAtivosAutodeclarados/export/excel/{{$vinculo}}">

<a href="{{ config('app.url') }}/api/alunosAtivosAutodeclarados?vinculo={{request()->vinculo ?? 'ALUNOGR'}}" class="export-json">
    <span data-toggle="tooltip" data-placement="left" title="Exportar em JSON" role="button">
        <img src="{{ asset('assets/img/json_icon.png') }}">
    </span>
</a>
    <a href="/alunosAtivosAutodeclarados/export/excel?vinculo={{request()->vinculo ?? 'ALUNOGR'}}" class="ml-5 btn-dl-excel">
    <i class="fas fa-file-excel"></i> Download Excel</a>
<center>Totais de {{$nome_vinculo}} da Faculdade de Filosofia, Letras e Ciências Humanas - FFLCH autodeclarados.</center>

</div>

<center><b>Obs:</b> Foram omitidos os dados de alunos que não dispõem da informação em seu cadastro.</center>

<div id="chart-div"></div>

{!! $lava->render('ColumnChart', 'AtivosCOL', 'chart-div') !!}
@endsection