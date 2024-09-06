@extends('layouts.app')

@section('title', 'Página Inicial')

@section('content')
    <div class="container">
        <h1>Portal de Dados - FFLCH</h1>
    </div>

    <div class="sub-containers">
        <div class="sub-container">
            <h2>Subtítulo 1</h2>
            <img src="{{ asset('assets/img/destaque_cartilhas.png') }}" alt="Destaque Cartilhas">
        </div>
        <div class="sub-container">
            <h2>Subtítulo 2</h2>
            <img src="{{ asset('images/image2.jpg') }}" alt="Imagem 2">
        </div>
    </div>

    <div class="sub-containers">
        <div class="sub-container">
            <h2>Subtítulo 3</h2>
            <img src="{{ asset('images/image3.jpg') }}" alt="Imagem 3">
        </div>
        <div class="sub-container">
            <h2>Subtítulo 4</h2>
            <img src="{{ asset('images/image4.jpg') }}" alt="Imagem 4">
        </div>
    </div>
@endsection


<style>
    .container {
        background-color: #e0e0e0; /* Fundo cinza */
        padding: 20px;
        text-align: center;
        margin: 20px auto;
        width: 90%;
    }

    .sub-containers {
        display: flex;
        justify-content: space-around;
        margin-top: 20px;
        margin-bottom:40px;
    }

    .sub-container {
        background-color: #e0e0e0; /* Fundo cinza */
        padding: 20px;
        width: 40%;
        height:250px;
        text-align: center;
    }

    .sub-container img {
        max-width: 100%;
        height: auto;
        margin-top: 10px;
    }
</style>