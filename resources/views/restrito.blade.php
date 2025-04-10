@extends('main')

@section('content')

<ul class="list-group">

<li class="list-group-item">
        <div class="panel panel-default panel-docente">
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapseEstagiarios"  aria-controls="collapseEstagiarios" 
                    aria-expanded="false" class="collapsed">
                    Planilha Estagiários
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            <div class="panel-body collapse in" id="collapseEstagiarios">
                <ul class="list-group">
                    <li class="list-group-item">
                        <form action="/restrito/estagiarios" method="GET">
                            <div class="row">
                                <div class="col-md-1">
                                    <label><b>Filtrar por:</b></label>
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
                            <br>
                            <span>*O arquivo pode demorar a ser baixado.</span>
                          </form>
                    </li>
                </ul>
            </div>
        </div>
    </li>


</ul>

@endsection('content')



