@extends('main')

@section('content')

<div class="card">
  <div class="card-header">
    <b> Disciplinas/Turmas oferecidas </b>
  </div>

  <div class="card-body">
    <ul>
      <li><a href="{{ config('app.url') }}/turmas/flg">Departamento de Geografia</a></li>
      <li><a href="{{ config('app.url') }}/turmas/flh">Departamento de História</a></li>

      <li><a href="{{ config('app.url') }}/turmas/flo">Departamento de Letras Orientais</a> </li>
      <li><a href="{{ config('app.url') }}/turmas/flt">Departamento de Teoria Literária e Literatura Comparada</a></li>
      <li><a href="{{ config('app.url') }}/turmas/flc">Departamento de Letras Clássicas e Vernáculas</a> </li>
      <li><a href="{{ config('app.url') }}/turmas/fll">Departamento de Linguística</a> </li>
      <li><a href="{{ config('app.url') }}/turmas/flm">Departamento de Letras Modernas</a> </li>

      <li><a href="{{ config('app.url') }}/turmas/fsl">Departamento de Sociologia</a> </li>
      <li><a href="{{ config('app.url') }}/turmas/fla">Departamento de Antropologia</a> </li>
      <li><a href="{{ config('app.url') }}/turmas/flp">Departamento de Ciência Política</a></li>
      <li><a href="{{ config('app.url') }}/turmas/flf">Departamento de Filosofia</a></li>
    </ul>
  </div>
</div>

@endsection
