@extends('laravel-usp-theme::master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/programas.css') }}">
@endsection('styles')

@section('content')

@include ('programas.partials.search')

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
          <th scope="col" class="text-center">Artigo em Jornal ou Revista</th>
          <th scope="col" class="text-center">Lattes</th>
          <th scope="col" class="text-center">Última Atualização Lattes</th>
        </tr>
      </thead>
      <tbody>
        @foreach($credenciados as $credenciado)
        <tr>
          <td>
            <a href="{{$credenciado['href']}}">
              {{$credenciado['nompes']}}
            </a>
          </td>
          <td class="text-center">
            <a href="{{$credenciado['href']}}&section=livros">
              {{$credenciado['total_livros']}}
            </a>
          </td>
          <td class="text-center">
            <a href="{{$credenciado['href']}}&section=artigos">
              {{$credenciado['total_artigos']}}
            </a>
          </td>
          <td class="text-center">
            <a href="{{$credenciado['href']}}&section=capitulos">
              {{$credenciado['total_capitulos']}}
            </a>
          </td>
          <td class="text-center">
            <a href="{{$credenciado['href']}}&section=jornal_revista">
              {{$credenciado['total_jornal_revista']}}
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