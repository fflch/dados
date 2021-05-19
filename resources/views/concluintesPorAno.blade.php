@extends('chart')

@section('content_top')
<div>
    <label for="vinculo" class="form-label">Filtrar por:</label>
    <select id="vinculo" class="form-select" onchange="location = this.value;">
        <option @if($vinculo == 'ALUNOGR') selected="selected" @endif value="/concluintesPorAno/ALUNOGR">
            Aluno de Graduação
        </option>
        <option @if($vinculo == 'ALUNOPOS') selected="selected" @endif value="/concluintesPorAno/ALUNOPOS">
            Aluno de Pós-Graduação
        </option>
    </select> 

<a href="/concluintesPorAno/export/excel/{{$vinculo}}">
    <i class="fas fa-file-excel"></i> Download Excel</a>

</div>
@endsection

@section('content_footer')
<center>
    <p>Série histórica de {{$nome_vinculo}} concluintes por ano na Faculdade de Filosofia, Letras e Ciências Humanas a partir de 2010.</p>
</center>
@endsection