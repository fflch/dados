@extends('laravel-usp-theme::master')

@section('content')
Dados do portal:

<ul class="list-group">
  <li class="list-group-item"><a href="/ativos">Totais de pessoas com vínculos ativos</a></li>
  <li class="list-group-item"><a href="/ativosPCGrad">Totais de pessoas da Graduação com vínculos ativos, separadas por curso.</a></li>
  <li class="list-group-item"><a href="/ativosMicrosNotes">Totais de microcomputadores e notebooks.</a></li>
</ul>

@endsection
