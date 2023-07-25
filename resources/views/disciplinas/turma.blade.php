@extends('main')

@section('content')

<div class="card">
    <div class="card-header">
        <b> {{ $prefix }} </b>
    </div>

    <a href="{{ config('app.url') }}/turmas">Voltar</a>

    <br>
    <a href="{{ config('app.url') }}/turmas/{{ $prefix }}/concatenate">Versão Concatenada</a>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Disciplina</th>
                    <th scope="col">Turma</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Horário</th>
                    <th scope="col">Professor(a)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($turmas as $turma)
                    <tr>
                        <td>{{ $turma['coddis'] }} </td>
                        <td>{{ $turma['codtur'] }} </td>
                        <td>{{ \App\Utils\ReplicadoTemp::nomdis($turma['coddis'], $turma['verdis']) }} </td>
                        <td>{{ \App\Utils\ReplicadoTemp::horario($turma['coddis'], $turma['codtur'], $turma['verdis']) }} </td>
                        <td>{{ \App\Utils\ReplicadoTemp::ministrantes($turma['coddis'], $turma['codtur'], $turma['verdis']) }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

