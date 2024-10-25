@extends('main')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/programas.css') }}">
@endsection

@section('content')
<div class="content-options">
    <form action="{{ route('disciplinas.listarPorAtivacao') }}" method="get">
        <label for="cod_disc" class="form-label">Código da Disciplina:</label>
        <select id="cod_disc" name="cod_disc" class="form-select" onchange="this.form.submit()">
            @foreach ($prefixos as $prefixo)
                <option value="{{ $prefixo->prefixo }}" {{ $cod_disc == $prefixo->prefixo ? 'selected' : '' }}>
                    {{ $prefixo->prefixo }}
                </option>
            @endforeach
        </select>
    </form>

    <h2>Disciplinas com Código: {{ $cod_disc }}</h2>
    <p>Total de disciplinas: {{ $total_disciplinas }}</p>

    <h3>Disciplinas Ativas</h3>
    <div class="table-responsive mt-4">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Data de Ativação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($disciplinas_ativas as $disciplina)
                    <tr>
                        <td>{{ $disciplina->codigo_disciplina }}</td>
                        <td>{{ $disciplina->nome_disciplina }}</td>
                        <td>{{ $disciplina->data_ativacao_disciplina }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <h3>Disciplinas Inativadas</h3>
    <div class="table-responsive mt-4">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Data de Inativação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($disciplinas_inativadas as $disciplina)
                    <tr>
                        <td>{{ $disciplina->codigo_disciplina }}</td>
                        <td>{{ $disciplina->nome_disciplina }}</td>
                        <td>{{ $disciplina->data_desativacao_disciplina }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
