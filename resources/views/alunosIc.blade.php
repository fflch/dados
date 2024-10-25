@extends('main')

@section('content')

<h1>Total de Alunos de Iniciação Científica: {{ $alunos_ic_total }}</h1>

<!-- Botão para exportar -->
<a href="{{ route('iniciacoes.exportar') }}" class="btn btn-success">Exportar para Excel</a>

<!-- Tabela para exibir as informações dos alunos de IC -->
<div class="table-responsive mt-4">
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID Projeto</th>
                <th>Número USP</th>
                <th>Situação do Projeto</th>
                <th>Data de Início</th>
                <th>Data de Fim</th>
                <th>Ano do Projeto</th>
                <th>Código do Departamento</th>
                <th>Nome do Departamento</th>
                <th>Número USP do Orientador</th>
                <th>Título do Projeto</th>
                <th>Palavras-Chave</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alunos_ic_historia as $p)
                <tr>
                    <td>{{ $p->id_projeto }}</td>
                    <td>{{ $p->numero_usp }}</td>
                    <td>{{ $p->situacao_projeto }}</td>
                    <td>{{ $p->data_inicio_projeto }}</td>
                    <td>{{ $p->data_fim_projeto }}</td>
                    <td>{{ $p->ano_projeto }}</td>
                    <td>{{ $p->codigo_departamento }}</td>
                    <td>{{ $p->nome_departamento }}</td>
                    <td>{{ $p->numero_usp_orientador }}</td>
                    <td>{{ $p->titulo_projeto }}</td>
                    <td>{{ $p->palavras_chave }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
