@extends('laravel-usp-theme::master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/programas.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/tabelas.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/jpswalsh/academicons@1/css/academicons.min.css">
@endsection('styles')

@section('content')

@include ('programas.partials.search')

@if(isset($pessoas))
<div class="card">
  <div class="card-header">
    <b>{{$titulo}}</b>
  </div>
  <div class="card-body wrapper-pessoas-programa-table">
    <div class="scroll">
    <table class="table pessoas-programa-table" style="width: 100%;">
      <thead>
        <tr>
          <th scope="col" class="first-col"><span class="text-first-col">Nome<span></th>
          @if($tipo_pessoa == "egressos")
          <th scope="col" class="text-center">Nível Programa</th>
          @endif
          <th scope="col" class="text-center">Livros</th>
          <th scope="col" class="text-center">Artigos</th>
          <th scope="col" class="text-center">Capítulos de Livros</th>
          <th scope="col" class="text-center">Artigo em Jornal ou Revista</th>
          <th scope="col" class="text-center">Trabalhos em anais</th>
          <th scope="col" class="text-center">Outras produções bibliográficas</th>
          <th scope="col" class="text-center">Apresentação de Trabalhos Técnicos</th>
          <th scope="col" class="text-center">Organização de Eventos</th>
          <th scope="col" class="text-center">Curso de curta duração ministrado</th>
          <th scope="col" class="text-center">Relatório de pesquisa</th>
          <th scope="col" class="text-center">Matérial didático ou institucional</th>
          <th scope="col" class="text-center">Outras Produções Técnicas</th>
          <th scope="col" class="text-center">Lattes</th>
          <th scope="col" class="text-center">Última Atualização Lattes</th>
          @if($tipo_pessoa == "egressos")
            <th scope="col" class="text-center">Formação Acadêmica</th>
            <th scope="col" class="text-center">Atuação Profissional</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @foreach($pessoas as $pessoa)
        <tr>
        
          <td class="first-col">
              @if(isset($pessoa['id_lattes']) && $pessoa['id_lattes'] != null)
                <a href="{{$pessoa['href']}}">
              @endif
                <span class="text-first-col">{{$pessoa['nompes']}}<span>
              @if(isset($pessoa['id_lattes']) && $pessoa['id_lattes'] != null)
                </a>
              @endif
          </td>

          @if($tipo_pessoa == "egressos")
          <td class="text-center"> {{$pessoa['nivpgm']}} </td>
          @endif

          <td class="text-center">
            @if($pessoa['total_livros'] != 0 || $pessoa['total_livros'] != '0')
                <a href="{{$pessoa['href']}}&section=livros">
                  {{$pessoa['total_livros']}}
                </a>
            @else
                -
            @endif
          </td>
          <td class="text-center">
            @if($pessoa['total_artigos'] != 0 || $pessoa['total_artigos'] != '0')
              <a href="{{$pessoa['href']}}&section=artigos">
                {{$pessoa['total_artigos']}}
              </a>
            @else
                -
            @endif
          </td>
          <td class="text-center">
            @if($pessoa['total_capitulos'] != 0 || $pessoa['total_capitulos'] != '0')
              <a href="{{$pessoa['href']}}&section=capitulos">
                {{$pessoa['total_capitulos']}}
              </a>
            @else
                -
            @endif
          </td>
          <td class="text-center">
            @if($pessoa['total_jornal_revista'] != 0 || $pessoa['total_jornal_revista'] != '0')
              <a href="{{$pessoa['href']}}&section=jornal_revista">
                {{$pessoa['total_jornal_revista']}}
              </a>
            @else
                -
            @endif
          </td>
          <td class="text-center">
            @if($pessoa['total_trabalhos_anais'] != 0 || $pessoa['total_trabalhos_anais'] != '0')
              <a href="{{$pessoa['href']}}&section=trabalhos_anais">
                {{$pessoa['total_trabalhos_anais']}}
              </a>
            @else
                -
            @endif
          </td>
          <td class="text-center">
            @if($pessoa['total_outras_producoes_bibliograficas'] != 0 || $pessoa['total_outras_producoes_bibliograficas'] != '0')
              <a href="{{$pessoa['href']}}&section=outras_producoes_bibliograficas">
                {{$pessoa['total_outras_producoes_bibliograficas']}}
              </a>
            @else
                -
            @endif
          </td>
          <td class="text-center">
            @if($pessoa['total_trabalhos_tecnicos'] != 0 || $pessoa['total_trabalhos_tecnicos'] != '0')
              <a href="{{$pessoa['href']}}&section=trabalhos_tecnicos">
                {{$pessoa['total_trabalhos_tecnicos']}}
              </a>
            @else
                -
            @endif
          </td>
          <td class="text-center">
            @if($pessoa['total_organizacao_evento'] != 0 || $pessoa['total_organizacao_evento'] != '0')
              <a href="{{$pessoa['href']}}&section=organizacao_evento">
                {{$pessoa['total_organizacao_evento']}}
              </a>
            @else
                -
            @endif
          </td>
          <td class="text-center">
            @if($pessoa['total_curso_curta_duracao'] != 0 || $pessoa['total_curso_curta_duracao'] != '0')
              <a href="{{$pessoa['href']}}&section=curso_curta_duracao">
                {{$pessoa['total_curso_curta_duracao']}}
              </a>
            @else
                -
            @endif
          </td>
          <td class="text-center">
            @if($pessoa['total_relatorio_pesquisa'] != 0 || $pessoa['total_relatorio_pesquisa'] != '0')
              <a href="{{$pessoa['href']}}&section=relatorio_pesquisa">
                {{$pessoa['total_relatorio_pesquisa']}}
              </a>
            @else
                -
            @endif
          </td>
          <td class="text-center">
            @if($pessoa['total_material_didatico'] != 0 || $pessoa['total_material_didatico'] != '0')
              <a href="{{$pessoa['href']}}&section=material_didatico">
                {{$pessoa['total_material_didatico']}}
              </a>
            @else
                -
            @endif
          </td>
          <td class="text-center">
            @if($pessoa['total_outras_producoes_tecnicas'] != 0 || $pessoa['total_outras_producoes_tecnicas'] != '0')
              <a href="{{$pessoa['href']}}&section=outras_producoes_tecnicas">
                {{$pessoa['total_outras_producoes_tecnicas']}}
              </a>
            @else
                -
            @endif
          </td>
          <td class="text-center">
            @if($pessoa['id_lattes'] != null)
              <a target="_blank" href="http://lattes.cnpq.br/{{$pessoa['id_lattes']}}">
              <i class="ai ai-lattes ai-2x"></i>
              </a>
            @else
              Lattes não sincronizado
            @endif
          </td>
          <td class="text-center">{{$pessoa['data_atualizacao']}}</td>
          @if($tipo_pessoa == "egressos")
            <td class="text-center">
              @if($pessoa['total_ultima_formacao'] != 0 || $pessoa['total_ultima_formacao'] != '0')
                <a href="{{$pessoa['href']}}&section=ultima_formacao">
                  {{$pessoa['total_ultima_formacao']}}
                </a>
              @else
                  -
              @endif
            </td>
            <td class="text-center">
              @if($pessoa['total_ultimo_vinculo_profissional'] != 0 || $pessoa['total_ultimo_vinculo_profissional'] != '0')
                <a href="{{$pessoa['href']}}&section=ultimo_vinculo_profissional">
                    {{$pessoa['total_ultimo_vinculo_profissional']}}
                </a>
                @else
                    -
                @endif
            </td>
          @endif
        </tr>
        @endforeach
       
      </tbody>
    </table>  
    </div>
    

  </div>
</div>
@endif 

@endsection('content')

@section('javascripts_bottom')
  <script src="{{ asset('assets/js/programas.js') }}"></script>
@endsection 