@extends('main')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/programas.css') }}">
@endsection('styles')


@section('content')

<div>
    <a href="/ativosBeneficiosConHist/export/excel" class="float-right">
        <i class="fas fa-file-excel"></i> Download Excel</a>
    
    <br>
    <form action="/ativosBeneficiosConHist" method='get'>
        <label for="ano_ini" class="form-label">Período:  de </label>
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
   
  

</div>




<div id="chart-div"></div>


{!! $lava->render('AreaChart', 'Beneficios', 'chart-div') !!}


<center>
    <p>Série histórica de benefícios concedidos por ano na Faculdade de Filosofia, Letras e Ciências Humanas a partir de 2014.</p>
    <p>obs.: A consulta considera o número de benefícios concedidos, e não o número de alunos beneficiados.</p>
</center>

@endsection
