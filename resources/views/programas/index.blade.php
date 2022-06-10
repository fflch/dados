@extends('main')

@section('styles')
@parent
    <link rel="stylesheet" href="{{ asset('assets/css/programas.css') }}">
@endsection('styles')


@section('flash')
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

  <div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(Session::has('alert-' . $msg))
        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
          <a href="#" class="close" data-dismiss="alert" aria-label="fechar">&times;</a>
        </p>
      @endif
    @endforeach
  </div>
  
@endsection


@section('content')


<div class="card">
  <div class="card-header">
    <b>Total de programas: {{count($programas)}}</b>

    <a href="{{ config('app.url') }}/api/programas" class="export-json"><span data-toggle="tooltip" data-placement="left" title="Exportar em JSON" role="button"><img src="{{ asset('assets/img/json_icon.png') }}"></span></a>
  </div>
  <div class="card-body table-responsive-sm">
    <table class="table docentes-programa-table">
      <thead>
        <tr>
          <th scope="col">Programa</th>
          <th scope="col" class="text-center">Docentes</th>
          <th scope="col" class="text-center">Discentes</th>
          <th scope="col" class="text-center">Egressos</th>
        </tr>
      </thead>
      <tbody>
        @foreach($programas as $programa)
        <tr>
          <td>
              {{$programa->nomare }} 
                       
           
          </td>
          <td class="text-center">
            <a href="/programas/docentes/{{$programa->codare}}">
              {{count($programa->docentes) }}
            </a>
          </td>
          <td class="text-center">
            <a href="/programas/discentes/{{$programa->codare}}">
              {{count($programa->discentes) }}
            </a>
          </td>
          <td class="text-center">
            <a href="/programas/egressos/{{$programa->codare}}">
              {{count($programa->egressos) }}
            </a>
          </td>
        </tr>
        
        @endforeach
       
      </tbody>
    </table>  
    

  </div>
  <div class="card-body table-responsive-sm">
    <table class="table docentes-departamento-table">
      <thead>
        <tr>
          <th scope="col">Departamento</th>
          <th scope="col" class="text-center">Docentes</th>
        </tr>
      </thead>
      <tbody>
        @foreach($departamentos as $departamento)
        <tr>
          <td>
              {{$departamento->nome }} 
                       
           
          </td>
          <td class="text-center">
            <a href="/programas/docentes/{{$departamento->sigla}}">
              {{$departamento->total_docentes }}
            </a>
          </td>
        </tr>
        
        @endforeach
       
      </tbody>
    </table>  
    

  </div>
</div>

@endsection('content')

