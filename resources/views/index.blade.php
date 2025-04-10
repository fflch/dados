@extends('main')

@section('content')

<div class="info-box" style="background: rgba(240, 240, 240, 0.5); padding: 20px; border-radius: 5px; text-align: center;">
    <h2>Bem-vindo ao Portal de Dados</h2>
    <p>O <strong>Portal de Dados</strong> surge a fim de disponibilizar ao público informações atualizadas em tempo real sobre a <strong>Faculdade de Filosofia, Letras e Ciências Humanas - FFLCH</strong>.</p>
    <p>Esta unidade abrange as áreas de <em>Filosofia, História, Geografia, Letras</em> e <em>Ciências Sociais</em> da Universidade de São Paulo.</p>
    <p>Os dados disponíveis podem ser acessados através do catálogo a seguir, organizado por categorias:</p>
    <br/>
</div>

<div class="accordion" id="accordionExample">
    @php
        $lastYear = date('Y') - 1; // Cálculo do último ano
    @endphp
    @foreach ([
        [
            'title' => 'Dados institucionais', 
            'items' => [
                ['name' => 'Colegiados', 'url' => '/colegiados', 'api' => '/api/colegiados']
            ]
        ],
    ] as $key => $section)
        <div class="card">
            <div class="card-header" id="heading{{ $key }}">
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{ $key }}" aria-expanded="true" aria-controls="collapse{{ $key }}">
                        <b>{{ $section['title'] }}: {{ count($section['items']) }}</b>
                    </button>
                </h2>
            </div>

            <div id="collapse{{ $key }}" class="collapse" aria-labelledby="heading{{ $key }}" data-parent="#accordionExample">
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($section['items'] as $item)
                            <li class="list-group-item">
                                <a href="{{ config('app.url') }}{{ $item['url'] }}">{{ $item['name'] }}</a>
                                @if(isset($item['api']))
                                    <a href="{{ config('app.url') }}{{ $item['api'] }}" class="export-json">
                                        <span data-toggle="tooltip" data-placement="left" title="Exportar em JSON" role="button">
                                            <img width="20" src="{{ asset('assets/img/json_icon.png') }}">
                                        </span>
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <br>
    @endforeach
</div>

@endsection
