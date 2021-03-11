@extends('laravel-usp-theme::master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/programas.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/jpswalsh/academicons@1/css/academicons.min.css">
@endsection('styles')

@section('content')


@if(isset($pesquisadores_colab))
<div class="card">
  <div class="card-header">
    <b>Pesquisadores colaboradores do departameno de {{$nome_departamento}}</b>
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
              @if(isset($pc['Pesquisador']) && $pc['Pesquisador'] != null)
                {{$pc['Pesquisador']}}
              @else
                -
              @endif
          </td>

          <td >
              @if(isset($pc['TituloPesquisa']) && $pc['TituloPesquisa'] != null)
                {!! $pc['TituloPesquisa'] !!}
              @else
                -
              @endif
          </td>

          <td >
              @if(isset($pc['Resposável']) && $pc['Resposável'] != null)
                {{$pc['Resposável']}}
              @else
                -
              @endif
          </td>

          <td >
            @if(isset($pc['Vigência']) && $pc['Vigência'] != null)
              {{$pc['Vigência']}}
            @else
              -
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