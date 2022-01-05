@extends('main')



@section('content')


<div class="content-options">
    <label for="ano" class="form-label">Ano:</label>
    <select id="ano" class="form-select" onchange="location = this.value;">
        @foreach($anos as $a)
            <option 
                @if($a == $ano)
                    selected="selected"
                @endif    
            value="/beneficiosAtivosGraduacaoPorAno/{{$a}}">
                {{ $a }}
            </option>
        @endforeach
    </select>
   
   
    <a  href="/beneficiosAtivosGraduacaoPorAno/export/excel/{{$ano}}" class="float-right">
        <i class="fas fa-file-excel"></i> Download Excel</a>
    <br>
</div>




<center>
    <p>Total de alunos de Graduação com benefícios (ativos) em {{$ano}} na Faculdade de Filosofia, Letras e Ciências Humanas.</p>
</center>

<div id="chart-div"></div>
{!! $lava->render('ColumnChart', 'Beneficios', 'chart-div') !!}

<p>* Essa lista poderá ser estendida, caso sejam cadastrados alunos em outros benefícios.</p>

@endsection
