@extends('layouts.app')

@section('title', 'Página Inicial')

@section('content')
<div class="container">
    <h1 class="titulo">Portal de Dados - FFLCH</h1>
</div>

<!-- Container da apresentação -->
<div class="presentation">
    <p class="text">
        O Portal de Dados surge a fim de disponibilizar ao público informações atualizadas em tempo real sobre a Faculdade de Filosofia, Letras e Ciências Humanas - FFLCH, unidade de ensino, pesquisa e extensão universitária que abrange as áreas de Filosofia, História, Geografia, Letras e Ciências Sociais da Universidade de São Paulo. Os dados disponíveis podem ser acessados através das opções ao lado, organizados por categorias
    </p>
</div>
    <div class="sub-containers">
        <x-box title="Subtítulo 1" image="{{ asset('assets/img/destaque_cartilhas.png') }}" alt="Destaque Cartilhas" />
        <x-box title="Subtítulo 2" image="{{ asset('images/image2.jpg') }}" alt="Imagem 2" />
    </div>

    <div class="sub-containers">

    <x-box title="Subtítulo 3" image="{{ asset('images/image3.jpg') }}" alt="Imagem 3" />
    <x-box title="Subtítulo 4" image="{{ asset('images/image4.jpg') }}" alt="Imagem 4" />

    </div>
@endsection

<style>
    .container {
        background-color: #052e70; /* Azul claro */
        padding: 15px;
        text-align: left;
        margin: 5px 0 0 5px; /* Pequeno espaçamento ao lado do sidebar */
        width: calc(100% - 80px); /* Ajustar largura para levar em consideração o sidebar */
        height:60px;
        position: absolute;
        top: 0;
        border-radius:5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .titulo {
        margin: 0;
        color: #FFFFFF;
        font-size: 42px;
    }

    .presentation {
    background-color: #FFFFFF; /* Fundo branco */
    width: calc(100% - 80px); /* Mesma largura do .container */
    margin: 70px 5px 20px 15px; /* Espaçamento ajustado */
    padding: 6px 8px; /* Reduzir o padding para diminuir a distância entre as letras e a borda */
    border-radius: 5px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* Sombra mais forte */
    font-size: 16px;
    line-height: 1.6;
}

    .text{
        font-size:17px;
        font-weight: bold;
        color:#052e70;
    }

    .sub-containers {
        display: flex;
        justify-content: space-around;
        margin-top: 30px;
        margin-bottom: 40px;
        margin-right:50px;
    }

</style>