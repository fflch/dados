@extends('laravel-usp-theme::master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/programas.css') }}">
@endsection('styles')


@section('content')

<form id="formSearchPesquisa" method="index" action="/pesquisa" class="d-flex mb-3">
  <div class="filtro-select-div">
    <label for="filtro">Filtrar por:</label>
    <select name="filtro" id="filtro" class="mr-2">
      <option value="">Selecione</option>
      <option value="departamento" {{ $filtro == 'departamento' ? 'selected=selected' : ''}}>Departamentos</option>
      <option value="curso" {{ $filtro == 'curso' ? 'selected=selected' : ''}}>Cursos</option>
    </select>
  </div>
 
  <input type="submit" value="Buscar" class="btn btn-dark btn-send">
</form>


<div class="card">
  <div class="card-header">
    <b>Pesquisa:</b>
  </div>
  <div class="card-body">
    <table class="table docentes-programa-table">
      <thead>
        <tr>
          
          <th scope="col">{{ $filtro == 'departamento' ? 'Departamento' : 'Curso'}} </th>
          
          <th scope="col">IC (com bolsa)</th>
          <th scope="col" class="text-center">IC (sem bolsa)</th>
          
          
          <th scope="col" class="text-center">Pós-Doutorandos ativos (com bolsa)</th>
          <th scope="col" class="text-center">Pós-Doutorandos ativos (sem bolsa)</th>

          <th scope="col" class="text-center">Pesquisadores Colaboradores Ativos</th>
          <th scope="col" class="text-center">Projetos de Pesquisas dos Docentes</th>
        </tr>
      </thead>
      <tbody>
        @if($filtro == 'departamento' )
          @foreach ($departamentos as $key=>$item)
              <tr>
                <td>
                    {{ $item['nome_departamento'] }}
                </td>
                <td>
                    @if($item['ic'] > 0)
                      <a href="/iniciacao_cientifica?departamento={{$key}}">
                        {{$item['ic']}}
                      </a>
                    @else
                      0
                    @endif
                </td>
                <td>
                  @if($item['ic'] > 0)
                    <a href="/iniciacao_cientifica?departamento={{$key}}">
                      {{$item['ic']}}
                    </a>
                  @else
                    0
                  @endif
                </td>
                <td>
                    0
                </td>
                <td>
                    0
                </td>
                <td>
                    0
                </td>
                <td>
                    0
                </td>
              </tr>
            @endforeach
          @else
            <tr>
              <td>
                  XXXXXXXXXXXXXXX
              </td>
              <td>
                  0
              </td>
              <td>
                  0
              </td>
              <td>
                  0
              </td>
              <td>
                  0
              </td>
              <td>
                  0
              </td>
              <td>
                  0
              </td>
            </tr>
          @endif
       
      </tbody>
    </table>  
    

  </div>
</div>

@endsection('content')

