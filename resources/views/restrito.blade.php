@extends('main')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/programas.css') }}">
@endsection

@section('content')

<ul class="list-group">
    <li class="list-group-item">
        <div class="panel panel-default panel-docente">
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapseCursoCEU"  aria-controls="collapseCursoCEU" 
                    aria-expanded="false" class="collapsed">
                    Planilha cursos de Cultura e Extensão
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            <div class="panel-body collapse in" id="collapseCursoCEU">
                <ul class="list-group">
                    <li class="list-group-item">
                        <form action="/restrito/curso_ceu" method="GET">
                            <div class="row">
                                <div class="col-md-1">
                                    <label><b>Filtrar por:</b></label>
                                </div>
                                <div class="col-md-3">
                                    <select id="departamento" class="form-control" aria-label="Default select example" name="departamento">
                                        <option selected value="">Departamento</option>
                                        @foreach($departamentos as $dpto)
                                            <option value="{{$dpto[0]}}">{{$dpto[1]}}</option>
                                        @endforeach
                                        <option value="1">Todos</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select id="ano_inicio" class="form-control" name="ano_inicio">
                                        <option selected value="">Ano inicio</option>
                                        @for($ano = Date('Y'); $ano >= 2000; $ano--)
                                        <option value="{{$ano}}" @if(request()->ano == $ano) selected @endif>{{$ano}}</option>
                                        @endfor
                                    </select>                        
                                </div>
                                <div class="col-md-2">
                                    <select id="ano_fim" class="form-control" name="ano_fim">
                                        <option selected value="">Ano fim</option>
                                        @for($ano = Date('Y'); $ano >= 2000; $ano--)
                                        <option value="{{$ano}}" @if(request()->ano == $ano) selected @endif>{{$ano}}</option>
                                        @endfor
                                    </select>                        
                                </div>
                                <div class="col-md-3"><button id="btnEnviarCeu" type="submit" class="btn btn-primary">Baixar</button></div>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </li>
    <li class="list-group-item">
        <div class="panel panel-default panel-docente">
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapseExAlunos"  aria-controls="collapseExAlunos" 
                    aria-expanded="false" class="collapsed">
                    Planilha Ex Alunos
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            <div class="panel-body collapse in" id="collapseExAlunos">
                <ul class="list-group">
                    <li class="list-group-item">
                        <form action="/restrito/ex_alunos" method="GET">
                            <div class="row">
                                <div class="col-md-1">
                                    <label><b>Filtrar por:</b></label>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" aria-label="Default select example" name="nivel" id="nivel">
                                        <option selected value="">Nível</option>
                                            <option value="gr">Graduação</option>
                                            <option value="pgr">Pós-Graduação</option>
                                            <option value="me">Pós-Graduação (Mestrado)</option>
                                            <option value="do">Pós-Graduação (Doutorado)</option>
                                        <option value="1">Todos</option>
                                    </select>
                                </div>
                                <div class="col-md-3 curso-area d-none">
                                    <select class="form-control d-none" aria-label="Default select example" name="curso" id="curso">
                                        <option selected value="">Curso</option>
                                        @foreach($cursos as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                        <option value="1">Todos</option>
                                    </select>
                                    <select class="form-control d-none" aria-label="Default select example" name="area" id="area">
                                        <option selected value="">Área</option>
                                        @foreach($areas as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                        <option value="1">Todas</option>
                                    </select>
                                </div>
                                <div class="col-md-3"><button type="submit" class="btn btn-primary">Baixar</button></div>
                            </div>
                            <br>
                            <span>*O arquivo pode demorar a ser baixado devido a quantidade de alunos.</span>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </li>

    <li class="list-group-item">
        <div class="panel panel-default panel-docente">
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapseIntercambio"  aria-controls="collapseIntercambio" 
                    aria-expanded="false" class="collapsed">
                    Planilha Intercâmbio
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            <div class="panel-body collapse in" id="collapseIntercambio">
                <ul class="list-group">
                    <li class="list-group-item">
                        <form action="/restrito/intercambio" method="GET">
                            <div class="row">
                                <div class="col-md-1">
                                    <label><b>Filtrar por:</b></label>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" aria-label="Default select example" name="pessoa" id="pessoa" required>
                                        <option selected value="">Pessoa</option>
                                            <option value="alunos_estrangeiros">Alunos estrangeiros</option>
                                            <option value="alunos_intercambistas">Alunos intercambistas</option>
                                            <option value="docentes_estrangeiros">Docentes estranheiros</option>
                                    </select>
                                </div>
                                <div class="col-md-3 curso-setor d-none">
                                    <select class="form-control d-none" aria-label="Default select example" name="curso" id="curso">
                                        <option selected value="">Curso</option>
                                            @foreach($cursos as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        <option value="1">Todos</option>
                                    </select>
                                    <select class="form-control d-none" aria-label="Default select example" name="setor" id="setor">
                                        <option selected value="">Curso</option>
                                        <option value="'FLF'">Filosofia</option>
                                        <option value="'FLG'">Geografia</option>
                                        <option value="'FLH'">História</option>
                                        <option value="'FLA','FLP','FSL'">Ciências Sociais</option>
                                        <option value="'FLC','FLM','FLO','FLT','FLL'">Letras</option>
                                        <option value="1">Todos</option>
                                    </select>
                                </div>
                                <div class="col-md-2 d-none" id="ano">
                                        <select class="form-control" name="ano">
                                            <option selected value="">Ano</option>
                                                @for($ano = Date('Y'); $ano >= 2000; $ano--)
                                                <option value="{{$ano}}" @if(request()->ano == $ano) selected @endif>{{$ano}}</option>
                                            @endfor
                                        </select>                        
                                </div>
                                <div class="col-md-3"><button type="submit" class="btn btn-primary">Baixar</button></div>
                            </div>
                            <br>
                            <span>*O arquivo pode demorar a ser baixado devido a quantidade de alunos.</span>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </li>

    <li class="list-group-item">
        <div class="panel panel-default panel-docente">
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapseEvasao"  aria-controls="collapseEvasao" 
                    aria-expanded="false" class="collapsed">
                    Planilha Evasão Graduação
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            <div class="panel-body collapse in" id="collapseEvasao">
                <ul class="list-group">
                    <li class="list-group-item">
                        <form action="/restrito/evasao" method="GET">
                            <div class="row">
                                <div class="col-md-1">
                                    <label><b>Filtrar por:</b></label>
                                </div>
                                <div class="col-md-3 curso">
                                    <select class="form-control" aria-label="Default select example" name="curso" id="curso">
                                        <option selected value="">Curso</option>
                                            @foreach($cursos as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        <option value="1">Todos</option>
                                    </select>
                                </div>
                                <div class="col-md-2" id="ano">
                                        <select class="form-control" name="ano">
                                            <option selected value="">Ano</option>
                                                @for($ano = Date('Y'); $ano >= 2000; $ano--)
                                                <option value="{{$ano}}" @if(request()->ano == $ano) selected @endif>{{$ano}}</option>
                                            @endfor
                                        </select>                        
                                </div>
                                <div class="col-md-3"><button type="submit" class="btn btn-primary">Baixar</button></div>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </li>

    <li class="list-group-item">
        <div class="panel panel-default panel-docente">
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapseTransferencia"  aria-controls="collapseTransferencia" 
                    aria-expanded="false" class="collapsed">
                    Planilha Transferência Graduação
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            <div class="panel-body collapse in" id="collapseTransferencia">
                <ul class="list-group">
                    <li class="list-group-item">
                        <form action="/restrito/transferencia" method="GET">
                            <div class="row">
                                <div class="col-md-1">
                                    <label><b>Filtrar por:</b></label>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" aria-label="Default select example" name="tipo" id="tipo" required>
                                        <option selected value="">Tipo transferência</option>
                                            <option value="Transf USP">Transferência interna</option>
                                            <option value="Transf Externa">Transferência externa</option>
                                    </select>
                                </div>
                                <div class="col-md-3 curso">
                                    <select class="form-control" aria-label="Default select example" name="curso" id="curso">
                                        <option selected value="">Curso</option>
                                            @foreach($cursos as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        <option value="1">Todos</option>
                                    </select>
                            
                                </div>
                                <div class="col-md-2 " id="ano">
                                        <select class="form-control" name="ano">
                                            <option selected value="">Ano</option>
                                                @for($ano = Date('Y'); $ano >= 2000; $ano--)
                                                <option value="{{$ano}}" @if(request()->ano == $ano) selected @endif>{{$ano}}</option>
                                            @endfor
                                        </select>                        
                                </div>
                                <div class="col-md-3"><button type="submit" class="btn btn-primary">Baixar</button></div>
                            </div>
                            <br>
                            <span>*O arquivo pode demorar a ser baixado devido a quantidade de alunos.</span>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </li>

    <li class="list-group-item">
        <div class="panel panel-default panel-docente">
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapseBolsas"  aria-controls="collapseBolsas" 
                    aria-expanded="false" class="collapsed">
                    Planilha Bolsas Graduação
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            <div class="panel-body collapse in" id="collapseBolsas">
                <ul class="list-group">
                    <li class="list-group-item">
                        <form action="/restrito/bolsas" method="GET">
                            <div class="row">
                                <div class="col-md-1">
                                    <label><b>Filtrar por:</b></label>
                                </div>     
                                <div class="col-md-3 curso">
                                    <select class="form-control" aria-label="Default select example" name="curso" id="curso">
                                        <option selected value="">Curso</option>
                                            @foreach($cursos as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        <option value="1">Todos</option>
                                    </select>

                                </div>                                   
                                <div class="col-md-2 " id="ano">
                                        <select class="form-control" name="ano">
                                            <option selected value="">Ano</option>
                                                @for($ano = Date('Y'); $ano >= 2000; $ano--)
                                                <option value="{{$ano}}" @if(request()->ano == $ano) selected @endif>{{$ano}}</option>
                                            @endfor
                                        </select>                        
                                </div>
                                <div class="col-md-3"><button type="submit" class="btn btn-primary">Baixar</button></div>
                            </div>
                            <br>
                            <span>*O arquivo pode demorar a ser baixado.</span>
                          </form>
                    </li>
                </ul>
            </div>
        </div>
    </li>

</ul>



@endsection



<div id="loading" class="d-none loading">    
    <div id="spinner" class="spinner-border text-primary spinner"  role="status">
        <span class="sr-only">Loading...</span>
    </div>
    <span class="texto-ajuda">
        O arquivo pode demorar a ser baixado devido a quantidade de registros
    </span>
</div>

@section('javascripts_bottom')
  <script src="{{ asset('assets/js/restrito.js') }}"></script>

  <script type="text/javascript">
    $(document).ready(function () {
        $("form").submit(function (event) {
            event.preventDefault();

            $form = $(this);
            $action = $form.attr('action');

            var formData = {};
            $($form).find('input, textarea, select').each(function(){
                var name = $(this).attr('name'); 
                var value = $(this).val(); 
                formData[name] = value;
            }) ;

            
            $.ajax({
                type: "GET",
                enctype: 'multipart/form-data',
                url: $action,
                data: formData,
                xhrFields:{
                    responseType: 'blob'
                },
                beforeSend: function() {
                    $('#loading').removeClass('d-none');
                    $('#loading .texto-ajuda').addClass('animacao-demora-carregamento');
                },
                success: function(result) {
                    $('#loading').addClass('d-none');
                    $('#loading .texto-ajuda').removeClass('animacao-demora-carregamento');
                   
                    var blob = result;
                    var downloadUrl = URL.createObjectURL(blob);
                    var a = document.createElement("a");
                    a.href = downloadUrl;
                    a.download = "download-portal-dados.xls";
                    document.body.appendChild(a);
                    a.click();
                }

            
            });
        });
    });

  </script>

@endsection 
