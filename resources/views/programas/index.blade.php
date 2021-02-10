@extends('laravel-usp-theme::master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/programas.css') }}">
@endsection('styles')


@section('content')


<div class="card">
  <div class="card-header"><b>Total de programas: {{count($programas)}}</b></div>
  <div class="card-body">

      <ul class="list-group">
        @foreach($programas as $programa)
          <li class="list-group-item">
            {{ $programa->nomcur }} - 
            <a href="/programas/{{$programa->codare}}"> {{$programa->docentes }} docentes -
            {{$programa->discentes }} discentes </a>
          </li>
        @endforeach
      </ul>
  </div>
</div>



@endsection('content')

