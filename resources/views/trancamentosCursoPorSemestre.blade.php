@extends('main')

@section('styles')
@parent
    <link rel="stylesheet" href="{{ asset('assets/css/programas.css') }}">
@endsection


@section('content')

    <div class="content-options overflow-auto">
        <form action="/trancamentosCursoPorSemestre" method='get' class="d-inline-block">
            <label for="curso" class="form-label">Curso:</label>
          
            <select id="curso" class="form-select" name="curso" >
                @foreach($cursos as $key => $cur)
                    <option 
                        @if($key == request()->query("curso") || (request()->query("curso") == null && $key == 'Letras') )
                            selected="selected"
                        @endif    
                    value="{{$key}}">
                        {{ $cur['nome'] }}
                    </option>
                @endforeach
            </select>

             <label for="ano_ini" class="form-label"> de </label>
            <select id="ano_ini" name="ano_ini" class="form-select">
                @foreach($anos as $a)
                    <option 
                        @if($a == request()->query("ano_ini") || (request()->query("ano_ini") == null && $a == date('Y') - 10) )
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
                        @if($a == request()->query("ano_fim") || (request()->query("ano_fim") == null && $a == date('Y')) )
                            selected="selected"
                        @endif    
                    value="{{$a}}">
                        {{ $a }}
                    </option>
                @endforeach
            </select>

             <label for="periodo" class="form-label">  Período:</label>
            <select id="periodo" name="periodo" class="form-select">
                    <option @if(request()->query("periodo") == '' ) selected="selected" @endif value="">
                        Todos
                    </option>
                     <option @if(request()->query("periodo") == 'integral' ) selected="selected" @endif value="integral">
                        Integral
                    </option>
                     <option @if(request()->query("periodo") == 'matutino' ) selected="selected" @endif value="matutino">
                        Matutino
                    </option>
                     <option @if(request()->query("periodo") == 'diurno' ) selected="selected" @endif value="diurno">
                        Diurno
                    </option>
                     <option @if(request()->query("periodo") == 'vespertino' ) selected="selected" @endif value="vespertino">
                        Vespertino
                    </option>
                    <option @if(request()->query("periodo") == 'noturno' ) selected="selected" @endif value="noturno">
                        Noturno
                    </option>
            </select>

            <input type="submit" value="buscar" class="btn btn-dark bg-blue-default btn-send">

      </form>

      <a class="float-right btn-dl-excel"  href="/trancamentosCursoPorSemestre/export/excel?curso={{ request()->query("curso") == null ? 'Letras' : request()->query("curso") }}&ano_ini={{request()->query("ano_ini") == null ? date('Y') - 10 : request()->query("ano_ini") }}&ano_fim={{request()->query("ano_fim") == null ? date('Y') : request()->query("ano_fim") }}"  >
            <i class="fas fa-file-excel"></i> Download Excel
        </a>

        
    </div>

<div id="chart-div"></div>

{!! $lava->render('ColumnChart', 'Convenios', 'chart-div') !!}
@endsection

