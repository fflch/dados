@extends('laravel-usp-theme::master')

@section('content')

<div class="card">
    <div class="card-header"><b>Dados gerais do portal:</b></div>
    <div class="card-body">

        <ul class="list-group">
            <li class="list-group-item"><a href="/ativos">Totais de pessoas com vínculos ativos.</a></li>
            <li class="list-group-item"><a href="/ativosMicrosNotes">Totais de microcomputadores e notebooks.</a></li>
            <li class="list-group-item"><a href="/conveniosAtivos">Totais de convênios ativos.</a></li>
            <li class="list-group-item"><a href="/ativosDocentesPorFuncao">Totais de docentes contabilizados por
                    função.</a>
            </li>
            <li class="list-group-item"><a href="/ativosFuncionariosDepartamento">Totais de funcionários contabilizados
                    por
                    departamento.</a></li>
        </ul>

    </div>
</div>

<br>

<div class="card">
    <div class="card-header"><b>Dados por gênero:</b></div>
    <div class="card-body">

        <ul class="list-group">
            <li class="list-group-item"><a href="/ativosPGGrad">Totais de pessoas da Graduação contabilizadas por
                    gênero.</a>
            </li>
            <li class="list-group-item"><a href="/ativosPGPos">Totais de pessoas da Pós Graduação contabilizadas por
                    gênero.</a>
            </li>
            <li class="list-group-item"><a href="/ativosPGDocentes">Totais de docentes contabilizados por gênero.</a>
            </li>
            <li class="list-group-item"><a href="/ativosEstagiarios">Totais de estagiários contabilizados por
                    gênero.</a></li>
            <li class="list-group-item"><a href="/ativosFuncionarios">Totais de funcionários contabilizados por
                    gênero.</a></li>
            <li class="list-group-item"><a href="/ativosGradSociais">Totais de alunos da Graduação em Ciências Sociais
                    contabilizados por gênero.</a></li>
            <li class="list-group-item"><a href="/ativosGradFilosofia">Totais de alunos da Graduação em Filosofia
                    contabilizados
                    por gênero.</a></li>
            <li class="list-group-item"><a href="/ativosGradGeografia">Totais de alunos da Graduação em Geografia
                    contabilizados
                    por gênero.</a></li>
            <li class="list-group-item"><a href="/ativosGradHistoria">Totais de alunos da Graduação em História
                    contabilizados
                    por
                    gênero.</a></li>
            <li class="list-group-item"><a href="/ativosGradLetras">Totais de alunos da Graduação em Letras
                    contabilizados por
                    gênero.</a></li>
            <li class="list-group-item"><a href="/ativosCulturaExtensao">Totais de alunos de Cultura e Extensão
                    contabilizados
                    por
                    gênero.</a></li>
            <li class="list-group-item"><a href="/ativosPosDoutorado">Totais de alunos de Pós Doutorado contabilizados
                    por
                    gênero.</a></li>
            <li class="list-group-item"><a href="/ativosChefesAdministrativos">Totais de chefes administrativos
                    contabilizados
                    por
                    gênero.</a></li>
        </ul>

    </div>
</div>

<br>

<div class="card">
    <div class="card-header"><b>Dados por curso:</b></div>
    <div class="card-body">

        <ul class="list-group">
            <li class="list-group-item"><a href="/ativosPCGrad">Totais de pessoas da Graduação com vínculos ativos,
                    separadas
                    por
                    curso.</a></li>
            <li class="list-group-item"><a href="{{ route('ativosposdoutoradocurso') }}">Totais de alunos Pós-doutorando
                    ativos
                    por curso.</a></li>
            <li class="list-group-item"><a href="/concluintesGrad2014PorCurso">Total de concluintes da Graduação por
                    curso em
                    2014.</a></li>
            <li class="list-group-item"><a href="/concluintesGrad2015PorCurso">Total de concluintes da Graduação por
                    curso em
                    2015.</a></li>
            <li class="list-group-item"><a href="/concluintesGrad2016PorCurso">Total de concluintes da Graduação por
                    curso em
                    2016.</a></li>
            <li class="list-group-item"><a href="/concluintesGrad2017PorCurso">Total de concluintes da Graduação por
                    curso em
                    2017.</a></li>
            <li class="list-group-item"><a href="/concluintesGrad2018PorCurso">Total de concluintes da Graduação por
                    curso em
                    2018.</a></li>
            <li class="list-group-item"><a href="/concluintesGrad2019PorCurso">Total de concluintes da Graduação por
                    curso em
                    2019.</a></li>
            <li class="list-group-item"><a href="/ativosPorProgramaPos">Totais de pessoas da Pós-Graduação, separadas
                    por
                    programa.</a></li>
            <li class="list-group-item"><a href="/trancamentosSociaisPorSemestre">Total de trancamentos por semestre do
                    curso de
                    Ciências Sociais.</a></li>
            <li class="list-group-item"><a href="/trancamentosFilosofiaPorSemestre">Total de trancamentos por semestre
                    do curso
                    de
                    Filosofia.</a></li>
            <li class="list-group-item"><a href="/trancamentosGeografiaPorSemestre">Total de trancamentos por semestre
                    do curso
                    de
                    Geografia.</a></li>
            <li class="list-group-item"><a href="/trancamentosHistoriaPorSemestre">Total de trancamentos por semestre do
                    curso
                    de
                    História.</a></li>
            <li class="list-group-item"><a href="/trancamentosLetrasPorSemestre">Total de trancamentos por semestre do
                    curso de
                    Letras.</a></li>
        </ul>
    </div>
