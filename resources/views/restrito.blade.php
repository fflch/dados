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
                                <select class="form-control" aria-label="Default select example" name="departamento">
                                    <option selected value="">Departamento</option>
                                    @foreach($departamentos as $dpto)
                                        <option value="{{$dpto[0]}}">{{$dpto[1]}}</option>
                                    @endforeach
                                    <option value="1">Todos</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" name="ano_inicio">
                                    <option selected value="">Ano inicio</option>
                                    @for($ano = Date('Y'); $ano >= 2000; $ano--)
                                    <option value="{{$ano}}" @if(request()->ano == $ano) selected @endif>{{$ano}}</option>
                                    @endfor
                                </select>                        
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" name="ano_fim">
                                    <option selected value="">Ano fim</option>
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
                <h5 role="button" data-toggle="collapse" href="#collapseExAlunos"  aria-controls="collapseExAlunos" 
                    aria-expanded="false" class="collapsed">
                    Planilha Ex Alunos Graduação
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
                                    <select class="form-control" aria-label="Default select example" name="curso">
                                        <option selected value="">Curso</option>
                                        @foreach($cursos as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                        <option value="1">Todos</option>
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
</ul>



@endsection