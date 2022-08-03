@extends('main')

@section('content')

<h1 class="text-center titulo-apresentacao">APRESENTAÇÃO</h1>
<p class="descricao-site">
    O Portal de Dados surge a fim de disponibilizar ao público informações atualizadas em tempo real sobre a Faculdade de Filosofia, Letras e Ciências Humans - FFLCH, unidade de ensino, pesquisa e extensão universitária que abrange as áreas de Filosofia, História, Geografia, Letras e Ciências Sociais da Universidade de São Paulo. Os dados disponíveis podem ser acessados através do catálogo a seguir, organizado por categorias:
</p>
<div class="card">
    <div class="card-header" data-toggle="collapse"  data-target="#collapseDadosProducaoAcademica"  role="button" aria-expanded="false" aria-controls="collapseDadosProducaoAcademica" ><b>Dados de produção acadêmica: 3</b>  
        <span class="float-right" data-toggle="tooltip" data-placement="left" title="clique para expandir/retrair" role="button"><i class="fas fa-question-circle"></i></span>
   </div>
    <div class="card-body collapse"  id="collapseDadosProducaoAcademica">
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ config('app.url') }}/programas">Programas de Pós-Graduação (e por departamento)</a>  <a href="{{ config('app.url') }}/api/programas" class="export-json"><span data-toggle="tooltip" data-placement="left" title="Exportar em JSON" role="button"><img src="{{ asset('assets/img/json_icon.png') }}"></span></a></li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/defesas">Defesas</a> <a href="{{ config('app.url') }}/api/defesas" class="export-json"><span data-toggle="tooltip" data-placement="left" title="Exportar em JSON" role="button"><img src="{{ asset('assets/img/json_icon.png') }}"></span></a></li>
            
            <li class="list-group-item"><a href="{{ config('app.url') }}/pesquisa?filtro=departamento">Pesquisa</a> <a href="{{ config('app.url') }}/api/pesquisa?filtro=departamento" class="export-json"><span data-toggle="tooltip" data-placement="left" title="Exportar em JSON" role="button"><img src="{{ asset('assets/img/json_icon.png') }}"></span></a></li>
       </ul>
    </div>
</div>

<br>

<div class="card">
    <div class="card-header" data-toggle="collapse"  data-target="#collapseDadosInstitucionais"  role="button" aria-expanded="false" aria-controls="collapseDadosInstitucionais" ><b>Dados institucionais: 1</b>  
        <span class="float-right" data-toggle="tooltip" data-placement="left" title="clique para expandir/retrair" role="button"><i class="fas fa-question-circle"></i></span>
   </div>
    <div class="card-body collapse"  id="collapseDadosInstitucionais">
        <ul class="list-group">
            <li class="list-group-item">
                <a href="{{ config('app.url') }}/colegiados">Colegiados</a>
                <a href="{{ config('app.url') }}/api/colegiados" class="export-json">
                    <span data-toggle="tooltip" data-placement="left" title="Exportar em JSON" role="button">
                        <img src="{{ asset('assets/img/json_icon.png') }}">
                    </span>
                </a>
            </li>
       </ul>
    </div>
</div>

<br>

<div class="card">
    <div class="card-header" data-toggle="collapse"  data-target="#collapseDadosGerais"  role="button" aria-expanded="false" aria-controls="collapseDadosGerais" ><b>Dados gerais do portal: 6</b>  
         <span class="float-right" data-toggle="tooltip" data-placement="left" title="clique para expandir/retrair" role="button"><i class="fas fa-question-circle"></i></span>
    </div>
    <div class="card-body collapse"  id="collapseDadosGerais" >
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ config('app.url') }}/ativos">Totais de pessoas com vínculos ativos.</a></li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/ativosMicrosNotes">Totais de microcomputadores e notebooks.</a></li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/conveniosAtivos">Totais de convênios ativos.</a></li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/ativosDocentesPorFuncao">Totais de docentes contabilizados por função.</a></li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/ativosDepartamento/Servidor/0">Totais de funcionários e professores (associados, doutores e titulares) ativos  contabilizados por departamento.</a></li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/exAlunos">Total de Ex Alunos da Graduação e da Pós Graduação.</a></li>
        </ul>

    </div>
</div>

<br>

<div class="card">
    <div class="card-header" data-toggle="collapse"  data-target="#collapseDadosGenero"  role="button" aria-expanded="false" aria-controls="collapseDadosGenero"><b>Dados por gênero: 1</b>
        <span class="float-right" data-toggle="tooltip" data-placement="left" title="clique para expandir/retrair" role="button"><i class="fas fa-question-circle"></i></span>
    </div>
    <div class="card-body collapse"  id="collapseDadosGenero">

        <ul class="list-group">
            <li class="list-group-item"><a href="{{ config('app.url') }}/ativosGenero/ALUNOGR0/0">Totais de ativos contabilizadas por
                    gênero.</a>
            </li>
        </ul>

    </div>
</div>

<br>

