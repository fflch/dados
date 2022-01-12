@extends('main')

@section('content')

<div class="content-options">
    <form action="/alunosEspeciaisPorAno" method='get'>

        <label for="vinculo" class="form-label">Filtrar por:</label>
        <select id="vinculo" name="vinculo" class="form-select" >
            <option @if(request()->query("vinculo") == 'ALUNOESPGR') selected="selected" @endif value="ALUNOESPGR">
                Aluno Especial de Graduação
            </option>
            <option @if(request()->query("vinculo") == 'ALUNOPOSESP') selected="selected" @endif value="ALUNOPOSESP">
                Aluno Especial de Pós-Graduação
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
    


    <a href="/alunosEspeciaisPorAno/export/excel?vinculo={{request()->query("vinculo")}}&ano_ini={{request()->query("ano_ini")}}&ano_fim={{request()->query("ano_fim")}}">
        <i class="fas fa-file-excel"></i> Download Excel</a>

</div>



<div id="chart-div"></div>

{!! $lava->render('AreaChart', 'Alunos', 'chart-div') !!}

<center>{{$nome_vinculo}} no período de 2010-2020.</center>
@endsection
