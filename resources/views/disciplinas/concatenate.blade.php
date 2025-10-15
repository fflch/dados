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
        {{ $turma['nomdis'] }} - 
        Turma {{ $turma['codtur'] }}
        ({{ $turma['horario'] }}) - 
        Prof. {{ $turma['nompes'] }}'
        <br>
    @endforeach

    </div>
</div>
@endsection
