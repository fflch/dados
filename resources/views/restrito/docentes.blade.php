@extends('main')

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
        @slot('form')
            <form action="/restrito/docentes" method="GET">
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
                            <label for="form_departamento">departamento:<br/>
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