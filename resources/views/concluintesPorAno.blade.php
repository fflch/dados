@extends('main')


@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/programas.css') }}">
@endsection

@section('content')
<div>
    <form action="/concluintesPorAno" method='get'>

        <label for="vinculo" class="form-label">Filtrar por:</label>
        <select id="vinculo" name="vinculo" class="form-select" onchange="location = this.value;">
            <option @if(request()->query("vinculo") == 'ALUNOGR') selected="selected" @endif value="ALUNOGR">
                Aluno de Graduação
            </option>
            <option @if(request()->query("vinculo") == 'ALUNOPOS') selected="selected" @endif value="ALUNOPOS">
                Aluno de Pós-Graduação
            </option>
        </select> 


        <label for="ano_ini" class="form-label"> de </label>
        <select id="ano_ini" name="ano_ini" class="form-select">
            @foreach($anos as $a)
                <option 
                    @if($a == request()->query("ano_ini"))
                        selected="selected"
                    @endif    
                value="{{$a}}">
                    {{ $a }}
                </option>
            @endforeach
        </select>
        
        <label for="ano_fim" class="form-label">até </label>
        <select id="ano_fim" name="ano_fim" class="form-select">
            @foreach($anos as $a)
                <option 
                    @if($a == request()->query("ano_fim"))
                        selected="selected"
                    @endif    
                value="{{$a}}">
                    {{ $a }}
                </option>
            @endforeach
        </select>

        <input type="submit" value="buscar" class="btn btn-dark bg-blue-default btn-send">
    </form>
    

<a href="/concluintesPorAno/export/excel?vinculo={{request()->query("vinculo")}}&ano_ini={{request()->query("ano_ini")}}&ano_fim={{request()->query("ano_fim")}}">
    <i class="fas fa-file-excel"></i> Download Excel</a>

</div>


<div id="chart-div"></div>

{!! $lava->render('AreaChart', 'Concluintes', 'chart-div') !!}

<center>
    <p>Série histórica de {{$nome_vinculo}} concluintes por ano na Faculdade de Filosofia, Letras e Ciências Humanas a partir de 2010.</p>
</center>
@endsection