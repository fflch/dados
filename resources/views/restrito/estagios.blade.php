@extends('main')

@section('content')

<ul class="list-group">
    @component('components.restrito-painel')
        @slot('titulo')Planilha Estagiários @endslot 
        @slot('nome')Estagiarios @endslot 
        @slot('form')
            <form action="{{ route('estagiarios') }}" method="GET">
                <div class="row">
                    <div class="col-md-1">
                        <label><b>Filtrar por:</b></label>
                    </div>     
                    <div class="col-md-2" id="ano">
                        <select class="form-control" name="ano">
                            <option selected value="">Ano</option>
                            @for($ano = date('Y'); $ano >= 2000; $ano--)
                                <option value="{{$ano}}" @if(request()->ano == $ano) selected @endif>{{$ano}}</option>
                            @endfor
                        </select>                        
                    </div>                                   
                    <div class="col-md-3"><button type="submit" class="btn btn-primary">Baixar</button></div>
                </div>
                <br>
                <span>*O arquivo pode demorar a ser baixado.</span>
            </form>
        @endslot 
    @endcomponent

</ul>

@endsection