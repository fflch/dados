@extends('main')

@section('content')

<div class="card">
    <div class="card-header">
        <b> {{ $prefix }} </b>
    </div>

    <a href="{{ config('app.url') }}/turmas">Voltar</a>

    @foreach($turmas as $turma)
        {{ $turma['coddis'] }}{{ $turma['codtur'] }}:
        '{{ $turma['coddis'] }} -
        {{ \App\Utils\ReplicadoTemp::nomdis($turma['coddis'], $turma['verdis']) }} - 
        Turma {{ $turma['codtur'] }}
        ({{ \App\Utils\ReplicadoTemp::horario($turma['coddis'], $turma['codtur'], $turma['verdis']) }}) - 
        Prof. {{ \App\Utils\ReplicadoTemp::ministrantes($turma['coddis'], $turma['codtur'], $turma['verdis']) }}'
        <br>
    @endforeach

    </div>
</div>
@endsection

