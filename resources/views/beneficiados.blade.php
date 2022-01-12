@extends('main')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/programas.css') }}">
@endsection

@section('content')

<div class="content-options">
    <form action="/beneficiados" method='get'>

        <label for="ano_ini" class="form-label">Filtrar de </label>
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

<a  href="/beneficiados/export/excel?ano_ini={{request()->query("ano_ini")}}&ano_fim={{request()->query("ano_fim")}}">
    <i class="fas fa-file-excel"></i> Download Excel</a>

</div>

<div id="chart-div"></div>

{!! $lava->render('AreaChart', 'Beneficiados', 'chart-div') !!}

@endsection
