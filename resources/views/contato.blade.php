@extends('laravel-usp-theme::master')

@section('content')

<div class="itens-footer footer-dados">
    <h5><b>Estamos localizados em:</h5></b>
    <p><span class="title">Edifício de Filosofia e Ciências Sociais - FFLCH-USP</span><br>
    Av. Prof. Luciano Gualberto, 315. <br>
    Butantã - São Paulo <br>
    Telefone: (11) 3091-4612<br></p>

    <h5><b>Contato:</b></h5>
    <p><b><span class="title">Responsáveis:</span></b><br>
    Nelson Alves Caetano <br>
    Thiago Gomes Veríssimo <br>
    </p>
    
    <p><b><span class="title">Estagiários:</span><br></b>
       @foreach(App\Models\Pessoa::where('tipo_vinculo', 'Estagiario')->where('codset', 558)->get()->toArray() as $pessoa)
            {{ $pessoa['nompes'] }} - {{ $pessoa['email'] }} <br>
       @endforeach
    </p>
</div>

@endsection