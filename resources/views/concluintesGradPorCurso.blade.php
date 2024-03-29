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
            value="/concluintesGradPorCurso/{{$a}}">
                {{ $a }}
            </option>
        @endforeach
    </select>
   
    <a  href="/concluintesGradPorCurso/export/excel/{{$ano}}" class="float-right" >
        <i class="fas fa-file-excel"></i> Download Excel
    </a>
</div>


<div id="chart-div"></div>

{!! $lava->render('ColumnChart', 'Concluintes', 'chart-div') !!}


<center>
    <p>Total de concluintes da Graduação por curso na Faculdade de Filosofia, Letras e Ciências Humanas em {{$ano}}.</p>
</center>
@endsection