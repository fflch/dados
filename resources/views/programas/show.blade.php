@extends('laravel-usp-theme::master')

@section('content')

<ul>
@foreach($credenciados as $credenciado)
  <li>{{$credenciado['nompes']}}</li>
@endforeach
</ul>

@endsection('content')

