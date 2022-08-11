@extends('main')


@section('styles')
@parent
    <link rel="stylesheet" href="{{ asset('assets/css/programas.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/jpswalsh/academicons@1/css/academicons.min.css">
@endsection('styles')

@section('content')

@include ('pesquisa.partials.return')

<br>
@include ('pesquisa.partials.search')


@if(isset($pesquisas_pos_doutorando))
<div class="card">
  <div class="card-header">
    @if(!empty($nome_departamento))
      <b>Pesquisas de pós doutorado do departamento de {{$nome_departamento}} </b>
    @else
      <b>Pesquisas de pós doutorado do curso de {{$nome_curso}}</b>
    @endif
    <a href="{{ config('app.url') }}/api/pesquisa/pos_doutorandos?departamento={{request()->get('departamento')}}&bolsa={{request()->get('bolsa')}}&curso={{request()->get('curso')}}&export=false&tipo={{request()->get('tipo')}}&ano={{request()->get('ano')}}&ano_ini={{request()->get('ano_ini')}}&ano_fim={{request()->get('ano_fim')}}" class="export-json"><span data-toggle="tooltip" data-placement="left" title="Exportar em JSON" role="button"><img src="{{ asset('assets/img/json_icon.png') }}"></span></a>
  </div>
  <div class="card-body wrapper-pessoas-programa-table">
    <table class="table table-responsive  pessoas-programa-table">
      <thead>
        <tr>
          <th scope="col" class="first-col"><span class="text-first-col">Nome<span></th>
          <th scope="col" >Título da Pesquisa</th>
          <th scope="col" >Responsável</th>
          <th scope="col" >Período de vigência</th>
        </tr>
      </thead>
      <tbody>
        @foreach($pesquisas_pos_doutorando as $pd)
        <tr>
        
          <td class="first-col">
            @if(isset($pd['nome_discente']) && $pd['nome_discente'] != null)
              {{$pd['nome_discente']}}
            @else
              -
            @endif
          </td>

          <td >
            @if(isset($pd['titulo_pesquisa']) && $pd['titulo_pesquisa'] != null)
              {!! $pd['titulo_pesquisa'] !!}
            @else
              -
            @endif
          </td>

          <td >
            @if(isset($pd['nome_supervisor']) && $pd['nome_supervisor'] != null)
              {{$pd['nome_supervisor']}}
            @else
              -
            @endif
          </td>

          <td >
              @if(
                (!isset($pd['data_ini']) || $pd['data_ini'] == null)
                &&
                (!isset($pd['data_fim']) || $pd['data_fim'] == null)
                &&
                (isset($pd['ano_proj']) && $pd['ano_proj'] != null)
                )
                  {{$pd['ano_proj']}}  
                @elseif(isset($pd['data_ini']) && $pd['data_ini'] != null)
                  {{ date("d/m/Y",strtotime($pd['data_ini'])) }} - 
                @if(isset($pd['data_fim']) && $pd['data_fim'] != null)
                  {{ date("d/m/Y",strtotime($pd['data_fim'])) }}
                @else 
                  atual
                @endif
              @endif
            
          </td>
          
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