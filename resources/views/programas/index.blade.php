@extends('laravel-usp-theme::master')

@section('content')

<ul>
@foreach($programas as $programa)
  <li><a href="/programas/{{$programa['codare']}}">{{$programa['codare']}}  - {{$programa['nomcur']}} </a></li>
@endforeach
</ul>

@endsection('content')

