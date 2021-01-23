@extends('laravel-usp-theme::master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/programas.css') }}">
@endsection('styles')

@section('content')

<form id="formSearchProducaoPrograma" method="show" action="/programas/{{$programa['codare']}}" class="d-flex mb-3">
  <div class="tipo-select-div">
    <label for="tipo">Filtrar por:</label>
    <select name="tipo" id="tipo" class="mr-2">
      <option value="">Selecione</option>
      <option value="anual" {{ $filtro['tipo'] == 'anual' ? 'selected=selected' : ''}}>Ano</option>
      <option value="periodo" {{ $filtro['tipo'] == 'periodo' ? 'selected=selected' : ''}}>Período</option>
      <option value="tudo" title="Traz todas as produções independente da data" {{ $filtro['tipo'] == 'tudo' ? 'selected=selected' : ''}}>Tudo</option>
    </select>
  </div>
  <div class="tipo-div-input anual mr-2 
      @if($filtro['tipo'] != 'anual')
       d-none
      @endif">
    <label for="ano">Ano:</label>
    <input type="number" name="ano" id="ano" value="{{ $filtro['limit_ini']}}">
  </div>
  <div class="tipo-div-input periodo mr-2 
      @if($filtro['tipo'] != 'periodo')
       d-none
      @endif" >
    <label for="ano_ini">Ano inicial:</label>
    <input type="number" name="ano_ini" id="ano_ini" value="{{ $filtro['limit_ini']}}">
    <label for="ano_fim">Ano final:</label>
    <input type="number" name="ano_fim" id="ano_fim" value="{{ $filtro['limit_fim']}}">
  </div>
  <input type="submit" value="Buscar" class="btn btn-dark btn-send">
</form>

<div class="card">
  <div class="card-header">
    <b>Docentes credenciados ao programa de {{$programa['nomcur']}}: {{count($credenciados)}}</b>
  </div>
  <div class="card-body">
    <table class="table docentes-programa-table">
      <thead>
        <tr>
          <th scope="col">Docente</th>
          <th scope="col" class="text-center">Livros</th>
          <th scope="col" class="text-center">Artigos</th>
          <th scope="col" class="text-center">Capítulos de Livros</th>
          <th scope="col" class="text-center">Lattes</th>
          <th scope="col" class="text-center">Última Atualização Lattes</th>
        </tr>
      </thead>
      <tbody>
        @foreach($credenciados as $credenciado)
        <tr>
          <td>
            <a href="/programas/docente/{{$credenciado['codpes']}}">
              {{$credenciado['nompes']}}
            </a>
          </td>
          <td class="text-center">
            <a href="/programas/docente/{{$credenciado['codpes']}}?section=livros">
              {{$credenciado['total_livros']}}
            </a>
          </td>
          <td class="text-center">
            <a href="/programas/docente/{{$credenciado['codpes']}}?section=artigos">
              {{$credenciado['total_artigos']}}
            </a>
          </td>
          <td class="text-center">
            <a href="/programas/docente/{{$credenciado['codpes']}}?section=capitulos">
              {{$credenciado['total_capitulos']}}
            </a>
          </td>
          <td class="text-center">
            <a target="_blank" href="http://lattes.cnpq.br/{{$credenciado['id_lattes']}}">
              <img src="http://buscatextual.cnpq.br/buscatextual/images/titulo-sistema.png">
            </a>
          </td>
          <td class="text-center">{{$credenciado['data_atualizacao']}}</td>
        </tr>
        
        @endforeach
       
      </tbody>
    </table>  
    

  </div>
</div>



@endsection('content')

@section('javascripts_bottom')
  <script src="{{ asset('assets/js/programas.js') }}"></script>
@endsection 