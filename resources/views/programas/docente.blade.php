@extends('laravel-usp-theme::master')

@section('content')

<div class="card">
  <div class="card-header"><h3>{{ $content['nome'] }}</h3></div>
  <div class="card-body">

    <ul class="list-group">
      @if($content['resumo'])
        <li class="list-group-item">
          <div class="panel panel-default panel-docente">
              <div class="panel-heading">
                  <h5 role="button" data-toggle="collapse" href="#collapseResumo" aria-expanded="true" aria-controls="collapseResumo">Resumo</h5>
              </div>
              <div class="panel-body collapse in show" id="collapseResumo">
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
                  <h5 role="button" data-toggle="collapse" href="#collapseLinhaPesquisa" aria-expanded="true" aria-controls="collapseLinhaPesquisa">
                      Linhas de pesquisa
                  </h5>
              </div>
              <ul class="list-group collapse in show" id="collapseLinhaPesquisa">
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
                  <h5 role="button" data-toggle="collapse" href="#collapseLivrosPublicados" aria-expanded="true" aria-controls="collapseLivrosPublicados">
                      Livros publicados
                  </h5>
              </div>
              
              <ul class="list-group collapse in show" id="collapseLivrosPublicados">
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
      <div class="panel panel-default panel-docente">
          <div class="panel-heading">
              <h2 role="button" data-toggle="collapse" href="#collapseArtigos" aria-expanded="true" aria-controls="collapseArtigos">
                  Artigos completos publicados em periódicos
              </h2>
          </div>
          
          <ul class="list-group collapse in show" id="collapseArtigos">
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
      @endif

      @if($content['capitulos'])
      <div class="panel panel-default panel-docente"> 
          <div class="panel-heading">
              <h2 role="button" data-toggle="collapse" href="#collapseCapitulos" aria-expanded="true" aria-controls="collapseCapitulos">
                  Capítulos publicados
              </h2>
          </div>
          
          <ul class="list-group collapse in show" id="collapseCapitulos">
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
      @endif


    </ul>

  </div>
</div>

@endsection('content')
