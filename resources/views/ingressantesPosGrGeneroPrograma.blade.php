@extends('main')



@section('content')

<div>
    <form action="/IngressantesPosGrGeneroPrograma" method='get'>

        <label for="codare" class="form-label">Filtrar por programa:</label>
        <select id="codare" class="form-select" name="codare">
            @foreach($programas as $key => $programa)
                <option 
                    @if($key == request()->query("codare"))
                        selected="selected"
                    @endif    
                value="{{$key}}">
                    {{ $programa }}
                </option>
            @endforeach
        </select>

        <label for="nivpgm" class="form-label">Nível:</label>
        <select id="nivpgm" class="form-select" name="nivpgm">
            
                <option @if(null == request()->query("nivpgm")) selected="selected" @endif value="">
                    Selecione
                </option>
                <option @if('ME' == request()->query("nivpgm")) selected="selected" @endif value="ME">
                    Mestrado
                </option>
                <option @if('DO' == request()->query("nivpgm")) selected="selected" @endif value="DO">
                    Doutorado
                </option>
                <option @if("" == request()->query("nivpgm")) selected="selected" @endif value="">
                    Ambos
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
    

    <a href="/IngressantesPosGrGeneroPrograma/export/excel?codare={{request()->query("codare")}}&ano_ini={{request()->query("ano_ini")}}&ano_fim={{request()->query("ano_fim")}}&nivpgm={{request()->query("nivpgm")}}">
        <i class="fas fa-file-excel"></i> Download Excel</a> 

</div>




<center>
Série histórica dos ingressantes do programa de {{$nomare}} {{$nivpgm}} na Faculdade de Filosofia, Letras e Ciências Humanas por gênero.
</center>


<div id="chart-div"></div>

{!! $lava->render('LineChart', 'Genero', 'chart-div') !!}

@endsection