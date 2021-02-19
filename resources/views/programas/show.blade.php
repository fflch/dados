@extends('laravel-usp-theme::master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/programas.css') }}">
@endsection('styles')

@section('content')

@include ('programas.partials.search')

@if(isset($pessoas))
<div class="card">
  <div class="card-header">
    <b>{{$titulo}}</b>
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
        @foreach($pessoas as $credenciado)
        <tr>
          <td>
            <a href="{{$credenciado['href']}}">
              {{$credenciado['nompes']}}
            </a>
          </td>
          <td class="text-center">
            @if($credenciado['total_livros'] != 0 || $credenciado['total_livros'] != '0')
                <a href="{{$credenciado['href']}}&section=livros">
                  {{$credenciado['total_livros']}}
                </a>
            @else
                {{$credenciado['total_livros']}}
            @endif
          </td>
          <td class="text-center">
            @if($credenciado['total_artigos'] != 0 || $credenciado['total_artigos'] != '0')
              <a href="{{$credenciado['href']}}&section=artigos">
                {{$credenciado['total_artigos']}}
              </a>
            @else
                {{$credenciado['total_artigos']}}
            @endif
          </td>
          <td class="text-center">
            @if($credenciado['total_capitulos'] != 0 || $credenciado['total_capitulos'] != '0')
              <a href="{{$credenciado['href']}}&section=capitulos">
                {{$credenciado['total_capitulos']}}
              </a>
            @else
                {{$credenciado['total_capitulos']}}
            @endif
          </td>
          <td class="text-center">
            @if($credenciado['total_jornal_revista'] != 0 || $credenciado['total_jornal_revista'] != '0')
              <a href="{{$credenciado['href']}}&section=jornal_revista">
                {{$credenciado['total_jornal_revista']}}
              </a>
            @else
                {{$credenciado['total_jornal_revista']}}
            @endif
          </td>
          <td class="text-center">
            @if($credenciado['total_trabalhos_anais'] != 0 || $credenciado['total_trabalhos_anais'] != '0')
              <a href="{{$credenciado['href']}}&section=trabalhos_anais">
                {{$credenciado['total_trabalhos_anais']}}
              </a>
            @else
                {{$credenciado['total_trabalhos_anais']}}
            @endif
          </td>
          <td class="text-center">
            @if($credenciado['total_outras_producoes_bibliograficas'] != 0 || $credenciado['total_outras_producoes_bibliograficas'] != '0')
              <a href="{{$credenciado['href']}}&section=outras_producoes_bibliograficas">
                {{$credenciado['total_outras_producoes_bibliograficas']}}
              </a>
            @else
                {{$credenciado['total_outras_producoes_bibliograficas']}}
            @endif
          </td>
          <td class="text-center">
            @if($credenciado['total_trabalhos_tecnicos'] != 0 || $credenciado['total_trabalhos_tecnicos'] != '0')
              <a href="{{$credenciado['href']}}&section=trabalhos_tecnicos">
                {{$credenciado['total_trabalhos_tecnicos']}}
              </a>
            @else
                {{$credenciado['total_trabalhos_tecnicos']}}
            @endif
          </td>
          <td class="text-center">
            @if($credenciado['id_lattes'] != null)
              <a target="_blank" href="http://lattes.cnpq.br/{{$credenciado['id_lattes']}}">
                <img src="http://buscatextual.cnpq.br/buscatextual/images/titulo-sistema.png">
              </a>
            @else
              Lattes não encontrado
            @endif
          </td>
          <td class="text-center">{{$credenciado['data_atualizacao']}}</td>
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