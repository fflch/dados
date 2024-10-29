@extends('main')

@section('content')

<div class="section-container">
    <h2 class="section-header" onclick="toggleSection('ic-section')">Projetos de Iniciação Científica</h2>
    <div id="ic-section" class="collapsible-content">
        <div class="table-responsive mt-4">
            <table class="table table-striped table-bordered">
                <thead>
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
                    @foreach ($projetos as $p)
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
    </div>
</div>

<div class="section-container">
    <h2 class="section-header" onclick="toggleSection('docentes-section')">Docentes</h2>
    <div id="docentes-section" class="collapsible-content">
        <div class="table-responsive mt-4">
         
        </div>
    </div>
</div>

<script>
    function toggleSection(sectionId) {
        const section = document.getElementById(sectionId);
        section.classList.toggle('expanded');
    }
</script>

<style>
    .section-container {
        margin: 20px 0;
    }

    .section-header {
        cursor: pointer;
        font-size: 24px;
        font-weight: bold;
        background-color: #f5f5f5;
        padding: 10px;
        border-radius: 5px;
        text-align: center;
        transition: background-color 0.3s ease;
    }

    .section-header:hover {
        background-color: #ddd;
    }

    .collapsible-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease;
    }

    .collapsible-content.expanded {
        max-height: 1000px; /* Valor suficiente para expandir a tabela */
    }
</style>

@endsection
