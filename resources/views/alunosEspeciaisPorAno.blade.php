@extends('chart')

@section('content_top')

<div>
    <label for="vinculo" class="form-label">Filtrar por:</label>
    <select id="vinculo" class="form-select" onchange="location = this.value;">
        <option @if($vinculo == 0) selected="selected" @endif value="/alunosEspeciaisPorAno/ALUNOESPGR">
            Aluno Especial de Graduação
        </option>
        <option @if($vinculo == 1) selected="selected" @endif value="/alunosEspeciaisPorAno/ALUNOPOSESP">
            Aluno Especial de Pós-Graduação
        </option>
    </select> 

<a href="/alunosEspeciaisPorAno/export/excel/{{$vinculo}}">
    <i class="fas fa-file-excel"></i> Download Excel</a>

</div>
@endsection

@section('content_footer')
<center>{{$nome_vinculo}} no período de 2010-2020.</center>
@endsection
