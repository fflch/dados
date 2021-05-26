@extends('laravel-usp-theme::master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/programas.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/jpswalsh/academicons@1/css/academicons.min.css">
@endsection('styles')

@section('content')

@include ('pesquisa.partials.return')


@if(isset($pesquisadores_colab))
<div class="card">
  <div class="card-header">
    @if(!empty($nome_departamento))
      <b>Pesquisadores colaboradores do departameno de {{$nome_departamento}}</b>
    @else
      <b>Pesquisadores colaboradores do curso de {{$nome_curso}}</b>
    @endif
  </div>
  <div class="card-body wrapper-pessoas-programa-table">
    <table class="table pessoas-programa-table">
      <thead>
        <tr>
          <th scope="col" class="first-col"><span class="text-first-col">Nome<span></th>
          <th scope="col" >Título da Pesquisa</th>
          <th scope="col" >Responsável</th>
          <th scope="col" >Período de vigência</th>
        </tr>
      </thead>
      <tbody>
        @foreach($pesquisadores_colab as $pc)
        <tr>
        
          <td class="first-col">
            @if(isset($pc['nome_discente']) && $pc['nome_discente'] != null)
              {{$pc['nome_discente']}}
            @else
              -
            @endif
          </td>

          <td >
            @if(isset($pc['titulo_pesquisa']) && $pc['titulo_pesquisa'] != null)
              {!! $pc['titulo_pesquisa'] !!}
            @else
              -
            @endif
          </td>

          <td >
            @if(isset($pc['nome_supervisor']) && $pc['nome_supervisor'] != null)
              {{$pc['nome_supervisor']}}
            @else
              -
            @endif
          </td>

          <td >
              @if(
                (!isset($pc['data_ini']) || $pc['data_ini'] == null)
                &&
                (!isset($pc['data_fim']) || $pc['data_fim'] == null)
                &&
                (isset($pc['ano_proj']) && $pc['ano_proj'] != null)
                )
                  {{$pc['ano_proj']}}  
                @elseif(isset($pc['data_ini']) && $pc['data_ini'] != null)
                  {{ date("d/m/Y",strtotime($pc['data_ini'])) }} - 
                @if(isset($pc['data_fim']) && $pc['data_fim'] != null)
                  {{ date("d/m/Y",strtotime($pc['data_fim'])) }}
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