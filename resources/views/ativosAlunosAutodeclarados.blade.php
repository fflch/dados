@extends('main')

@section('content')

<div>
    <label for="vinculo" class="form-label">Filtrar por:</label>
    <select id="vinculo" class="form-select" onchange="location = this.value;">
        <option @if($vinculo == 'ALUNOGR') selected="selected" @endif value="/ativosAlunosAutodeclarados/ALUNOGR">
            Aluno de Graduação
        </option>
        <option @if($vinculo == 'ALUNOPOS') selected="selected" @endif value="/ativosAlunosAutodeclarados/ALUNOPOS">
            Aluno de Pós-Graduação
        </option>
        <option @if($vinculo == 'ALUNOCEU') selected="selected" @endif value="/ativosAlunosAutodeclarados/ALUNOCEU">
            Aluno de Cultura e Extensão
        </option>
        <option @if($vinculo == 'ALUNOPD') selected="selected" @endif value="/ativosAlunosAutodeclarados/ALUNOPD">
            Aluno de Pós-Doutorado
        </option>

    </select> 

<a href="/ativosAlunosAutodeclarados/export/excel/{{$vinculo}}">
    <i class="fas fa-file-excel"></i> Download Excel</a>
<center>Totais de {{$nome_vinculo}} da Faculdade de Filosofia, Letras e Ciências Humanas - FFLCH autodeclarados.</center>

</div>

<center><b>Obs:</b> Foram omitidos os dados de alunos que não dispõem da informação em seu cadastro.</center>

<div id="chart-div"></div>

{!! $lava->render('ColumnChart', 'AtivosCOL', 'chart-div') !!}
@endsection