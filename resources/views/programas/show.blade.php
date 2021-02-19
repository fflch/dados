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
  <div class="card-body wrapper-pessoas-programa-table">
    <table class="table pessoas-programa-table">
      <thead>
        <tr>
          <th scope="col" class="first-col"><span class="text-first-col">Docente<span></th>
          <th scope="col" class="text-center">Livros</th>
          <th scope="col" class="text-center">Artigos</th>
          <th scope="col" class="text-center">Capítulos de Livros</th>
          <th scope="col" class="text-center">Artigo em Jornal ou Revista</th>
          <th scope="col" class="text-center">Trabalhos em anais</th>
          <th scope="col" class="text-center">Outras produções bibliográficas</th>
          <th scope="col" class="text-center">Apresentação de Trabalhos Técnicos</th>
          <th scope="col" class="text-center">Lattes</th>
          <th scope="col" class="text-center">Última Atualização Lattes</th>
          @if($tipo_pessoa == "egressos")
            <th scope="col" class="text-center">Última Formação Acadêmica</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @foreach($pessoas as $pessoa)
        <tr>
        
          <td class="first-col">
              @if(isset($pessoa['href']))
                <a href="{{$pessoa['href']}}">
              @endif
                <span class="text-first-col">{{$pessoa['nompes']}}<span>
              @if(isset($pessoa['href']))
                </a>
              @endif
          </td>
        
          <td class="text-center">
            @if($pessoa['total_livros'] != 0 || $pessoa['total_livros'] != '0')
                <a href="{{$pessoa['href']}}&section=livros">
                  {{$pessoa['total_livros']}}
                </a>
            @else
                {{$pessoa['total_livros']}}
            @endif
          </td>
          <td class="text-center">
            @if($pessoa['total_artigos'] != 0 || $pessoa['total_artigos'] != '0')
              <a href="{{$pessoa['href']}}&section=artigos">
                {{$pessoa['total_artigos']}}
              </a>
            @else
                {{$pessoa['total_artigos']}}
            @endif
          </td>
          <td class="text-center">
            @if($pessoa['total_capitulos'] != 0 || $pessoa['total_capitulos'] != '0')
              <a href="{{$pessoa['href']}}&section=capitulos">
                {{$pessoa['total_capitulos']}}
              </a>
            @else
                {{$pessoa['total_capitulos']}}
            @endif
          </td>
          <td class="text-center">
            @if($pessoa['total_jornal_revista'] != 0 || $pessoa['total_jornal_revista'] != '0')
              <a href="{{$pessoa['href']}}&section=jornal_revista">
                {{$pessoa['total_jornal_revista']}}
              </a>
            @else
                {{$pessoa['total_jornal_revista']}}
            @endif
          </td>
          <td class="text-center">
            @if($pessoa['total_trabalhos_anais'] != 0 || $pessoa['total_trabalhos_anais'] != '0')
              <a href="{{$pessoa['href']}}&section=trabalhos_anais">
                {{$pessoa['total_trabalhos_anais']}}
              </a>
            @else
                {{$pessoa['total_trabalhos_anais']}}
            @endif
          </td>
          <td class="text-center">
            @if($pessoa['total_outras_producoes_bibliograficas'] != 0 || $pessoa['total_outras_producoes_bibliograficas'] != '0')
              <a href="{{$pessoa['href']}}&section=outras_producoes_bibliograficas">
                {{$pessoa['total_outras_producoes_bibliograficas']}}
              </a>
            @else
                {{$pessoa['total_outras_producoes_bibliograficas']}}
            @endif
          </td>
          <td class="text-center">
            @if($pessoa['total_trabalhos_tecnicos'] != 0 || $pessoa['total_trabalhos_tecnicos'] != '0')
              <a href="{{$pessoa['href']}}&section=trabalhos_tecnicos">
                {{$pessoa['total_trabalhos_tecnicos']}}
              </a>
            @else
                {{$pessoa['total_trabalhos_tecnicos']}}
            @endif
          </td>
          <td class="text-center">
            @if($pessoa['id_lattes'] != null)
              <a target="_blank" href="http://lattes.cnpq.br/{{$pessoa['id_lattes']}}">
                <img src="http://buscatextual.cnpq.br/buscatextual/images/titulo-sistema.png">
              </a>
            @else
              Lattes não encontrado
            @endif
          </td>
          <td class="text-center">{{$pessoa['data_atualizacao']}}</td>
          @if($tipo_pessoa == "egressos")
            <td class="text-center">
              @if(isset($pessoa['ultima_formacao']) && $pessoa['ultima_formacao'] != null && $pessoa['ultima_formacao'] != '')
                <?= ucfirst(strtolower($pessoa['ultima_formacao']['TIPO'])) ?>
                em 
                <?= htmlspecialchars_decode(($pessoa['ultima_formacao']['NOME-INSTITUICAO'])) ?>
                ({{$pessoa['ultima_formacao']['ANO-DE-CONCLUSAO']}})
              @endif
            </td>
          @endif
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