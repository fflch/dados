@extends('laravel-usp-theme::master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/programas.css') }}">
@endsection('styles')

@section('content')

@include ('programas.partials.search')

@if(isset($credenciados))
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
          <th scope="col" class="text-center">Trabalhos em anais</th>
          <th scope="col" class="text-center">Outras produções bibliográficas</th>
          <th scope="col" class="text-center">Apresentação de Trabalhos Técnicos</th>
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
            <a href="{{$credenciado['href']}}&section=trabalhos_anais">
              {{$credenciado['total_trabalhos_anais']}}
            </a>
          </td>
          <td class="text-center">
            <a href="{{$credenciado['href']}}&section=outras_producoes_bibliograficas">
              {{$credenciado['total_outras_producoes_bibliograficas']}}
            </a>
          </td>
          <td class="text-center">
            <a href="{{$credenciado['href']}}&section=trabalhos_tecnicos">
              {{$credenciado['total_trabalhos_tecnicos']}}
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
@endif 

@if(isset($discentes))
<div class="card">
  <div class="card-header">
    <b>Discentes ativos ao programa de {{$programa['nomcur']}}: {{count($discentes)}}</b>
  </div>
  <div class="card-body">
    <table class="table discentes-programa-table">
      <thead>
        <tr>
          <th scope="col">Discente</th>
          <th scope="col" class="text-center">Livros</th>
          <th scope="col" class="text-center">Artigos</th>
          <th scope="col" class="text-center">Capítulos de Livros</th>
          <th scope="col" class="text-center">Artigo em Jornal ou Revista</th>
          <th scope="col" class="text-center">Trabalhos em anais</th>
          <th scope="col" class="text-center">Outras produções bibliográficas</th>
          <th scope="col" class="text-center">Apresentação de Trabalhos Técnicos</th>
          <th scope="col" class="text-center">Lattes</th>
          <th scope="col" class="text-center">Última Atualização Lattes</th>
        </tr>
      </thead>
      <tbody>
        @foreach($discentes as $discente)
        <tr>
          <td>
            <a href="{{$discente['href']}}">
              {{$discente['nompes']}}
            </a>
          </td>
          <td class="text-center">
            <a href="{{$discente['href']}}&section=livros">
              {{$discente['total_livros']}}
            </a>
          </td>
          <td class="text-center">
            <a href="{{$discente['href']}}&section=artigos">
              {{$discente['total_artigos']}}
            </a>
          </td>
          <td class="text-center">
            <a href="{{$discente['href']}}&section=capitulos">
              {{$discente['total_capitulos']}}
            </a>
          </td>
          <td class="text-center">
            <a href="{{$discente['href']}}&section=jornal_revista">
              {{$discente['total_jornal_revista']}}
            </a>
          </td>
          <td class="text-center">
            <a href="{{$discente['href']}}&section=trabalhos_anais">
              {{$discente['total_trabalhos_anais']}}
            </a>
          </td>
          <td class="text-center">
            <a href="{{$discente['href']}}&section=outras_producoes_bibliograficas">
              {{$discente['total_outras_producoes_bibliograficas']}}
            </a>
          </td>
          <td class="text-center">
            <a href="{{$discente['href']}}&section=trabalhos_tecnicos">
              {{$discente['total_trabalhos_tecnicos']}}
            </a>
          </td>
          <td class="text-center">
            <a target="_blank" href="http://lattes.cnpq.br/{{$discente['id_lattes']}}">
              <img src="http://buscatextual.cnpq.br/buscatextual/images/titulo-sistema.png">
            </a>
          </td>
          <td class="text-center">{{$discente['data_atualizacao']}}</td>
        </tr>
        
        @endforeach
       
      </tbody>
    </table>  
  </div>
</div>
@endif

@if(isset($egressos))
<div class="card">
  <div class="card-header">
    <b>Egressos do programa de {{$programa['nomcur']}}: {{count($egressos)}}</b>
  </div>
  <div class="card-body">
    <table class="table egressos-programa-table">
      <thead>
        <tr>
          <th scope="col">Egresso</th>
          <th scope="col" class="text-center">Livros</th>
          <th scope="col" class="text-center">Artigos</th>
          <th scope="col" class="text-center">Capítulos de Livros</th>
          <th scope="col" class="text-center">Artigo em Jornal ou Revista</th>
          <th scope="col" class="text-center">Trabalhos em anais</th>
          <th scope="col" class="text-center">Outras produções bibliográficas</th>
          <th scope="col" class="text-center">Apresentação de Trabalhos Técnicos</th>
          <th scope="col" class="text-center">Lattes</th>
          <th scope="col" class="text-center">Última Atualização Lattes</th>
        </tr>
      </thead>
      <tbody>
        @foreach($egressos as $egresso)
        <tr>
          <td>
            <a href="{{$egresso['href']}}">
              {{$egresso['nompes']}}
            </a>
          </td>
          <td class="text-center">
            <a href="{{$egresso['href']}}&section=livros">
              {{$egresso['total_livros']}}
            </a>
          </td>
          <td class="text-center">
            <a href="{{$egresso['href']}}&section=artigos">
              {{$egresso['total_artigos']}}
            </a>
          </td>
          <td class="text-center">
            <a href="{{$egresso['href']}}&section=capitulos">
              {{$egresso['total_capitulos']}}
            </a>
          </td>
          <td class="text-center">
            <a href="{{$egresso['href']}}&section=jornal_revista">
              {{$egresso['total_jornal_revista']}}
            </a>
          </td>
          <td class="text-center">
            <a href="{{$egresso['href']}}&section=trabalhos_anais">
              {{$egresso['total_trabalhos_anais']}}
            </a>
          </td>
          <td class="text-center">
            <a href="{{$egresso['href']}}&section=outras_producoes_bibliograficas">
              {{$egresso['total_outras_producoes_bibliograficas']}}
            </a>
          </td>
          <td class="text-center">
            <a href="{{$egresso['href']}}&section=trabalhos_tecnicos">
              {{$egresso['total_trabalhos_tecnicos']}}
            </a>
          </td>
          <td class="text-center">
            <a target="_blank" href="http://lattes.cnpq.br/{{$egresso['id_lattes']}}">
              <img src="http://buscatextual.cnpq.br/buscatextual/images/titulo-sistema.png">
            </a>
          </td>
          <td class="text-center">{{$egresso['data_atualizacao']}}</td>
        </tr>
        
        @endforeach
       
      </tbody>
    </table>  
  </div>
</div>
@endif

@endsection('content')

@section('javascripts_bottom')
  <script src="{{ asset('assets/js/programas.js') }}"></script>
@endsection 