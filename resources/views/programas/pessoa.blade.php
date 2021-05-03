@extends('laravel-usp-theme::master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/programas.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/jpswalsh/academicons@1/css/academicons.min.css">

@endsection

@section('content')

@include ('programas.partials.search')

<div class="card">
  <div class="card-header"><h3> @arr([$content,'nome']) </h3></div>
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
                      <p>@arr([$content,'resumo'])</p>
                      <p>&nbsp;</p>
                      <p>
                            <b>Links: &nbsp;</b>
                            @if($content['id_lattes'] != null)
                                <a target="_blank" href="http://lattes.cnpq.br/@arr([$content,'id_lattes'])">
                                <i class="ai ai-lattes ai-2x f-20"></i></a>
                            @endif
                            &nbsp;
                            @if($content['orcid'] != null)
                                <a target="_blank" href="@arr([$content,'orcid'])">
                                <i class="ai ai-orcid ai-2x f-20"></i>
                                </a>
                            @endif
                      </p>

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
                      <li class="list-group-item"> {!! $value !!}   </li> 
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
                      @if(isset($value['destaque']) && $value['destaque'] == true)
                      Destaque: 
                      @endif

                      @include ('programas.partials.autores')

                        @arr([$value,'TITULO-DO-LIVRO']). 
                        @arr([$value,'CIDADE-DA-EDITORA']) : @arr([$value,'NOME-DA-EDITORA']),
                        @arr([$value,'ANO']) . @arr([$value,'NUMERO-DE-PAGINAS'])p.  
                        ISBN: @arr([$value,'ISBN']). 
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
                    @php 
                        $obj = (object) $value;
                    @endphp
                    <li class="list-group-item">
                        @include ('programas.partials.autores')
                        
                        @arr([$value,'TITULO-DO-ARTIGO'])
                        @arr([$value,'TITULO-DO-PERIODICO-OU-REVISTA']) ,
                        v. @arr([$value,'VOLUME']) ,
                        p. @arr([$value,'PAGINA-INICIAL'])  - @arr([$value,'PAGINA-FINAL']) ,
                        @arr([$value,'ANO']). ISSN: @arr([$value,'ISSN']).
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
                         
                    @include ('programas.partials.autores')
                                               
                        @arr([$value,'TITULO-DO-CAPITULO-DO-LIVRO']). 
                        @arr([$value,'TITULO-DO-LIVRO']),
                        v. @arr([$value,'NUMERO-DE-VOLUMES']),
                        p. @arr([$value,'PAGINA-INICIAL']) - @arr([$value,'PAGINA-FINAL']),
                        @arr([$value,'ANO']).
                    </li>
                @endforeach
            </ul>
        </div>
     </li>
      @endif
     
      @if($content['jornal_revista'])
      <li class="list-group-item">
        <div class="panel panel-default panel-docente"> 
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapsejornal_revista" aria-controls="collapsejornal_revista"
                {{$section_show == 'jornal_revista' ? "aria-expanded=true" : "aria-expanded=false class=collapsed"}}>
                
                    Textos em jornais de notícias/revistas: {{count($content['jornal_revista'])}}
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            
            <ul class="list-group collapse in  {{ $section_show == 'jornal_revista' ?  'show' : ''}}" id="collapsejornal_revista">
                @foreach($content['jornal_revista'] as $key=>$value)
                    <li class="list-group-item">
                         
                @include ('programas.partials.autores')
                        
                        @arr([$value,'TITULO']) . 
                        @arr([$value,'TITULO-DO-JORNAL-OU-REVISTA']) ,
                        @arr([$value,'LOCAL-DE-PUBLICACAO']) ,
                        <?php
                            if(isset($value["DATA"])){
                                $meses = ['', 'jan', 'fev', 'mar', 'abr', 'mai', 'jun', 'jul', 'ago', 'set', 'out', 'nov', 'dez']; 
                                echo substr($value["DATA"],0,2) .' '. $meses[(int)substr($value["DATA"],2,2)] .'. '. substr($value["DATA"],4,4) .'.';
                            }
                        ?>
                    </li>
                @endforeach
            </ul>
        </div>
     </li>
      @endif
      
      @if($content['trabalhos_anais'])
      <li class="list-group-item">
        <div class="panel panel-default panel-docente"> 
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapsetrabalhos_anais" aria-controls="collapsetrabalhos_anais"
                {{$section_show == 'trabalhos_anais' ? "aria-expanded=true" : "aria-expanded=false class=collapsed"}}>
                
                    Trabalhos em Anais: {{count($content['trabalhos_anais'])}}
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            
            <ul class="list-group collapse in  {{ $section_show == 'trabalhos_anais' ?  'show' : ''}}" id="collapsetrabalhos_anais">
                @foreach($content['trabalhos_anais'] as $key=>$value)
                    <li class="list-group-item">
                         
                    @include ('programas.partials.autores')

                        @arr([$value,'TITULO']). 
                        @if(isset($value['NOME-DO-EVENTO']) )
                        In:  @arr([$value,'NOME-DO-EVENTO'])  ,
                        @arr([$value,'ANO']) ,  @arr([$value,'CIDADE-DO-EVENTO']).
                        @endif

                        @arr([$value,'TITULO-DOS-ANAIS-OU-PROCEEDINGS']).

                        @if(isset($value['NOME-DA-EDITORA']))
                        @arr([$value,'CIDADE-DA-EDITORA'])  :  @arr([$value,'NOME-DA-EDITORA']),
                        @endif
                        @arr([$value,'ANO-DE-REALIZACAO']).

                        @if(isset($value['PAGINA-INICIAL']))
                            p.  @arr([$value,'PAGINA-INICIAL'])  - @arr([$value,'PAGINA-FINAL']).
                        @endif
                        
                    </li>
                @endforeach
            </ul>
        </div>
     </li>
      @endif
      
      @if($content['outras_producoes_bibliograficas'])
      <li class="list-group-item">
        <div class="panel panel-default panel-docente"> 
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapseoutras_producoes_bibliograficas" aria-controls="collapseoutras_producoes_bibliograficas"
                {{$section_show == 'outras_producoes_bibliograficas' ? "aria-expanded=true" : "aria-expanded=false class=collapsed"}}>
                
                    Outras Produções Bibliográficas: {{count($content['outras_producoes_bibliograficas'])}}
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            
            <ul class="list-group collapse in  {{ $section_show == 'outras_producoes_bibliograficas' ?  'show' : ''}}" id="collapseoutras_producoes_bibliograficas">
                @foreach($content['outras_producoes_bibliograficas'] as $key=>$value)
                    <li class="list-group-item">
                         
                    @include ('programas.partials.autores')
                        
                        @arr([$value,'TITULO']). 
                        @arr([$value,'CIDADE-DA-EDITORA']) :
                        @if(isset($value['EDITORA']) )@arr([$value,'EDITORA']) ,
                        @endif
                        @arr([$value,'ANO']) 
                        @if(isset($value['TIPO']) )
                            (@arr([$value,'TIPO']))
                        @endif

                        <?php
                            if(isset($value["DATA"])){
                                $meses = ['', 'jan', 'fev', 'mar', 'abr', 'mai', 'jun', 'jul', 'ago', 'set', 'out', 'nov', 'dez']; 
                                echo substr($value["DATA"],0,2) .' '. $meses[(int)substr($value["DATA"],2,2)] .'. '. substr($value["DATA"],4,4) .'.';
                            }
                        ?>
                    </li>
                @endforeach
            </ul>
        </div>
     </li>
      @endif
      
      @if($content['trabalhos_tecnicos'])
      <li class="list-group-item">
        <div class="panel panel-default panel-docente"> 
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapsetrabalhos_tecnicos" aria-controls="collapsetrabalhos_tecnicos"
                {{$section_show == 'trabalhos_tecnicos' ? "aria-expanded=true" : "aria-expanded=false class=collapsed"}}>
                
                    Trabalhos técnicos: {{count($content['trabalhos_tecnicos'])}}
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            
            <ul class="list-group collapse in  {{ $section_show == 'trabalhos_tecnicos' ?  'show' : ''}}" id="collapsetrabalhos_tecnicos">
                @foreach($content['trabalhos_tecnicos'] as $key=>$value)
                    <li class="list-group-item">
                         
                    @include ('programas.partials.autores')
                        
                    @arr([$value,'TITULO']). 
                    @arr([$value,'ANO']) (<?= isset($value['TIPO']) ? ucfirst(strtolower($value['TIPO'])) : '' ?>)

                    </li>
                @endforeach
            </ul>
        </div>
     </li>
      @endif
      
      @if($content['apresentacao_trabalho'])
      <li class="list-group-item">
        <div class="panel panel-default panel-docente"> 
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapseapresentacao_trabalho" aria-controls="collapseapresentacao_trabalho"
                {{$section_show == 'apresentacao_trabalho' ? "aria-expanded=true" : "aria-expanded=false class=collapsed"}}>
                
                    Apresentações de Trabalho: {{count($content['apresentacao_trabalho'])}}
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            
            <ul class="list-group collapse in  {{ $section_show == 'apresentacao_trabalho' ?  'show' : ''}}" id="collapseapresentacao_trabalho">
                @foreach($content['apresentacao_trabalho'] as $key=>$value)
                    <li class="list-group-item">
                         
                    @include ('programas.partials.autores')
                        
                    @arr([$value,'TITULO']). 
                    @arr([$value,'ANO'])
                    (<?php 
                        if(isset($value['TIPO']) && $value['TIPO'] == 'SEMINARIO')
                            echo 'Seminário';
                        elseif(isset($value['TIPO']) && $value['TIPO'] == 'CONFERENCIA')
                            echo 'Conferência';
                        elseif(isset($value['TIPO']) )
                            echo ucfirst(strtolower($value['TIPO']));
                    ?>)


                    </li>
                @endforeach
            </ul>
        </div>
     </li>
      @endif

      @if($content['radio_tv'])
      <li class="list-group-item">
        <div class="panel panel-default panel-docente"> 
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapseradio_tv" aria-controls="collapseradio_tv"
                {{$section_show == 'radio_tv' ? "aria-expanded=true" : "aria-expanded=false class=collapsed"}}>
                
                Programa de Rádio ou TV: {{count($content['radio_tv'])}}
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            
            <ul class="list-group collapse in  {{ $section_show == 'radio_tv' ?  'show' : ''}}" id="collapseradio_tv">
                @foreach($content['radio_tv'] as $key=>$value)
                    <li class="list-group-item">
                         
                        @include ('programas.partials.autores')
                        
                        
                        @arr([$value,'TITULO']). 
                        @arr([$value,'ANO']) (@arr([$value,'EMISSORA']))

                    </li>
                @endforeach
            </ul>
        </div>
     </li>
      @endif
     
      @if($content['organizacao_evento'])
      <li class="list-group-item">
        <div class="panel panel-default panel-docente"> 
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapseorganizacao_evento" aria-controls="collapseorganizacao_evento"
                {{$section_show == 'organizacao_evento' ? "aria-expanded=true" : "aria-expanded=false class=collapsed"}}>
                
                    Organização de eventos: {{count($content['organizacao_evento'])}}
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            
            <ul class="list-group collapse in  {{ $section_show == 'organizacao_evento' ?  'show' : ''}}" id="collapseorganizacao_evento">
                @foreach($content['organizacao_evento'] as $key=>$value)
                    <li class="list-group-item">
                         
                        @include ('programas.partials.autores')
                        
                        
                        @arr([$value,'TITULO']). 
                        @arr([$value,'ANO']) (@arr([$value,'INSTITUICAO-PROMOTORA']))

                    </li>
                @endforeach
            </ul>
        </div>
     </li>
      @endif
     
     
      @if($content['curso_curta_duracao'])
      <li class="list-group-item">
        <div class="panel panel-default panel-docente"> 
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapsecurso_curta_duracao" aria-controls="collapsecurso_curta_duracao"
                {{$section_show == 'curso_curta_duracao' ? "aria-expanded=true" : "aria-expanded=false class=collapsed"}}>
                
                    Curso de curta duração ministrado: {{count($content['curso_curta_duracao'])}}
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            
            <ul class="list-group collapse in  {{ $section_show == 'curso_curta_duracao' ?  'show' : ''}}" id="collapsecurso_curta_duracao">
                @foreach($content['curso_curta_duracao'] as $key=>$value)
                    <li class="list-group-item">
                         
                        @include ('programas.partials.autores')
                        
                        
                        @arr([$value,'TITULO']). 
                        @arr([$value,'ANO'])  (@arr([$value,'INSTITUICAO-PROMOTORA-DO-CURSO']))

                    </li>
                @endforeach
            </ul>
        </div>
     </li>
      @endif
     
     
      @if($content['relatorio_pesquisa'])
      <li class="list-group-item">
        <div class="panel panel-default panel-docente"> 
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapserelatorio_pesquisa" aria-controls="collapserelatorio_pesquisa"
                {{$section_show == 'relatorio_pesquisa' ? "aria-expanded=true" : "aria-expanded=false class=collapsed"}}>
                
                    Relatório de Pesquisa: {{count($content['relatorio_pesquisa'])}}
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            
            <ul class="list-group collapse in  {{ $section_show == 'relatorio_pesquisa' ?  'show' : ''}}" id="collapserelatorio_pesquisa">
                @foreach($content['relatorio_pesquisa'] as $key=>$value)
                    <li class="list-group-item">
                         
                        @include ('programas.partials.autores')
                        
                        
                        @arr([$value,'TITULO']). 
                        @arr([$value,'ANO'])  

                    </li>
                @endforeach
            </ul>
        </div>
     </li>
      @endif
      
      
      @if($content['material_didatico'])
      <li class="list-group-item">
        <div class="panel panel-default panel-docente"> 
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapsematerial_didatico" aria-controls="collapsematerial_didatico"
                {{$section_show == 'material_didatico' ? "aria-expanded=true" : "aria-expanded=false class=collapsed"}}>
                
                    Desenvolvimento de material didático ou instrucional: {{count($content['material_didatico'])}}
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            
            <ul class="list-group collapse in  {{ $section_show == 'material_didatico' ?  'show' : ''}}" id="collapsematerial_didatico">
                @foreach($content['material_didatico'] as $key=>$value)
                    <li class="list-group-item">

                        @include ('programas.partials.autores')
                
                        @arr([$value,'TITULO']). 
                        @arr([$value,'ANO'])  (<?= isset($value['NATUREZA']) ? ucfirst(strtolower($value['NATUREZA'])) : '' ?>)
                        

                    </li>
                @endforeach
            </ul>
        </div>
     </li>
      @endif
     
      @if($content['projetos_pesquisa'])
      <li class="list-group-item">
        <div class="panel panel-default panel-docente"> 
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapseprojetos_pesquisa" aria-controls="collapseprojetos_pesquisa"
                {{$section_show == 'projetos_pesquisa' ? "aria-expanded=true" : "aria-expanded=false class=collapsed"}}>
                
                    Projetos de Pesquisa: {{count($content['projetos_pesquisa'])}}
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            
            <ul class="list-group collapse in  {{ $section_show == 'projetos_pesquisa' ?  'show' : ''}}" id="collapseprojetos_pesquisa">
                @foreach($content['projetos_pesquisa'] as $key=>$value)
                    <li class="list-group-item">
                         
                        <b>Nome do projeto:</b>  @arr([$value,'NOME-DO-PROJETO']) ( @arr([$value,'ANO-INICIO'])  - 
                        @if(empty($value["ANO-FIM"]) || $value["ANO-FIM"] == '' || $value["ANO-FIM"] == null)
                            Atual)
                        @else
                            @arr([$value,'ANO-FIM'])
                        @endif
                        <br>
                        @if(isset($value['NATUREZA']))
                            <b>Natureza: </b><?= ucfirst(strtolower($value['NATUREZA'])) ?> <br>
                        @endif
                        <b>Integrantes: </b>
                        @foreach($value['EQUIPE-DO-PROJETO'] as $k=>$val)
                            @if( $k + 1 <  count($value['EQUIPE-DO-PROJETO']))
                                @arr([$val,'NOME-COMPLETO']), 
                            @elseif (isset($val["NOME-COMPLETO"]) && $val["NOME-COMPLETO"] != null && $val["NOME-COMPLETO"] != "")
                                @arr([$val,'NOME-COMPLETO']).
                            @endif
                        @endforeach 
                        <br>
                        <b>Descrição: </b> @arr([$value,'DESCRICAO-DO-PROJETO'])
                       
                         

                    </li>
                @endforeach
            </ul>
        </div>
     </li>
      @endif
     
     
      @if($content['outras_producoes_tecnicas'])
      <li class="list-group-item">
        <div class="panel panel-default panel-docente"> 
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapseoutras_producoes_tecnicas" aria-controls="collapseoutras_producoes_tecnicas"
                {{$section_show == 'outras_producoes_tecnicas' ? "aria-expanded=true" : "aria-expanded=false class=collapsed"}}>
                
                    Outras produções técnicas: {{count($content['outras_producoes_tecnicas'])}}
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            
            <ul class="list-group collapse in  {{ $section_show == 'outras_producoes_tecnicas' ?  'show' : ''}}" id="collapseoutras_producoes_tecnicas">
                @foreach($content['outras_producoes_tecnicas'] as $key=>$value)
                    <li class="list-group-item">
                         
                        @include ('programas.partials.autores')
                        
                        
                        @arr([$value,'TITULO']). 
                        @arr([$value,'ANO'])  - <?= isset($value['NATUREZA']) ? ucfirst(strtolower($value['NATUREZA'])) : '' ?>

                    </li>
                @endforeach
            </ul>
        </div>
     </li>
      @endif

      @if(isset($content['orientandos']))
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
                    <tr>
                        <td>Nome orientando</td>
                        <td>Área</td>
                        <td>Nível de Programa</td>
                    </tr>
                    @foreach($content['orientandos'] as $row )
                        <tr>
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

      @if(isset($content['orientandos_concluidos']))
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
                    <tr>
                        <td>Nome orientando</td>
                        <td>Área</td>
                        <td>Nível de Programa</td>
                        <td>Data de defesa</td>
                    </tr>
                    @foreach( $content['orientandos_concluidos'] as $row )
                        <tr>
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
                            @if(isset($row['dtadfapgm']))
                            <td> 
                                {{Carbon\Carbon::parse($row['dtadfapgm'])->format('d/m/Y')}}
                            </td>
                            @endif
                        </tr>
                    @endforeach 
                    </table>
                </div>
            </div>
        </li>
       @endif

    @if(isset($content['ultima_formacao']))
      <li class="list-group-item">
        <div class="panel panel-default panel-docente"> 
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapseultima_formacao" aria-controls="collapseultima_formacao"
                {{$section_show == 'ultima_formacao' ? "aria-expanded=true" : "aria-expanded=false class=collapsed"}}>
                    Formação Acadêmica: {{count($content['ultima_formacao'])}}
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            
            <ul class="list-group collapse in  {{ $section_show == 'ultima_formacao' ?  'show' : ''}}" id="collapseultima_formacao">
                @foreach($content['ultima_formacao'] as $key=>$value)
                    <li class="list-group-item">
                        <?= ucfirst(strtolower($key)) ?>:
                        <ul class="list-group">
                        @foreach($value as $val)
                            @if(isset($val["ANO-DE-CONCLUSAO"]))
                            <li class="list-group-item">
                            @if(isset($val['NOME-CURSO']))
                            Curso: @arr([$value,'NOME-CURSO']) <br>
                            @endif
                            Nome da Instituição: @arr([$value,'NOME-INSTITUICAO'])  <br>
                            @if(isset($val['TITULO-DO-TRABALHO-DE-CONCLUSAO-DE-CURSO']) && $val['TITULO-DO-TRABALHO-DE-CONCLUSAO-DE-CURSO'] != null && $val['TITULO-DO-TRABALHO-DE-CONCLUSAO-DE-CURSO'] != '')
                            Título: @arr([$value,'TITULO-DO-TRABALHO-DE-CONCLUSAO-DE-CURSO'])  <br> 
                            @endif
                            Ano de conclusão: 
                            @if(isset($val['ANO-DE-CONCLUSAO']) && $val['ANO-DE-CONCLUSAO'] != null && $val['ANO-DE-CONCLUSAO'] != '') 
                                @arr([$value,'ANO-DE-CONCLUSAO']) 
                            @else
                            Atual
                            @endif
                            </li>
                            @endif
                        @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
     </li>
    @endif

    @if(isset($content['ultimo_vinculo_profissional']))
      <li class="list-group-item">
        <div class="panel panel-default panel-docente"> 
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapseultimo_vinculo_profissional" aria-controls="collapseultimo_vinculo_profissional"
                {{$section_show == 'ultimo_vinculo_profissional' ? "aria-expanded=true" : "aria-expanded=false class=collapsed"}}>
                
                    Atuação Profissional: {{count($content['ultimo_vinculo_profissional'])}}
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            
            <ul class="list-group collapse in  {{ $section_show == 'ultimo_vinculo_profissional' ?  'show' : ''}}" id="collapseultimo_vinculo_profissional">
                @foreach($content['ultimo_vinculo_profissional'] as $key=>$value)
                    <li class="list-group-item">
                        @arr([$value,'NOME-INSTITUICAO']):
                        <ul class="list-group">
                        @if(isset($value['VINCULOS']['ANO-INICIO']))
                            <li class="list-group-item">
                                Tipo de vínculo: <?= isset($value['VINCULOS']['TIPO-DE-VINCULO']) ? ucfirst(strtolower($value['VINCULOS']['TIPO-DE-VINCULO'])) : 'Indefinido' ?>
                                (@arr([$value,'VINCULOS.ANO-INICIO'])  - 
                                @if($value['VINCULOS']['ANO-FIM'] == '') Atual
                                @else 
                                    @arr([$value,'VINCULOS.ANO-FIM']) 
                                @endif
                                ).
                                @if(isset($value['VINCULOS']['OUTRAS-INFORMACOES']) && $value['VINCULOS']['OUTRAS-INFORMACOES'] != '' && $value['VINCULOS']['OUTRAS-INFORMACOES'] != null && strlen($value['VINCULOS']['OUTRAS-INFORMACOES']) > 0 )
                                <br>
                                    Outras informações: @arr([$value,'VINCULOS.OUTRAS-INFORMACOES']) 
                                @endif
                                @if(isset($value['VINCULOS']['OUTRO-ENQUADRAMENTO-FUNCIONAL-INFORMADO']) && $value['VINCULOS']['OUTRO-ENQUADRAMENTO-FUNCIONAL-INFORMADO'] != '' && $value['VINCULOS']['OUTRO-ENQUADRAMENTO-FUNCIONAL-INFORMADO'] != null && strlen($value['VINCULOS']['OUTRO-ENQUADRAMENTO-FUNCIONAL-INFORMADO']) > 0)
                                <br>
                                    Outras informações: @arr([$value,'VINCULOS.OUTRO-ENQUADRAMENTO-FUNCIONAL-INFORMADO']) 
                                @endif                                
                            </li>
                        @else
                            @foreach($value['VINCULOS'] as $val)
                                @if(isset($val["ANO-INICIO"]))
                                <li class="list-group-item">
                                Tipo de vínculo: <?= isset($val['TIPO-DE-VINCULO']) ? ucfirst(strtolower($val['TIPO-DE-VINCULO'])) : 'Indefinido' ?>
                                (@arr([$value,'ANO-INICIO']) - 
                                @if($val['ANO-FIM'] == '') Atual
                                @else
                                    @arr([$value,'ANO-FIM'])
                                @endif
                                ).
                                @if(isset($value['VINCULOS']['OUTRAS-INFORMACOES']) && $value['VINCULOS']['OUTRAS-INFORMACOES'] != '' && $value['VINCULOS']['OUTRAS-INFORMACOES'] != null && strlen($value['VINCULOS']['OUTRAS-INFORMACOES']) > 0 )
                                <br>
                                    Outras informações: @arr([$value,'VINCULOS.OUTRAS-INFORMACOES']) 
                                @endif
                                @if(isset($value['VINCULOS']['OUTRO-ENQUADRAMENTO-FUNCIONAL-INFORMADO']) && $value['VINCULOS']['OUTRO-ENQUADRAMENTO-FUNCIONAL-INFORMADO'] != '' && $value['VINCULOS']['OUTRO-ENQUADRAMENTO-FUNCIONAL-INFORMADO'] != null && strlen($value['VINCULOS']['OUTRO-ENQUADRAMENTO-FUNCIONAL-INFORMADO']) > 0)
                                <br>
                                    Outras informações: @arr([$value,'VINCULOS.OUTRO-ENQUADRAMENTO-FUNCIONAL-INFORMADO']) 
                                @endif
                                </li>
                                @endif
                            @endforeach
                        @endif
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
     </li>
    @endif

    </ul>

  </div>
</div>

@endsection('content')

@section('javascripts_bottom')
  <script src="{{ asset('assets/js/programas.js') }}"></script>
@endsection 