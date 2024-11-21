@extends('main')

@section ('content')

<div class="container" style="margin-bottom:20px;">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header"><b>Equipe</b></div>
                    <div class="card-body">
                    <p>Nelson Alves Caetano</p>
                    <p>Cristiane Souza</p>
                    <p>Luciana Silveira</p>
                    <p>Gabriel Palma </p>
                    <p>Murilo Ialamov </p>
                       Luisa Terra
                </div>
                    <div class="card-header">
                        <h6>Contato: <a href="https://eaip.fflch.usp.br/fale_conosco" target="_blank">eaipfflch@usp.br</a></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('skin_footer')

<footer class="text-center text-white" style="background-color: #273e74;">
    <div class="row" style="padding:20px;">
        <div class="col-12">
        <p><strong>Escritório de Apoio Institucional ao Pesquisador (EAIP)</strong></p>
            <p><a style="color:white;" href="https://www.google.com/maps/place/R.+do+Lago,+717+-+Butant%C3%A3,+S%C3%A3o+Paulo+-+SP,+05508-080/@-23.56157,-46.729288,15z/data=!4m6!3m5!1s0x94ce56154e8ba55f:0x5ab8e74035633aea!8m2!3d-23.5615705!4d-46.7292883!16s%2Fg%2F11bw444z29?hl=pt-BR&entry=ttu&g_ep=EgoyMDI0MTEwNi4wIKXMDSoASAFQAw%3D%3D" 
            target="_blank" alt="maps"
            >Rua do Lago, 717 - Sala 116 - CEP: 05508-080 - São Paulo / SP</a></p>
            <p><strong>Fones: </strong>(11) 2648-1316, 2648-1590 e 3091-0400</p>
            <p><strong>Email: </strong><a style="color:white;" href="mailto:eaipfflch@usp.br">eaipfflch@usp.br</a></p>
            <p><strong>Horário de atendimento:</strong> 9h-11h e 13h30-16h.</p>
        </div>
    </div>
</footer>
@endsection
