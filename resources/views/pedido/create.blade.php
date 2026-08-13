@extends('pedidos')
@section('content')
    <div class="row d-flex flex-column align-items-center">
        <h1>Gerar Solicitação de Dados</h1>
        <form action="/pedidos" method="post" class="w-50">
            @csrf
            @include('pedido.partials.form')
        </form>
    </div>
@endsection('content')