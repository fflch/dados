@extends('laravel-usp-theme::master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/programas.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/jpswalsh/academicons@1/css/academicons.min.css">
@endsection('styles')

@section('content')


@if(isset($iniciacao_cientifica))
<div class="card">
  <div class="card-header">
    <b>Iniciações científicas do departameno de {{$nome_departamento}}</b>
  </div>
  <div class="card-body wrapper-pessoas-programa-table">
    <table class="table pessoas-programa-table">
      <thead>
        <tr>
          <th scope="col" class="first-col"><span class="text-first-col">Discente<span></th>
          <th scope="col" >Título da Pesquisa</th>
          <th scope="col" >Orientador</th>
          <th scope="col" >Período de vigência</th>
      
        </tr>
      </thead>
      <tbody>
        @foreach($iniciacao_cientifica as $ic)
        <tr>
        
          <td class="first-col">
              @if(isset($ic['nome_aluno']) && $ic['nome_aluno'] != null)
                {{$ic['nome_aluno']}}
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
              @if(isset($ic['nome_orientador']) && $ic['nome_orientador'] != null)
                {{$ic['nome_orientador']}}
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
                (isset($ic['ano_projeto']) && $ic['ano_projeto'] != null)
                )
                  {{$ic['ano_projeto']}}  
              @elseif(isset($ic['data_ini']) && $ic['data_ini'] != null)
                  {{ date("d/m/Y",strtotime($ic['data_ini'])) }} - 
                @if(isset($ic['data_fim']) && $ic['data_fim'] != null)
                  {{ date("d/m/Y",strtotime($ic['data_fim'])) }}
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