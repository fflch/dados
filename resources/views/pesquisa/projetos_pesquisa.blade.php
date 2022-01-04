@extends('main')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/programas.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/jpswalsh/academicons@1/css/academicons.min.css">
@endsection('styles')

@section('content')

@include ('pesquisa.partials.return')

@if(isset($projetos_pesquisa))
<div class="card">
  <div class="card-header">
    @if(!empty($nome_departamento))
      <b>Projetos de pesquisa dos docentes do departamento de {{$nome_departamento}}</b>
    @else
      <b>Projetos de pesquisa dos docentes do curso de {{$nome_curso}}</b>
    @endif
  </div>
  <div class="card-body wrapper-pessoas-programa-table">
    <table class="table table-responsive pessoas-programa-table">
      <thead>
        <tr> 
          <th scope="col" class="first-col"><span class="text-first-col">Nome do Docente<span></th>
          <th scope="col" >Título da Projeto</th>
          <th scope="col" >Período de vigência</th>
        </tr>
      </thead>
      <tbody>
        @foreach($projetos_pesquisa as $pp)
        <tr>
        
          <td class="first-col">
            @if(isset($pp['nome_discente']) && $pp['nome_discente'] != null)
              {!! ($pp['nome_discente']) !!}
            @else
              -
            @endif
          </td>

          <td >
            @if(isset($pp['titulo_pesquisa']) && $pp['titulo_pesquisa'] != null)
              {!! ($pp['titulo_pesquisa']) !!} 
            @else
              -
            @endif
          </td>
          <td >
                @if(isset($pp['data_ini']) && $pp['data_ini'] != null)
                  {{ date("Y",strtotime($pp['data_ini'])) }} - 
                @if(isset($pp['data_fim']) && $pp['data_fim'] != null)
                  {{ date("Y",strtotime($pp['data_fim'])) }}
                @elseif(
                  (isset($pp['data_ini']) && $pp['data_ini'] != null)
                  && 
                  (!isset($pp['data_fim']) || $pp['data_fim'] == null)
                ) 
                  Atual
                @else
                -
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