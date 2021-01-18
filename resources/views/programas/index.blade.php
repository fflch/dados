@extends('laravel-usp-theme::master')

@section('content')


<div class="card">
  <div class="card-header"><b>Total de programas: {{count($programas)}}</b></div>
  <div class="card-body">

      <ul class="list-group">
        @foreach($programas as $programa)
          <li class="list-group-item">
            <a href="/programas/{{$programa['codare']}}">{{$programa['codare']}}  - {{$programa['nomcur']}} </a>
          </li>
        @endforeach
      </ul>
  </div>
</div>



@endsection('content')

