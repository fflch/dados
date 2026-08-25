@extends('pedidos')

@section('content')

{!! $stepper !!}

@include('pedido.partials.tabela')

@endsection('content')