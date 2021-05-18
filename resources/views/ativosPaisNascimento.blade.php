@extends('chart')

@section('content_top')

<div>
    <label for="vinculo" class="form-label">Filtrar por:</label>
    <select id="vinculo" class="form-select" onchange="location = this.value;">
        <option @if($tipo_vinculo == 0) selected="selected" @endif value="/ativosPaisNascimento/0">
            Alunos de Cultura e Extensão
        </option>
        <option @if($tipo_vinculo == 1) selected="selected" @endif value="/ativosPaisNascimento/1">
            Alunos de Pós-Graduação
        </option>
        <option @if($tipo_vinculo == 2) selected="selected" @endif value="/ativosPaisNascimento/2">
            Alunos de Graduação 
        </option>
        <option @if($tipo_vinculo == 3) selected="selected" @endif value="/ativosPaisNascimento/3">
            Alunos de Pós-Doutorado 
        </option>
        <option @if($tipo_vinculo == 4) selected="selected" @endif value="/ativosPaisNascimento/4">
            Docentes
        </option>

    </select> 

<a href="/ativosPaisNascimento/export/excel/{{$tipo_vinculo}}">
    <i class="fas fa-file-csv"></i> Download Excel</a> 

</div>
@endsection

@section('content_footer')
<center>Distribuição de "{{$nome_vinculo}}" que contabiliza nascidos e não nascidos no Brasil.</center>
<center>Foram consideradas informações de nascimento, e não de nacionalidade. </center>
@endsection
