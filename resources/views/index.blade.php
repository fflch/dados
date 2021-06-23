@extends('main')

@section('content')

<div class="card">
    <div class="card-header"><b></b></div>
    <div class="card-body">
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ config('app.url') }}/programas">Programas de Pós-Graduação</a></li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/defesas">Defesas</a></li>
            
            <li class="list-group-item"><a href="{{ config('app.url') }}/pesquisa?filtro=departamento">Pesquisa</a></li>
       </ul>
    </div>
</div>

<div class="card">
    <div class="card-header"><b>Dados gerais do portal: 7</b></div>
    <div class="card-body">
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ config('app.url') }}/ativos">Totais de pessoas com vínculos ativos.</a></li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/ativosMicrosNotes">Totais de microcomputadores e notebooks.</a></li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/conveniosAtivos">Totais de convênios ativos.</a></li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/ativosDocentesPorFuncao">Totais de docentes contabilizados por função.</a></li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/ativosDepartamento/Servidor/0">Totais de funcionários e professores (associados, doutores e titulares) ativos  contabilizados por departamento.</a></li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/ativosDocentesPorFuncao">Totais de docentes contabilizados por função.</a></li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/exAlunos">Total de Ex Alunos da Graduação e da Pós Graduação.</a></li>
        </ul>

    </div>
</div>

<br>

<div class="card">
    <div class="card-header"><b>Dados por gênero: 1</b></div>
    <div class="card-body">

        <ul class="list-group">
            <li class="list-group-item"><a href="{{ config('app.url') }}/ativosGenero/ALUNOGR0/0">Totais de ativos contabilizadas por
                    gênero.</a>
            </li>
        </ul>

    </div>
</div>

<br>

<div class="card">
    <div class="card-header"><b>Dados por curso: 3</b></div>
    <div class="card-body">

        <ul class="list-group">
           
            <li class="list-group-item"><a href="{{ config('app.url') }}/alunosAtivosPorCurso/ALUNOGR">Totais de alunos vínculos ativos,
                    separados por curso.</a></li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/concluintesGradPorCurso/{{date('Y') -1}}">Total de concluintes da Graduação por
                    curso.
                        </a></li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/trancamentosCursoPorSemestre/Letras">Total de trancamentos por semestre dos cursos.
                        </a></li>
        </ul>
    </div>
</div>

<br>

<div class="card">
    <div class="card-header"><b>Dados pós graduação: 4</b></div>
    <div class="card-body">
    <ul class="list-group">
        <li class="list-group-item"><a href="{{ config('app.url') }}/ativosPorProgramaPos">Totais de pessoas da Pós-Graduação, separadas por programa.</a></li>
        <li class="list-group-item"><a href="{{ config('app.url') }}/ativosPosNivelPgm">Quantidade de alunos ativos da pós-graduação por nível de programa.</a></li>
        <li class="list-group-item"><a href="{{ config('app.url') }}/orientadoresPosGR">Quantidade de orientadores credenciados na área de concentração do programa de pós graduação.</a></li>
        <li class="list-group-item"><a href="{{ config('app.url') }}/alunosEspeciaisPosGrDpto">Quantidade de alunos especiais 
            de pós-graduação ativos por departamento</a></li>
    </ul>
    </div>
</div>

<br>

<div class="card">
    <div class="card-header"><b>Dados por ano: 7</b></div>
    <div class="card-body">
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ config('app.url') }}/ativosBeneficiosConHist?ano_ini={{date('Y') - 5}}&ano_fim={{date('Y')}}">Série histórica de benefícios concedidos por
                    ano.</a></li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/beneficiados?ano_ini={{date('Y') - 5}}&ano_fim={{date('Y')}}">Série histórica: quantidade de alunos com benefícios
                    2010-2020.</a></li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/concluintesPorAno?vinculo=ALUNOGR&ano_ini={{date('Y') - 5}}&ano_fim={{date('Y')}}">Série histórica de concluintes da Graduação e Pós-Graduação por
                    ano.</a></li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/beneficiosAtivosGraduacaoPorAno/2021">Quantidade de alunos de Graduação com
                    benefícios
                    (ativos) por ano.</a></li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/alunosEspeciaisPorAno?vinculo=ALUNOESPGR&ano_ini={{date('Y') - 5}}&ano_fim={{date('Y')}}">Série histórica: quantidade de alunos especiais 
            de graduação e pós-graduação.</a></li>
        </ul>
    </div>
</div>

<br>

<div class="card">
    <div class="card-header"><b>Dados por cor/raça: 1</b></div>
    <div class="card-body">
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ config('app.url') }}/ativosAlunosAutodeclarados/ALUNOGR">Totais de alunos autodeclarados por raça/cor.</a></li>
        </ul>
    </div>
</div>

<br>

<div class="card">
    <div class="card-header"><b>Dados por nacionalidade/localidade: 2</b></div>
    <div class="card-body">
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ config('app.url') }}/ativosPaisNascimento/2">Totais de alunos e docentes brasileiros e estrangeiros ativos.</a></li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/ativosAlunosEstado">Totais de alunos contabilizados por estados.</a></li>
        </ul>
    </div>
</div>

<br>

<div class="card">
    <div class="card-header"><b>Dados por ingresso: 2</b></div>
    <div class="card-body">
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ config('app.url') }}/ativosAlunosGradTipoIngresso">Totais de alunos da Graduação por tipo de ingresso.</a></li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/IngressantesGeneroCurso?curso=Letras&ano_ini={{date('Y') - 5}}&ano_fim={{date('Y')}}">Série histórica: Ingressantes da graduação por curso, gênero e ano</a></li>
        </ul>
    </div>
    
</div>

@endsection