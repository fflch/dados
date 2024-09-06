<div class="sidebar">
<img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="sidebar-logo">
    <ul>
        <li><a href="{{ url('/') }}">Início</a></li>
        <li><a href="{{ url('/index') }}">Index antigo</a></li>
        <li>
            <a href="#" class="expandable" id="dadosProducaoAcademica">Produção acadêmica</a>
            <ul class="submenu" id="submenuDadosProducaoAcademica">
                <li><a href="{{ url('/programaPosGraduacao') }}">Programa de Pós-Graduação</a></li>
                <li><a href="{{ url('/defesas') }}">Defesas</a></li>
                <li><a href="{{ url('/pesquisa') }}">Pesquisa</a></li>
            </ul>
        </li>
        <li>
            <a href="#" class="expandable" id="dadosInstitucionais">Institucional</a>
            <ul class="submenu" id="submenuDadosInstitucionais">
                <li><a href="{{ url('/colegiados') }}">Colegiados</a></li>
            </ul>
        </li>
        <li>
            <a href="#" class="expandable" id="dadosPorCurso">Dados por curso</a>
            <ul class="submenu" id="submenuDadosPorCurso">
                <li><a href="{{ url('/totalAlunosVinculosAtivos') }}">Totais de alunos vínculos ativos, separados por curso</a></li>
                <li><a href="{{ url('/totalConcluintes') }}">Total de concluintes da Graduação por curso</a></li>
                <li><a href="{{ url('/totalTrancamentos') }}">Total de trancamentos por semestre dos cursos</a></li>
            </ul>
        </li>
        <li>
            <a href="#" class="expandable" id="dadosPosGraduacao">Pós-graduação</a>
            <ul class="submenu" id="submenuDadosPosGraduacao">
                <li><a href="{{ url('/totalPessoasPosGraduacao') }}">Totais de pessoas da Pós-Graduação, separadas por programa</a></li>
                <li><a href="{{ url('/alunosAtivosPosGraduacao') }}">Quantidade de alunos ativos da pós-graduação por nível de programa</a></li>
                <li><a href="{{ url('/orientadoresCredenciados') }}">Quantidade de orientadores credenciados na área de concentração do programa de pós-graduação</a></li>
                <li><a href="{{ url('/alunosEspeciaisPosGraduacao') }}">Quantidade de alunos especiais de pós-graduação ativos por departamento</a></li>
            </ul>
        </li>
        <li>
            <a href="#" class="expandable" id="dadosGraduacao">Graduação</a>
            <ul class="submenu" id="submenuDadosGraduacao">
                <li><a href="{{ url('/disciplinasTurmasOferecidas') }}">Disciplinas/Turmas oferecidas</a></li>
            </ul>
        </li>
        <li>
            <a href="#" class="expandable" id="dadosPorAno">Dados por ano</a>
            <ul class="submenu" id="submenuDadosPorAno">
                <li><a href="{{ url('/beneficiosPorAno') }}">Série histórica de benefícios concedidos por ano</a></li>
                <li><a href="{{ url('/alunosComBeneficios') }}">Série histórica: quantidade de alunos com benefícios 2010-2020</a></li>
                <li><a href="{{ url('/concluintesPorAno') }}">Série histórica de concluintes da Graduação e Pós-Graduação por ano</a></li>
                <li><a href="{{ url('/alunosBeneficiosAtivos') }}">Quantidade de alunos de Graduação com benefícios (ativos) por ano</a></li>
                <li><a href="{{ url('/alunosEspeciaisHistorico') }}">Série histórica: quantidade de alunos especiais de graduação e pós-graduação</a></li>
            </ul>
        </li>
        <li>
            <a href="#" class="expandable" id="dadosPorCorRaca">Dados por cor/raça</a>
            <ul class="submenu" id="submenuDadosPorCorRaca">
                <li><a href="{{ url('/alunosPorRacaCor') }}">Totais de alunos autodeclarados por raça/cor</a></li>
            </ul>
        </li>
        <li>
            <a href="#" class="expandable" id="dadosPorNacionalidadeLocalidade">Dados por nacionalidade/localidade</a>
            <ul class="submenu" id="submenuDadosPorNacionalidadeLocalidade">
                <li><a href="{{ url('/alunosDocentesBrasileirosEstrangeiros') }}">Totais de alunos e docentes brasileiros e estrangeiros ativos</a></li>
                <li><a href="{{ url('/alunosPorEstados') }}">Totais de alunos contabilizados por estados</a></li>
            </ul>
        </li>
        <li>
            <a href="#" class="expandable" id="dadosPorIngresso">Dados por ingresso</a>
            <ul class="submenu" id="submenuDadosPorIngresso">
                <li><a href="{{ url('/alunosPorTipoIngresso') }}">Totais de alunos da Graduação por tipo de ingresso</a></li>
                <li><a href="{{ url('/ingressantesGraduacao') }}">Série histórica: Ingressantes da graduação por curso, gênero e ano</a></li>
                <li><a href="{{ url('/ingressantesPosGraduacao') }}">Série histórica: Ingressantes da pós-graduação por programa, gênero e ano</a></li>
            </ul>
        </li>
        <li><a href="{{ url('/contato') }}">Contato</a></li>
    </ul>
</div>

<script src="{{ asset('assets/js/sidebar.js') }}"></script>

<style>
    .sidebar {
        width: 250px;
        height: 100vh; /* Ocupa toda a altura da página */
        background-color: #052e70;
        padding: 15px;
        padding-right: 30px; /* Adiciona espaçamento à direita da sidebar */
        position: fixed; /* Fixa a sidebar na lateral da página */
        top: 0;
        left: 0;
        overflow-y: auto; /* Adiciona rolagem se o conteúdo exceder a altura */
        z-index: 1000; /* Garante que a sidebar fique acima do conteúdo */
    }

    .sidebar-logo {
        display: block;
        max-width: 80%; /* Garante que a imagem se ajuste à largura da sidebar */
        height: auto;
        margin-bottom: 6px; /* Espaçamento entre a imagem e a lista */
        margin-left: 14px;
        filter: brightness(0) invert(1); /* Torna a imagem branca */
    }

    .sidebar ul {
        list-style-type: none;
        padding: 0;
        margin-top:30px;
    }

    .sidebar ul li {
        margin-bottom: 10px;
        position: relative;
    }

    .sidebar ul li a {
        text-decoration: none;
        font-weight:bold;
        font-size:18px;
        color: #ffff;
        display: block;
        padding: 16px;
        border-radius: 5px 5px 0 0;
        transition: background-color 0.3s ease;
    }

    .sidebar ul li a:hover {
        background-color: #007bff;
    }

    .sidebar ul li ul.submenu {
    display: none;
    list-style-type: none;
    padding-left: 20px;
    margin: 0;
    background-color: #f1f1f1;
}

.sidebar ul li ul.submenu li {
    margin-bottom: 0;
}

.sidebar ul li ul.submenu li a {
    color: #052e70;
    padding: 8px;
    display: block;
    font-weight: normal;
    font-size: 14   px;
}

.sidebar ul li ul.submenu li a:hover {
    background-color: #e0e0e0;
}

.sidebar ul li a.expandable {
    cursor: pointer;
}

</style>
