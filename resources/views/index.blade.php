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
  <li class="list-group-item"><a href="{{ route('ativosposdoutoradocurso') }}">Totais de alunos Pós-doutorando ativos por curso.</a></li>
</ul>

@endsection
