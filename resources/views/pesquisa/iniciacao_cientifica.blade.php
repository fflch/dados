@extends('main')

@section('styles')
@parent
    <link rel="stylesheet" href="{{ asset('assets/css/programas.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/jpswalsh/academicons@1/css/academicons.min.css">
@endsection

@section('content')






<div>
  
  @include ('pesquisa.partials.return')

  <a class="float-right btn-voltar" href="/pesquisa/iniciacao_cientifica?departamento={{request()->get('departamento')}}&curso={{request()->get('curso')}}&bolsa={{request()->get('bolsa')}}&tipo={{request()->get('tipo')}}&ano={{request()->get('ano')}}&ano_ini={{request()->get('ano_ini')}}&ano_fim={{request()->get('ano_fim')}}&export=true" >
    <i class="fas fa-file-excel"></i> Download Excel</a> 



</div>
<br>
@include ('pesquisa.partials.search')



@if(isset($iniciacao_cientifica))
<div class="card">
  <div class="card-header">
    @if(!empty($nome_departamento))
      <b>Iniciações científicas do departamento de {{$nome_departamento}}</b>
    @else
      <b>Iniciações científicas do curso de {{$nome_curso}}</b>
    @endif
    <a href="{{ config('app.url') }}/api/pesquisa/iniciacao_cientifica?departamento={{request()->get('departamento')}}&curso={{request()->get('curso')}}&bolsa={{ request()->get('bolsa') }}&export=false&tipo={{request()->get('tipo')}}&ano={{ request()->get('ano')}}&ano_ini={{ request()->get('ano_ini')}}&ano_fim={{ request()->get('ano_fim')}}" class="export-json"><span data-toggle="tooltip" data-placement="left" title="Exportar em JSON" role="button"><img src="{{ asset('assets/img/json_icon.png') }}"></span></a>

  </div>
  <div class="card-body wrapper-pessoas-programa-table">
    <table class="table table-responsive pessoas-programa-table">
      <thead>
        <tr>
          <th scope="col" class="first-col"><span class="text-first-col">Discente<span></th>
          <th scope="col" >Título da Pesquisa</th>
          <th scope="col" >Orientador</th>
          <th scope="col" >Período de vigência</th>
          @if(request()->get('tipo') != 'ativo' )
          <th scope="col" >Situação</th>
          @endif
      
        </tr>
      </thead>
      <tbody>
        @foreach($iniciacao_cientifica as $ic)
        <tr>
        
          <td class="first-col">
              @if(isset($ic['nome_discente']) && $ic['nome_discente'] != null)
                {{$ic['nome_discente']}}
              @else
                -
              @endif
          </td>

          <td >
              @if(isset($ic['titulo_pesquisa']) && $ic['titulo_pesquisa'] != null)
                {!! $ic['titulo_pesquisa'] !!}
              @else
                -
              @endif
          </td>

          <td >
              @if(isset($ic['nome_supervisor']) && $ic['nome_supervisor'] != null)
                {{$ic['nome_supervisor']}}
              @else
                -
              @endif
          </td>

          <td >
              @if(
                (!isset($ic['data_ini']) || $ic['data_ini'] == null)
                &&
                (!isset($ic['data_fim']) || $ic['data_fim'] == null)
                &&
                (isset($ic['ano_proj']) && $ic['ano_proj'] != null)
                )
                  {{$ic['ano_proj']}}  
              @elseif(isset($ic['data_ini']) && $ic['data_ini'] != null)
                  {{ date("d/m/Y",strtotime($ic['data_ini'])) }} - 
                @if(isset($ic['data_fim']) && $ic['data_fim'] != null)
                  {{ date("d/m/Y",strtotime($ic['data_fim'])) }}
                @else 
                  atual
                @endif
              @endif
          </td>

          @if(request()->get('tipo') != 'ativo' )
            <td >
              @if(isset($ic['status_projeto']) && $ic['status_projeto'] != null)
                {{$ic['status_projeto']}}
              @else
                -
              @endif
            </td>
          @endif
          
        </tr>
        @endforeach
       
      </tbody>
    </table>  
    

  </div>
</div>
@endif 

@endsection('content')

@section('javascripts_bottom')
  <script src="{{ asset('assets/js/programas.js') }}"></script>
@endsection 

