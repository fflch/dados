@extends('main')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/restrito.css') }}">
@endsection
@section('content')

<ul class="list-group">

    {{-- Painel Estagiários --}}
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
                    </li>
                </ul>
            </div>
        </div>
    </li>

    {{-- Painel Intercambistas --}}
    <li class="list-group-item">
        <div class="panel panel-default panel-docente">
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapseIntercambistas" aria-controls="collapseIntercambistas" 
                    aria-expanded="false" class="collapsed">
                    Planilha Intercambistas
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            <div class="panel-body collapse in" id="collapseIntercambistas">
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="restrito/intercambitas/recebidos" class="btn btn-primary">Baixar</a>
                        <br><br>
                        <span>Lista com todos os intercambistas recebidos na fflch, tanto graduação quanto pós-graduação. Fonte: Mundus</span>
                        <br><span>*O arquivo pode demorar a ser baixado.</span>
                    </li>
                </ul>
            </div>
        </div>
    </li>
    <li class="list-group-item">
        <div class="panel panel-default panel-docente">
            <div class="panel-heading">
                <h5 role="button" data-toggle="collapse" href="#collapseBolsasPosgr" aria-controls="collapseBolsasPosgr" 
                    aria-expanded="false" class="collapsed">
                    Alunos - Pós-graduação (Eleição)
                    <span class="controller-collapse">
                        <i class="fas fa-plus-square"></i>
                        <i class="fas fa-minus-square"></i>  
                    </span>
                </h5>
            </div>
            <div class="panel-body collapse in" id="collapseBolsasPosgr">
                <ul class="list-group">
                    <li class="list-group-item">
                        <form action="/restrito/alunospos" id="form-alunos-pos" method="GET">
                            <div class="row">
                                <div class="col-md-1">
                                    <label><b>Filtrar por:</b></label>
                                </div>
                                <div class="col-md-3" id="programa">
                                    <label for="select-programas">Programas:</label>
                                    <select class="select2" id="select-programas" name="programas[]" onchange="programaUnico(this)" required multiple>
                                        @foreach ($programas as $cod => $nome)
                                            <option value="{{$cod}}">{{$nome}}</option>
                                        @endforeach
                                    </select>       
                                    <input type="checkbox" id="todosprogramas" name="todosprogramas" value="todos" onchange="checkProgramas(this)">
                                    <label for="todosprogramas"> Todos os programas</label>  <br/>  
                                    <label for="check-programas-junto"> 
                                        <input type="checkbox" id="check-programas-junto" name="junto" value="junto">
                                        Programas no mesmo arquivo</label>   
                                    @foreach ($programas as $cod => $nome)
                                        <input type="hidden" name="programas[]" value="{{ $cod }}" class="hprog"  disabled>   
                                    @endforeach        
                                </div>    
                                <div class="col-md-2"> 
                                    <input type="checkbox" id="header" name="header" value="header">
                                    <label for="header">Cabeçalho na primeira linha</label>
                                </div>        
                                <div class="col-md-1"> 
                                    <label for="header">Tipo de arquivo:</label><br>
                                    <input type="radio" name="tipo" value="csv" required checked> <label>.CSV</label><br>
                                    <input type="radio" name="tipo" value="xlsx">  <label>.XLSX</label>
                                </div>                               
                                <div class="col-md-3"><button class="btn btn-primary" type="submit" id="baixar-alunospos">Baixar</button></div>
                            </div>
                            <br>
                        </form>
                        <br><span>*O arquivo pode demorar a ser baixado, não atulize a página.</span>
                    </li>
                </ul>
            </div>
        </div>
    </li>

</ul>

@endsection

@section('javascripts_bottom')
<script>
    function checkProgramas(checkbox) {
        let hiddens = Array.from(document.getElementsByClassName("hprog")) 
        if(checkbox.checked){
            document.getElementById("select-programas").setAttribute("disabled", "disabled");
            hiddens.forEach(element => {
                element.removeAttribute("disabled");
            });
        }else{
            document.getElementById("select-programas").removeAttribute("disabled");
            hiddens.forEach(element => {
                element.setAttribute("disabled", "disabled");
            });
        }
    }
    function programaUnico(select) {
        let check = document.getElementById('check-programas-junto')
        if (select.selectedOptions.length ==1) {
            check.checked = false
            check.setAttribute("disabled", "disabled");
            //check.style.visibility = 'hidden'
        }
        else{
            check.removeAttribute("disabled");
            //check.style.visibility = 'visible'

        }
    }
    $(document).ready(function() {
        $( '#select-programas' ).select2( {
            closeOnSelect: false,
            placeholder: "Selecione", 
            allowClear: true
        } );
});
    


</script>
@endsection