</div>

<br>

<div class="card">
    <div class="card-header"><b>Dados por ano:</b></div>
    <div class="card-body">

        <ul class="list-group">
            <li class="list-group-item"><a href="/ativosBeneficiosConHist">Série histórica de benefícios concedidos por
                    ano a
                    partir de 2014.</a></li>
            <li class="list-group-item"><a href="/beneficiados">Série histórica: quantidade de alunos com benefícios
                    2010-2020.</a></li>
            <li class="list-group-item"><a href="/concluintesGradPorAno">Série histórica de concluintes da Graduação por
                    ano a
                    partir de 2010.</a></li>
            <li class="list-group-item"><a href="/concluintesPosPorAno">Série histórica de concluintes da Pós-Graduação
                    por ano
                    a
                    partir de 2010.</a></li>
            <li class="list-group-item"><a href="/Benef2019Prog">Quantidade de benefícios concedidos em 2019 separados
                    por
                    programa.</a></li>
            <li class="list-group-item"><a href="/beneficiosAtivosGraduacao2020">Quantidade de alunos de Graduação com
                    benefícios
                    (ativos) em 2020.</a></li>
            <li class="list-group-item"><a href="/ativosBolsaLivro">Quantidade de alunos com o benefício Bolsa Livro
                    ativo em
                    2020.</a></li>
        </ul>
    </div>
</div>

<br>

<div class="card">
    <div class="card-header"><b>Dados por cor/raça:</b></div>
    <div class="card-body">

        <ul class="list-group">
            <li class="list-group-item"><a href="/autodeclaradosGradAtivos">Totais de alunos autodeclarados da Graduação
                    contabilizados por raça/cor.</a></li>
            <li class="list-group-item"><a href="/autodeclaradosPosAtivos">Totais de alunos autodeclarados da
                    Pós-Graduação
                    contabilizados por raça/cor.</a></li>
            <li class="list-group-item"><a href="/autodeclaradosCeuAtivos">Totais de alunos autodeclarados da Cultura e
                    Extensão
                    Universitária contabilizados por raça/cor.</a></li>
        </ul>

    </div>
</div>

<br>

<div class="card">
    <div class="card-header"><b>Dados por nacionalidade/localidade:</b></div>
    <div class="card-body">

        <ul class="list-group">
            <li class="list-group-item"><a href="/ativosGradPaisNasc">Totais de alunos brasileiros e estrangeiros da
                    Graduação.</a></li>
            <li class="list-group-item"><a href="/ativosPosPaisNasc">Totais de alunos brasileiros e estrangeiros da Pós
                    Graduação.</a></li>
            <li class="list-group-item"><a href="/ativosPDPaisNasc">Totais de alunos brasileiros e estrangeiros de Pós
                    Doutorado.</a></li>
            <li class="list-group-item"><a href="/ativosDocentesPaisNasc">Totais de docentes brasileiros e estrangeiros
                    da
                    FFLCH.</a></li>
            <li class="list-group-item"><a href="/ativosCeuPaisNasc">Totais de alunos brasileiros e estrangeiros de
                    Cultura e
                    Extensão Universitária.</a></li>
            <li class="list-group-item"><a href="/ativosAlunosEstado">Totais de alunos contabilizados por estados.</a>
            </li>

            <li class="list-group-item"><a href="/ativosDocentesPorFuncao">Totais de docentes contabilizados por
                    função.</a>
            </li>
            <li class="list-group-item"><a href="/ativosAlunosAutodeclarados">Totais de alunos autodeclarados.</a></li>

        </ul>
    </div>
</div>

<br>

<div class="card">
    <div class="card-header"><b>Dados por tipo de ingresso:</b></div>
    <div class="card-body">

        <ul class="list-group">
            <li class="list-group-item"><a href="/ativosAlunosGradTipoIngresso">Totais de alunos da Graduação por tipo
                    de
                    ingresso.</a></li>
        </ul>
        <ul class="list-group">
            <li class="list-group-item"><a href="/alunosEspeciaisPosGrAno">Série histórica: quantidade de alunos especiais 
            de pós-graduação (2010-2020)</a></li>
        </ul>
        <ul class="list-group">
            <li class="list-group-item"><a href="/alunosEspeciaisGrAno">Série histórica: quantidade de alunos especiais 
            de graduação (2010-2020)</a></li>
        </ul>
    </div>
    
</div>

@endsection