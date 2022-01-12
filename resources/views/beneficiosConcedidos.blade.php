@extends('main')

@section('content')

<div class="content-options">
    <label for="ano" class="form-label">Filtrar por ano:</label>
        <select id="ano" class="form-select" onchange="location = this.value;">
            @foreach($anos as $a)
                <option 
                    @if($a == $ano)
                        selected="selected"
                    @endif    
                value="/beneficiosConcedidos/{{$a}}">
                    {{ $a }}
                </option>
            @endforeach
        </select>

<a href="/beneficiosConcedidos/export/excel/{{$ano}}">
    <i class="fas fa-file-excel"></i> Download Excel</a>

</div>

<div id="chart-div"></div>

{!! $lava->render('PieChart', 'Benefícios Concedidos', 'chart-div') !!}

@endsection