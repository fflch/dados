@extends('main')



@section('content')

<div class="content-options">
    <form action="/IngressantesGradGeneroCurso" method='get'>

        <label for="curso" class="form-label">Filtrar por curso:</label>
        <select id="curso" class="form-select" name="curso">
            @foreach($cursos as $key => $cur)
                <option 
                    @if($key == request()->query("curso"))
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
    

    <a  href="/IngressantesGradGeneroCurso/export/excel?curso=Letras&ano_ini={{request()->query("ano_ini")}}&ano_fim={{request()->query("ano_fim")}}">
        <i class="fas fa-file-excel"></i> Download Excel</a> 

</div>




<center>
Série histórica dos ingressantes do curso de {{$nome_curso}} oferecido pela Faculdade de Filosofia, Letras e Ciências Humanas por gênero.
</center>


<div id="chart-div"></div>

{!! $lava->render('LineChart', 'Genero', 'chart-div') !!}

@endsection