<div class="card">
    <div class="card-header" data-toggle="collapse"  data-target="#collapseDadosCurso"  role="button" aria-expanded="false" aria-controls="collapseDadosCurso"><b>Dados por curso: 3</b>
        <span class="float-right" data-toggle="tooltip" data-placement="left" title="clique para expandir/retrair" role="button"><i class="fas fa-question-circle"></i></span>
    </div>
    <div class="card-body collapse"  id="collapseDadosCurso">

        <ul class="list-group">
           
            <li class="list-group-item"><a href="{{ config('app.url') }}/alunosAtivosPorCurso?tipvin=ALUNOGR">Totais de alunos vínculos ativos,
                    separados por curso.</a>
                    <a href="{{ config('app.url') }}/api/alunosAtivosPorCurso?tipvin=ALUNOGR" class="export-json">
                    <span data-toggle="tooltip" data-placement="left" title="Exportar em JSON" role="button">
                        <img src="{{ asset('assets/img/json_icon.png') }}">
                    </span>
                </a>    
            </li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/concluintesGradPorCurso/{{date('Y') -1}}">Total de concluintes da Graduação por
                    curso.
                        </a></li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/trancamentosCursoPorSemestre">Total de trancamentos por semestre dos cursos.
                        </a></li>
        </ul>
    </div>
</div>

<br>

<div class="card">
    <div class="card-header" data-toggle="collapse"  data-target="#collapseDadosPGR"  role="button" aria-expanded="false" aria-controls="collapseDadosPGR"><b>Dados pós graduação: 4</b>
        <span class="float-right" data-toggle="tooltip" data-placement="left" title="clique para expandir/retrair" role="button"><i class="fas fa-question-circle"></i></span>
    </div>
    <div class="card-body collapse"  id="collapseDadosPGR">
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
    <div class="card-header" data-toggle="collapse"  data-target="#collapseDadosAno"  role="button" aria-expanded="false" aria-controls="collapseDadosAno"><b>Dados por ano: 7</b>
        <span class="float-right" data-toggle="tooltip" data-placement="left" title="clique para expandir/retrair" role="button"><i class="fas fa-question-circle"></i></span>
    </div>
    <div class="card-body collapse"  id="collapseDadosAno">
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
    <div class="card-header" data-toggle="collapse"  data-target="#collapseDadosRaca"  role="button" aria-expanded="false" aria-controls="collapseDadosRaca"><b>Dados por cor/raça: 1</b>
        <span class="float-right" data-toggle="tooltip" data-placement="left" title="clique para expandir/retrair" role="button"><i class="fas fa-question-circle"></i></span>
    </div>
    <div class="card-body collapse"  id="collapseDadosRaca">
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ config('app.url') }}/ativosAlunosAutodeclarados/ALUNOGR">Totais de alunos autodeclarados por raça/cor.</a></li>
        </ul>
    </div>
</div>

<br>

<div class="card">
    <div class="card-header" data-toggle="collapse"  data-target="#collapseDadosNacionalidade"  role="button" aria-expanded="false" aria-controls="collapseDadosNacionalidade"><b>Dados por nacionalidade/localidade: 2</b>
        <span class="float-right" data-toggle="tooltip" data-placement="left" title="clique para expandir/retrair" role="button"><i class="fas fa-question-circle"></i></span>
    </div>
    <div class="card-body collapse"  id="collapseDadosNacionalidade">
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ config('app.url') }}/ativosPaisNascimento?vinculo=ALUNOGR">Totais de alunos e docentes brasileiros e estrangeiros ativos.</a>
                <a href="{{ config('app.url') }}/api/ativosPaisNascimento?vinculo=ALUNOGR" class="export-json">
                    <span data-toggle="tooltip" data-placement="left" title="Exportar em JSON" role="button">
                        <img src="{{ asset('assets/img/json_icon.png') }}">
                    </span>
                </a>  
            </li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/alunosAtivosEstado">Totais de alunos contabilizados por estados.</a>
                <a href="{{ config('app.url') }}/api/alunosAtivosEstado" class="export-json">
                    <span data-toggle="tooltip" data-placement="left" title="Exportar em JSON" role="button">
                        <img src="{{ asset('assets/img/json_icon.png') }}">
                    </span>
                </a>  
            </li>
        </ul>
    </div>
</div>

<br>

<div class="card">
    <div class="card-header" data-toggle="collapse"  data-target="#collapseDadosIngresso"  role="button" aria-expanded="false" aria-controls="collapseDadosIngresso"><b>Dados por ingresso: 3</b>
        <span class="float-right" data-toggle="tooltip" data-placement="left" title="clique para expandir/retrair" role="button"><i class="fas fa-question-circle"></i></span>
    </div>
    <div class="card-body collapse"  id="collapseDadosIngresso">
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ config('app.url') }}/ativosAlunosGradTipoIngresso">Totais de alunos da Graduação por tipo de ingresso.</a></li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/IngressantesGradGeneroCurso?curso=Letras&ano_ini={{date('Y') - 5}}&ano_fim={{date('Y')}}">Série histórica: Ingressantes da graduação por curso, gênero e ano</a></li>
            <li class="list-group-item"><a href="{{ config('app.url') }}/IngressantesPosGrGeneroPrograma?codare=8133&ano_ini={{date('Y') - 5}}&ano_fim={{date('Y')}}&nivpgm=ME">Série histórica: Ingressantes da pós graduação por programa, gênero e ano</a></li>
        </ul>
    </div>
    
</div>


@endsection

@section('javascripts_bottom')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection 