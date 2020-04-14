@extends('laravel-usp-theme::master')

@section('content')
Dados do portal:

<ul class="list-group">
  <li class="list-group-item"><a href="/ativos">Totais de pessoas com vínculos ativos</a></li>
  <li class="list-group-item"><a href="/ativosPCGrad">Totais de pessoas da Graduação com vínculos ativos, separadas por curso.</a></li>
  <li class="list-group-item"><a href="/ativosMicrosNotes">Totais de microcomputadores e notebooks.</a></li>
  <li class="list-group-item"><a href="/ativosPGGrad">Totais de pessoas da Graduação contabilizadas por gênero.</a></li>
  <li class="list-group-item"><a href="/ativosPGPos">Totais de pessoas da Pós Graduação contabilizadas por gênero.</a></li>
  <li class="list-group-item"><a href="/ativosPGDocentes">Totais de docentes contabilizados por gênero.</a></li>
  <li class="list-group-item"><a href="/ativosEstagiarios">Totais de estagiários contabilizados por gênero.</a></li>
  <li class="list-group-item"><a href="/ativosFuncionarios">Totais de funcionários contabilizados por gênero.</a></li>
  <li class="list-group-item"><a href="{{ route('ativosposdoutoradocurso') }}">Totais de alunos Pós-doutorando ativos por curso.</a></li>
  <li class="list-group-item"><a href="/ativosFuncionariosDepartamento">Totais de funcionários contabilizados por departamento.</a></li>
  <li class="list-group-item"><a href="/ativosPorProgramaPos">Totais de pessoas da Pós-Graduação, separadas por programa.</a></li>
  <li class="list-group-item"><a href="/ativosGradSociais">Totais de alunos da Graduação em Ciências Sociais contabilizados por gênero.</a></li>
  <li class="list-group-item"><a href="/ativosGradFilosofia">Totais de alunos da Graduação em Filosofia contabilizados por gênero.</a></li>
  <li class="list-group-item"><a href="/ativosGradGeografia">Totais de alunos da Graduação em Geografia contabilizados por gênero.</a></li>
  <li class="list-group-item"><a href="/ativosGradHistoria">Totais de alunos da Graduação em História contabilizados por gênero.</a></li>
  <li class="list-group-item"><a href="/ativosGradLetras">Totais de alunos da Graduação em Letras contabilizados por gênero.</a></li>
  <li class="list-group-item"><a href="/ativosBeneficiosConHist">Série histórica de benefícios concedidos por ano a partir de 2014.</a></li>
  <li class="list-group-item"><a href="/Benef2019Prog">Quantidade de benefícios concedidos em 2019 separados por programa.</a></li>
  <li class="list-group-item"><a href="/ativosCulturaExtensao">Totais de alunos de Cultura e Extensão contabilizados por gênero.</a></li>
  <li class="list-group-item"><a href="/ativosPosDoutorado">Totais de alunos de Pós Doutorado contabilizados por gênero.</a></li>
  <li class="list-group-item"><a href="/ativosBeneficios">Série histórica: quantidade de alunos com benefícios 2010-2020.</a></li>
  <li class="list-group-item"><a href="/concluintesGrad2014PorCurso">Total de concluintes da Graduação por curso em 2014.</a></li>
  <li class="list-group-item"><a href="/concluintesGrad2015PorCurso">Total de concluintes da Graduação por curso em 2015.</a></li>
  <li class="list-group-item"><a href="/concluintesGrad2016PorCurso">Total de concluintes da Graduação por curso em 2016.</a></li>
  <li class="list-group-item"><a href="/concluintesGrad2017PorCurso">Total de concluintes da Graduação por curso em 2017.</a></li>
  <li class="list-group-item"><a href="/concluintesGrad2018PorCurso">Total de concluintes da Graduação por curso em 2018.</a></li>
  <li class="list-group-item"><a href="/concluintesGrad2019PorCurso">Total de concluintes da Graduação por curso em 2019.</a></li>
  <li class="list-group-item"><a href="/concluintesGradPorAno">Série histórica de concluintes da Graduação por ano a partir de 2010.</a></li>
  <li class="list-group-item"><a href="/concluintesPosPorAno">Série histórica de concluintes da Pós-Graduação por ano a partir de 2010.</a></li>

</ul>
@endsection
