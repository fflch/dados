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
            'title' => 'Página Antiga',
            'items' => [
                ['name' => 'Página Antiga', 'url' => '/index'],
            ]
         ],

         
        
        [
            'title' => 'Dados de produção acadêmica', 
            'items' => [
                ['name' => 'Programas de Pós-Graduação (e por departamento)', 'url' => '/programas', 'api' => '/api/programas'], 
                ['name' => 'Defesas', 'url' => '/defesas', 'api' => '/api/defesas'], 
                ['name' => 'Pesquisa', 'url' => '/pesquisa?filtro=departamento', 'api' => '/api/pesquisa?filtro=departamento']
            ]
        ],

        
        [
            'title' => 'Dados institucionais', 
            'items' => [
                ['name' => 'Colegiados', 'url' => '/colegiados', 'api' => '/api/colegiados']
            ]
        ],
        [
            'title' => 'Dados gerais do portal', 
            'items' => [
                ['name' => 'Totais de pessoas com vínculos ativos.', 'url' => '/ativos'], 
                ['name' => 'Totais de microcomputadores e notebooks.', 'url' => '/ativosMicrosNotes'], 
                ['name' => 'Totais de convênios ativos.', 'url' => '/conveniosAtivos'], 
                ['name' => 'Totais de docentes contabilizados por função.', 'url' => '/ativosDocentesPorFuncao'], 
                ['name' => 'Totais de funcionários e professores ativos contabilizados por departamento.', 'url' => '/ativosDepartamento/Servidor/0'], 
                ['name' => 'Total de Ex Alunos da Graduação e da Pós-Graduação.', 'url' => '/exAlunos']
            ]
        ],
        [
            'title' => 'Dados por gênero', 
            'items' => [
                ['name' => 'Totais de ativos contabilizadas por gênero.', 'url' => '/ativosPorGenero?vinculo=ALUNOGR', 'api' => '/api/ativosPorGenero?vinculo=ALUNOGR']
            ]
        ],
        [
            'title' => 'Dados por curso', 
            'items' => [
                ['name' => 'Totais de alunos vínculos ativos, separados por curso.', 'url' => '/alunosAtivosPorCurso?tipvin=ALUNOGR', 'api' => '/api/alunosAtivosPorCurso?tipvin=ALUNOGR'], 
                ['name' => 'Total de concluintes da Graduação por curso.', 'url' => '/concluintesGradPorCurso/' . $lastYear], // Uso do ano calculado
                ['name' => 'Total de trancamentos por semestre dos cursos.', 'url' => '/trancamentosCursoPorSemestre']
            ]
        ],
        [
            'title' => 'Dados pós-graduação', 
            'items' => [
                ['name' => 'Totais de pessoas da Pós-Graduação, separadas por programa.', 'url' => '/ativosPorProgramaPos'], 
                ['name' => 'Quantidade de alunos ativos da pós-graduação por nível de programa.', 'url' => '/ativosPosNivelPgm'], 
                ['name' => 'Quantidade de orientadores credenciados na área de concentração do programa de pós graduação.', 'url' => '/orientadoresPosGR'], 
                ['name' => 'Quantidade de alunos especiais de pós-graduação ativos por departamento.', 'url' => '/alunosEspeciaisPosGrDpto']
            ]
        ],
        [
            'title' => 'Dados Graduação', 
            'items' => [
                ['name' => 'Disciplinas/Turmas oferecidas', 'url' => '#'] // Adicione o link apropriado
            ]
        ],
        [
            'title' => 'Dados por ano', 
            'items' => [
                ['name' => 'Série histórica de benefícios concedidos por ano.', 'url' => '#'], // Adicione o link apropriado
                ['name' => 'Série histórica: quantidade de alunos com benefícios 2010-2020.', 'url' => '#'], // Adicione o link apropriado
                ['name' => 'Série histórica de concluintes da Graduação e Pós-Graduação por ano.', 'url' => '#'], // Adicione o link apropriado
                ['name' => 'Quantidade de alunos de Graduação com benefícios (ativos) por ano.', 'url' => '#'], // Adicione o link apropriado
                ['name' => 'Quantidade de alunos especiais de pós-graduação ativos por departamento.', 'url' => '#'] // Adicione o link apropriado
            ]
        ]
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
                                            <img src="{{ asset('assets/img/json_icon.png') }}">
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
