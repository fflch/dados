@extends('layouts.app')
@section('title', 'Portal de Dados - FFLCH')

@section('content')
<x-header />
<div class="itens-footer footer-dados">
    <p><b><span class="title">Responsáveis:</span></b><br>
    Nelson Alves Caetano <br>
    Thiago Gomes Veríssimo <br>
    </p>
    
    <p><b><span class="title">Estagiários:</span><br></b>
        Andre de Queiroz Patrinicola - andrepatrinicola@usp.br<br>
        Vinicius Fernandes Chagas - vinicius.chagas@usp.br<br>
        Felipe de Assis Mello - felipe_de_assis@usp.br 
    </p>


    <h5><b>Estamos localizados em:</h5></b>
    <p><span class="title">Edifício de Filosofia e Ciências Sociais - FFLCH-USP</span><br>
    Av. Prof. Luciano Gualberto, 315. <br>
    Butantã - São Paulo <br>
    <h5><b>Contato:</b></h5>
    Telefone: (11) 3091-4612<br></p>

    <!-- Adicione o código de incorporação do Google Maps aqui -->
    <div class="map-container">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3656.7175783061613!2d-46.73492168502115!3d-23.555856484683347!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce560f08d76cb5%3A0x60ec19f0d1b18aa!2sAv.%20Prof.%20Luciano%20Gualberto%2C%20315%20-%20Butant%C3%A3%2C%20S%C3%A3o%20Paulo%20-%20SP%2C%2005508-010%2C%20Brazil!5e0!3m2!1sen!2sus!4v1632750985739!5m2!1sen!2sus"
            width="600" 
            height="450" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy"></iframe>
    </div>
</div>
@endsection

<style>
.itens-footer {
    margin-top: 80px; /* Espaçamento adicional para garantir que o footer não sobreponha o header */
    margin-left:10px;
    margin-right:15px;
    padding: 20px;
    background-color: #f4f4f4;
    border-radius: 5px;
}

.map-container {
    margin-top: 20px; /* Espaçamento entre o mapa e o texto */
    text-align: center; /* Centraliza o mapa */
}

.map-container iframe {
    width: 100%; /* Ajusta a largura do mapa ao tamanho do container */
    height: 400px; /* Ajusta a altura do mapa */
    border: 0;
    border-radius: 5px; /* Bordas arredondadas para o mapa */
}
</style>