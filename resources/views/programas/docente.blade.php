@extends('laravel-usp-theme::master')

@section('styles')
@parent
<link rel="stylesheet" href="../../css/programas/docente.css">
@endsection

@section('content')

<div class="card">
  <div class="card-header"><h3>{{ $content['nome'] }}</h3></div>
  <div class="card-body">

    <ul class="list-group">
      @if($content['resumo'])
        <li class="list-group-item">
          <div class="panel panel-default panel-docente">
              <div class="panel-heading">
                  <h5 role="button" data-toggle="collapse" href="#collapseResumo"  aria-controls="collapseResumo" 
                    {{$section_show == 'resumo' ? "aria-expanded=true" : "aria-expanded=false class=collapsed"}}
                  >
                  Resumo
                      <span class="controller-collapse">
                          <i class="fas fa-plus-square"></i>
                          <i class="fas fa-minus-square"></i>  
                      </span>
                  </h5>
              </div>
              <div class="panel-body collapse in {{ $section_show == 'resumo' ?  'show' : ''}}" id="collapseResumo">
                  <ul class="list-group">
                    <li class="list-group-item">
                      <p>{{ $content['resumo'] }}</p>
                    </li>
                  </ul>
              </div>
          </div>
        </li>
      @endif

      @if($content['linhas_pesquisa'])
        <li class="list-group-item">
          <div class="panel panel-default panel-docente ">
              <div class="panel-heading">
                  <h5 role="button" data-toggle="collapse" href="#collapseLinhaPesquisa" aria-controls="collapseLinhaPesquisa"
                  {{$section_show == 'linhas_pesquisa' ? "aria-expanded=true" : "aria-expanded=false class=collapsed"}}>
                      Linhas de pesquisa
                      <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                      </span>
                  </h5>
              </div>
              <ul class="list-group collapse in  {{ $section_show == 'linhas_pesquisa' ?  'show' : ''}}" id="collapseLinhaPesquisa">
                  @foreach($content['linhas_pesquisa'] as $key => $value)
                      <li class="list-group-item"> {{ $value }} </li> 
                  @endforeach 
              </ul>
              
          </div>
        </li>
      @endif

      @if($content['livros'])
        <li class="list-group-item">
          <div class="panel panel-default panel-docente">
              <div class="panel-heading">
                  <h5 role="button" data-toggle="collapse" href="#collapseLivrosPublicados"  aria-controls="collapseLivrosPublicados"
                  {{$section_show == 'livros' ? "aria-expanded=true" : "aria-expanded=false class=collapsed"}}>
                      Livros publicados: {{count($content['livros'])}}
                      <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                      </span>
                  </h5>
              </div>
              
              <ul class="list-group collapse in {{ $section_show == 'livros' ?  'show' : ''}}" id="collapseLivrosPublicados">
                  @foreach($content['livros'] as $key => $value)
                      <li class="list-group-item">
                      @foreach($value['AUTORES'] as $k=>$val)
                          {{ $val["NOME-PARA-CITACAO"] }} 
                          @if($k + 1 <  count($value['AUTORES']))
                              ;
                          @endif
                      @endforeach 
                      
                      {{ $value["TITULO-DO-LIVRO"] }}. 
                      {{ $value["CIDADE-DA-EDITORA"] }}: {{ $value["NOME-DA-EDITORA"] }},
                      {{ $value["ANO"] }}. {{ $value["NUMERO-DE-PAGINAS"] }}p. 
                      
                      </li>
                      @endforeach
              </ul>
            
          </div>
        </li>
      @endif


      @if($content['artigos'])
      <li class="list-group-item">
        <div class="panel panel-default panel-docente">
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapseArtigos"  aria-controls="collapseArtigos"
                {{$section_show == 'artigos' ? "aria-expanded=true" : "aria-expanded=false class=collapsed"}}>
                    Artigos completos publicados em periódicos: {{count($content['artigos'])}}
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            
            <ul class="list-group collapse in {{ $section_show == 'artigos' ?  'show' : ''}}" id="collapseArtigos">
                @foreach($content['artigos'] as $key=>$value)
                    <li class="list-group-item">
                        @foreach($value['AUTORES'] as  $k=>$val)
                            {{ $val["NOME-PARA-CITACAO"] }} 
                            @if($k + 1 <  count($value['AUTORES']))
                                ;
                            @endif
                        @endforeach 
                        
                        {{ $value["TITULO-DO-ARTIGO"] }}. 
                        {{ $value["TITULO-DO-PERIODICO-OU-REVISTA"] }},
                        v. {{ $value["VOLUME"] }},
                        p. {{ $value["PAGINA-INICIAL"] }} - {{ $value["PAGINA-FINAL"] }},
                        {{ $value["ANO"] }}.
                    </li>
                @endforeach
            </ul>
            
        </div>
      </li>
      @endif

      @if($content['capitulos'])
      <li class="list-group-item">
        <div class="panel panel-default panel-docente"> 
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapseCapitulos" aria-controls="collapseCapitulos"
                {{$section_show == 'capitulos' ? "aria-expanded=true" : "aria-expanded=false class=collapsed"}}>
                
                    Capítulos publicados: {{count($content['capitulos'])}}
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            
            <ul class="list-group collapse in  {{ $section_show == 'capitulos' ?  'show' : ''}}" id="collapseCapitulos">
                @foreach($content['capitulos'] as $key=>$value)
                    <li class="list-group-item">
                        {{-- 
                        @foreach($value['AUTORES'] as $k=>$val)
                        {{ $val["NOME-PARA-CITACAO"] }} 
                        @if( $k + 1 <  count($value['AUTORES']))
                        ;
                        @endif
                        @endforeach
                        --}}
                        
                        {{ $value["TITULO-DO-CAPITULO-DO-LIVRO"] }}. 
                        {{ $value["TITULO-DO-LIVRO"] }},
                        v. {{ $value["NUMERO-DE-VOLUMES"] }},
                        p. {{ $value["PAGINA-INICIAL"] }} - {{ $value["PAGINA-FINAL"] }},
                        {{ $value["ANO"] }}.
                    </li>
                @endforeach
            </ul>
        </div>
     </li>
      @endif

      @if($content['orientandos'])
        <li class="list-group-item">
            <div class="panel panel-default panel-docente">
                <div class="panel-heading">
                    <h5 role="button" data-toggle="collapse" href="#collapseOrientandos" aria-controls="collapseOrientandos"
                    {{$section_show == 'orientandos' ? "aria-expanded=true" : "aria-expanded=false class=collapsed"}}>
                        Orientandos Ativos: {{count($content['orientandos'])}}
                        <span class="controller-collapse">
                            <i class="fas fa-plus-square"></i>
                            <i class="fas fa-minus-square"></i>  
                        </span>
                    </h5>
                </div>
                <div class="panel-body collapse in {{ $section_show == 'orientandos' ?  'show' : ''}}" id="collapseOrientandos">
                    <table class="table">
                    <tr >
                        <td>Número USP</td>
                        <td>Nome orientando</td>
                        <td>Área</td>
                        <td>Nível de Programa</td>
                    </tr>
                    @foreach($content['orientandos'] as $row )
                        <tr>
                            <td>{{ $row['codpespgm'] }}</td>
                            <td>{{ $row['nompes'] }}</td>
                            <td>{{ $row['nomare'] }}</td>
                            @if($row['nivpgm'] == 'DO')
                                <td>Doutorado</td>
                            @endif
                            @if( $row['nivpgm'] == 'DD')
                                <td>Doutorado Direto</td>
                            @endif
                            @if( $row['nivpgm'] == 'ME')
                                <td>Mestrado</td>
                            @endif
                        </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </li>
      @endif

      @if($content['orientandos_concluidos'])
        <li class="list-group-item">
            <div class="panel panel-default panel-docente">
                <div class="panel-heading">
                    <h5 role="button" data-toggle="collapse" href="#collapseOrientandosConcluidos" aria-controls="collapseOrientandosConcluidos"
                    {{$section_show == 'orientandos_concluidos' ? "aria-expanded=true" : "aria-expanded=false class=collapsed"}}>
                        Orientandos Concluídos: {{count($content['orientandos_concluidos'])}}
                        <span class="controller-collapse">
                            <i class="fas fa-plus-square"></i>
                            <i class="fas fa-minus-square"></i>  
                        </span>
                    </h5>
                </div>
                <div class="panel-body collapse in {{ $section_show == 'orientandos_concluidos' ?  'show' : ''}}" id="collapseOrientandosConcluidos">
                    <table class="table ">
                    <tr >
                        <td>Número USP</td>
                        <td>Nome orientando</td>
                        <td>Área</td>
                        <td>Nível de Programa</td>
                        <td>Data de defesa</td>
                    </tr>
                    @foreach( $content['orientandos_concluidos'] as $row )
                        <tr>
                            <td>{{ $row['codpespgm'] }}</td>
                            <td>{{ $row['nompes'] }}</td>
                            <td>{{ $row['nomare'] }}</td>
                            @if($row['nivpgm'] == 'DO')
                                <td>Doutorado</td>
                            @endif 
                            @if($row['nivpgm'] == 'DD') 
                                <td>Doutorado Direto</td>
                            @endif 
                            @if($row['nivpgm'] == 'ME') 
                                <td>Mestrado</td>
                            @endif 
                            <td>{{ $row['dtadfapgm'] }}</td>
                        </tr>
                    @endforeach 
                    </table>
                </div>
            </div>
        </li>
       @endif


    </ul>

  </div>
</div>

@endsection('content')
