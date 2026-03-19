@extends('main')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/restrito.css') }}">
@endsection
@section('content')
@if ($errors->any())

    <div class="alert alert-danger">

        <ul>

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif
<ul class="list-group">
    @component('components.restrito-painel')
        @slot('titulo')Planilha Docentes @endslot 
        @slot('nome')Docentes @endslot 
        @isset($dataDocentes)
                @slot('ativo')ativo @endslot 
        @endisset
        @slot('form')
            <form action="{{ route('docentes-lista') }}" method="GET">
                <div class="row">
                    <div class="col-md-1">
                        <label><b>Filtrar por:</b></label>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="check_departamento" onchange="mostraFiltro(this,'departamento')">
                            <label class="form-check-label" for="check_departamento">
                                Departamento
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="check_status" onchange="mostraFiltro(this,'status')">
                            <label class="form-check-label" for="check_status">
                                Status
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="check_merito" onchange="mostraFiltro(this,'merito')">
                            <label class="form-check-label" for="check_merito">
                                Mérito
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="check_fimativ" onchange="mostraFiltro(this,'fimativ')">
                            <label class="form-check-label" for="check_fimativ">
                                Fim da Atividade
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="check_fimvin" onchange="mostraFiltro(this,'fimvin')">
                            <label class="form-check-label" for="check_fimvin">
                                Fim do Vínculo
                            </label>
                        </div>
                    </div>     
                    <div class="col-md-3">
                        <div id="filtro_departamento" style="display: none">
                            <label for="form_departamento">Departamento:<br/>
                            </label><select class="form-control select2" name="departamento[]" id="form_departamento" required multiple disabled>
                                @foreach ($departamentos as $sigla => $dep)
                                    <option value="{{ $sigla }}"> {{$dep[1]}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col" id="filtro_status" style="display: none">
                                <label for="form_status">Status:<br/>
                                </label><select class="form-control select2" name="status[]" id="form_status" required multiple disabled>
                                    @foreach ($status as $sigla => $nome)
                                        <option value="{{ $sigla }}"> {{$nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6" id="filtro_merito" style="display: none">
                                <label for="form_merito">Mérito:
                                </label>
                                <select class="form-control select2" name="merito[]" id="form_merito" required multiple disabled>
                                    @foreach ($meritos as $mer)
                                        <option value="{{ $mer }}"> {{$mer}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="filtro_fimativ" style="display: none">
                            <label for="form_fimativ">Fim da atividade Após:
                            </label><input type="date" class="form-control " name="fimativ" id="form_fimativ" disabled/>
                        </div>
                        <div id="filtro_fimvin" style="display: none">
                            <label for="form_fimvin">Fim do Vínculo Após:
                            </label><input type="date" class="form-control " name="fimvin" id="form_fimvin" disabled/>
                        </div>
                    </div>

                    <div class="col-md-3"><button type="submit" name="tabela" value="tabela" class="btn btn-primary">Visualizar</button></div>
                </div>
                <br>
            </form>
            
            @isset($dataDocentes)
                <div class="row justify-content-md-center m-3">
                    <a href="/restrito/docentes/planilha">
                        <button class="btn btn-primary">Download</button>
                    </a>
                </div>
                @include('partials.simple-table',['table_data' => $dataDocentes])
                
            @endisset
        @endslot 
        
    @endcomponent
    @component('components.restrito-painel')
        @slot('titulo')Planilha Cargo Docentes - Disciplinas @endslot 
        @slot('nome')doc-disciplinas @endslot 
        @isset($dataDisciplinas)
                @slot('ativo')ativo @endslot 
        @endisset
        @slot('form')
            <form action="{{ route('docentes-disciplinas') }}" method="GET">
                <div class="row">
                    <div class="col-md-1">
                        <label><b>Filtrar por:</b></label>
                    </div>    
                    <div class="col-md-3">
                        <div id="dis_departamento">
                            <label for="form_dis_departamento">Departamento:<br/>
                            </label><select class="form-control select2" name="departamento[]" id="form_dis_departamento" required multiple >
                                @foreach ($departamentos as $sigla => $dep)
                                    <option value="{{ $sigla }}"> {{$dep[1]}}</option>
                                @endforeach
                            </select>
                        </div>
                       <div class="row">
                            <div id="filtro_inidis" class="col">
                                <label for="form_inihor">Início do Período (Ano)
                                </label><input type="number" class="form-control " name="inidis" id="form_inidis" required/>
                            </div>
                            <div id="filtro_fimdis" class="col">
                                <label for="form_fimdis">Fim do Período (Ano)
                                </label><input type="number" class="form-control " name="fimdis" id="form_fimdis" required/>
                            </div>
                       </div>
                       <br><span>*A tabela pode demorar a carregar, não atulize a página.</span>
                    </div>

                    <div class="col-md-3"><button type="submit" class="btn btn-primary">Visualizar</button></div>
                </div>
                <br>
            </form>
            
            @isset($dataDisciplinas)
                <div class="row justify-content-md-center m-3">
                    <a href="{{ route('docentes-disciplinas-planilha') }}">
                        <button class="btn btn-primary">Download</button>
                    </a>
                </div>
                @include('partials.simple-table',['table_data' => $dataDisciplinas])
                
            @endisset
        @endslot 
        
    @endcomponent

</ul>

@endsection
@once
  @section('javascripts_bottom')
    @parent
    <script>
        function mostraFiltro(checkbox,nome) {
        let div = document.getElementById('filtro_'+nome)
        let form = document.getElementById('form_'+nome)
        if(checkbox.checked){
            div.style.display = 'block'
            form.removeAttribute("disabled");
        }else{
            div.style.display = 'none'
            form.setAttribute("disabled", "disabled");
        }
    }

        $(document).ready(function() {
            $( '.select2' ).select2( {
                closeOnSelect: false,
                placeholder: "Selecione", 
                allowClear: true
        } );});
    </script>
  @endsection
@endonce