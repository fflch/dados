@extends('main')


@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/programas.css') }}">
@endsection('styles')


@section('content')

<form id="formSearchPesquisa" method="index" action="/pesquisa" class="d-flex mb-3">
  <div class="filtro-select-div">
    <label for="filtro">Filtrar por:</label>
    <select name="filtro" id="filtro" class="mr-2">
      <option value="">Selecione</option>
      <option value="departamento" {{ $filtro == 'departamento' ? 'selected=selected' : ''}}>Departamentos</option>
      <option value="curso" {{ $filtro == 'curso' ? 'selected=selected' : ''}}>Cursos</option>
      <option value="serie_historica" {{ $filtro == 'serie_historica' ? 'selected=selected' : ''}}>Série Histórica</option>
    </select>
  </div>
  <div class="tipo-div-input serie_historica mr-2 
      @if($filtro != 'serie_historica')
       d-none
      @endif" >
   
      <label for="ano_ini">de </label>
      <select id="ano_ini" name="ano_ini">
        @foreach(App\Models\Defesa::anos() as $ano)
          <option value="{{$ano}}" @if(request()->ano_ini == $ano) selected @endif>{{$ano}}</option>
        @endforeach
      </select>

      <label for="ano_fim">até </label>
      <select id="ano_fim" name="ano_fim">
        @foreach(App\Models\Defesa::anos() as $ano)
          <option value="{{$ano}}" @if(request()->ano_fim == $ano) selected @endif>{{$ano}}</option>
        @endforeach
      </select>
      
      <label for="serie_historica_tipo">por </label>
      <select id="serie_historica_tipo" name="serie_historica_tipo">
        <option value="departamento" {{ request()->serie_historica_tipo == 'departamento' ? 'selected=selected' : ''}}>Departamentos</option>
        <option value="curso" {{ request()->serie_historica_tipo == 'curso' ? 'selected=selected' : ''}}>Cursos</option>
      </select>
  </div>
 
  <input type="submit" value="Buscar" class="btn btn-dark bg-blue-default btn-send">
</form>

@if($filtro != 'serie_historica')
  <div class="card">
    <div class="card-header">
      <b>Pesquisa:</b>
    </div>
    <div class="card-body">
      <table class="table docentes-programa-table">
        <thead>
          <tr>
            
            <th scope="col">{{ $filtro == 'departamento' ? 'Departamento' : 'Curso'}} </th>
            
            <th scope="col" class="text-center">IC (com bolsa)</th>
            <th scope="col" class="text-center">IC (sem bolsa)</th>
            
            
            <th scope="col" class="text-center">Pós-Doutorandos ativos (com bolsa)</th>
            <th scope="col" class="text-center">Pós-Doutorandos ativos (sem bolsa)</th>

            <th scope="col" class="text-center">Pesquisadores Colaboradores Ativos</th>
            <th scope="col" class="text-center">Projetos de Pesquisas dos Docentes</th>
          </tr>
        </thead>
        <tbody>
          @if($filtro == 'departamento' )

              @include('pesquisa.index.departamentos')

          @elseif($filtro == 'curso')

            @include('pesquisa.index.cursos')
            
          @endif
        
        </tbody>
      </table>  
      

    </div>
  </div>
@else
  @include('pesquisa.index.serie_historica')
@endif

@endsection('content')


@section('javascripts_bottom')
  <script src="{{ asset('assets/js/programas.js') }}"></script>
@endsection 
