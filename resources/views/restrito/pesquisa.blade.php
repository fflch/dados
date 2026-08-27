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
        @slot('titulo') Pós-doutorandos @endslot 
        @slot('nome')posdoc @endslot 
        @slot('ativo')posdoc @endslot 
        @slot('form')
            <form action="{{ route('planilha-pd') }}" id="form-alunos-pos" method="GET">
                <div class="row">
                    <div class="col-md-2">
                        <label><b>Filtrar por:</b></label>
                        @include('partials.check-filter',['filters' => [
                            'departamento' => 'Departamento',
                            'status' => 'Status',
                            'iniprj' => 'Início do projeto',
                            'fimprj' => 'Fim do projeto',
                        ]])
                    </div>
                    <div class="col-md-2">
                        <div id="filtro_departamento" style="display: none">
                            <label for="form_departamento">Departamento:<br/>
                            </label><select class="form-control" name="departamento" id="form_departamento" required disabled>
                                @foreach ($departamentos as $sigla => $dep)
                                    <option value="{{ $sigla }}"> {{$dep[1]}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="filtro_status" style="display: none">
                            <label for="form_status">Status:<br/>
                            </label><select class="form-control" name="status" id="form_status" required disabled>
                                @foreach ($status as $s)
                                    <option value="{{ $s }}"> {{$s}}</option>
                                @endforeach
                            </select>
                        </div> 
                        <div id="filtro_iniprj" style="display: none">
                            <label for="form_iniprj">Início do projeto após:<br/>
                            </label>
                            <input type="date" class="form-control " name="iniprj" id="form_iniprj" disabled/>
                        </div>   
                        <div id="filtro_fimprj" style="display: none">
                            <label for="form_fimprj">Fim do projeto até:<br/>
                            </label>
                            <input type="date" class="form-control " name="fimprj" id="form_fimprj" disabled/>
                        </div>   
                    </div>         
                    <div class="col-md-3"> 
                        <label><b>Selecionar Colunas:</b></label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="pd_col" id="check_pd_col">
                            <label class="form-check-label" for="check_pd_col">
                                CPF e Email do Pesquisador
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="sup_col" id="check_sup_col">
                            <label class="form-check-label" for="check_sup_col">
                                CPF e Email do Supervisor
                            </label>
                        </div>
                        
                    </div>                               
                    <div class="col-md-3"><button class="btn btn-primary" type="submit" id="baixar-alunospos">Baixar</button></div>
                </div>
                <br>
            </form>
            <br><span>*O arquivo pode demorar a ser baixado, não atulize a página.</span>
        @endslot 
    @endcomponent

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
    </script>
  @endsection
@endonce