@extends('laravel-usp-theme::master')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4 bg-light border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">_
                        <i class="-chalkboard-teacher -3x text-primary"></i>
                    </div>_
                    <div class="flex-grow-1 ms-3">
                        <h4 class="fw-bold text-primary mb-1">Dashboard de Métricas Lattes</h4>
                        <p class="text-muted mb-0">
                            Explore um panorama completo da produção acadêmica dos docentes. 
                            Utilize os filtros abaixo para refinar sua busca por <strong>nome</strong> ou 
                            <strong>departamento</strong>. 
                            Cada linha da tabela oferece um resumo das principais métricas, 
                             como <span class="text-primary">artigos</span>, <span class="text-success">livros</span>, 
                             <span class="text-info">orientações</span> e <span class="text-warning">prêmios</span>. 
                             Para obter uma planilha completa da produção acadêmica de um docente específico, clique em Ações
                             e "Exportar Detalhado".
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <form method="GET" action="{{ route('lattes.dashboard') }}" class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="busca"><b>Busca por Nome:</b></label>
                            <input type="text" name="busca" id="busca" value="{{ $busca }}" class="form-control"
                                placeholder="Digite o nome do docente">
                        </div>
                    </div>
                    <div class="col-md-6">
                        @php $departamentos = \App\Utils\Util::getDepartamentos(); @endphp
                        <div class="form-group">
                            <label for="departamento"><b>Filtro por Departamento:</b></label>
                            <select name="departamento" id="departamento" class="form-control">
                                <option value="">-- Todos os Departamentos --</option>
                                @foreach($departamentos as $sigla => $dados)
                                    <option value="{{ $dados[1] }}" {{ ($departamento_filtro == $dados[1]) ? 'selected' : '' }}>
                                        {{ $dados[1] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-2"><i class="-filter"></i> Aplicar Filtros</button>
                <a href="{{ route('lattes.dashboard') }}" class="btn btn-outline-secondary mt-2">Limpar Filtros</a>
            </div>
        </form>

        <div class="card shadow-sm mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 small">
                        <thead class="thead-light">
                            <tr>
                                <th class="pl-4">Docente</th>
                                <th class="text-center">Departamento</th>
                                <th class="text-center"><i class="text-primary"></i> Artigos</th>
                                <th class="text-center"><i class="text-success"></i> Livros</th>
                                <th class="text-center"><i class="text-info"></i> Capítulos</th>
                                <th class="text-center"><i class="text-info"></i> Proj. Pesquisa</th> {{-- Mantido --}}
                                <th class="text-center"><i class="text-primary"></i> Proj. Extensão</th> {{-- Mantido --}}
                                <th class="text-center"><i class="text-warning"></i> Proj. Desenvolvimento</th> {{-- Renomeado e agregado --}}
                                <th class="text-center"><i class="text-secondary"></i> Linhas de Pesquisa</th>
                                <th class="text-center"><i class="text-primary"></i>Orientações Iniciação Científica</th>
                                <th class="text-center"><i class="text-success"></i>Orientações Mestrado</th>
                                <th class="text-center"><i class="text-info"></i>Orientações Doutorado</th>
                                <th class="text-center"><i class="text-secondary"></i>Orientações Pós-Doc</th>
                                <th class="text-center"><i class="text-primary"></i>Textos Jornais/Revistas</th>
                                <th class="text-center"><i class="text-secondary"></i>Trabalhos em Anais</th>
                                <th class="text-center"><i class="text-dark"></i>Trabalhos Técnicos</th>
                                <th class="text-center"><i class="text-info"></i>Apres. de Trabalho</th>
                                <th class="text-center"><i class="text-success"></i>Bancas de Mestrado</th>
                                <th class="text-center"><i class="text-info"></i>Bancas de Doutorado</th>
                                <th class="text-center"><i class="text-warning"></i>Relatórios de Pesquisa</th>
                                <th class="text-center"><i class="text-success"></i>Organização de Eventos</th>
                                <th class="text-center"><i class="text-danger"></i>Material Didático</th>
                                <th class="text-center"><i class="text-dark"></i>Formação Acadêmica</th>
                                <th class="text-center"><i class="text-primary"></i>Formação Profissional</th>
                                <th class="text-center"><i class="text-primary"></i>Membro Corpo Editorial</th>
                                <th class="text-center"><i class="text-primary"></i> Membro Comitê Assessoramento</th>
                                <th class="text-center"><i class="text-secondary"></i> Orientações e Supervisões em Andamento</th>
                                <th class="text-center"><i class="text-dark"></i> Outras Prod. Bibliográficas</th>
                                <th class="text-center"><i class="text-success"></i> Qualificação Mestrado</th>
                                <th class="text-center"><i class="text-info"></i> Qualificação Doutorado</th>
                                <th class="text-center"><i class="text-primary"></i> Bancas de Graduação</th>
                                <th class="text-center"><i class="text-secondary"></i> Comissões Julgadoras</th>
                                <th class="text-center"><i class="text-info"></i> Outras Informações Relevantes</th>
                                <th class="text-center"><i class="text-warning"></i> Prêmios e Títulos</th>
                                <th class="text-center"><i class="text-warning"></i>Participação Eventos</th>
                                <th class="text-center"><i class="text-muted"></i> Atualização</th>
                                <th class="text-center"><i class="text-success"></i> Ações</th>
                                <th class="text-center"><i class="text-success"></i> Exportar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($docentes as $docente)
                                <tr class="border-bottom">
                                    <td class="pl-4">
                                        <strong>{{ $docente['docente']['nompes'] }}</strong>
                                        @if (!empty($docente['docente']['orcid']))
                                            <div class="small text-muted">
                                                <i class="b -orcid text-success"></i> {{ $docente['docente']['orcid'] }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ implode(', ', $docente['departamentos']) }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['artigos'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['livros'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['capitulos-livros'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['projetos-pesquisa'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['projetos-extensao'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['projetos-desenvolvimento'] ?? 0 }} {{-- Agora inclui Ensino e Outros --}}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['linhas-pesquisa'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['orientacoes-concluidas-ic'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['orientacoes-concluidas-mestrado'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['orientacoes-concluidas-doutorado'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['orientacoes-concluidas-pos-doutorado'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['textos-jornais-revistas'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['trabalhos-anais'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['trabalhos-tecnicos'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['apresentacao-de-trabalho'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['bancas-mestrado'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['bancas-doutorado'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['relatorios-pesquisa'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['organizacao-eventos'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['material-didatico'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['formacao-academica'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['formacao-profissional'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['membro-corpo-editorial'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['membro-comite-assessoramento'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['orientacoes-em-andamento'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['outras-producoes-bibliograficas'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['bancas-qualificacao-mestrado'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['bancas-qualificacao-doutorado'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['bancas-graduacao'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['bancas-comissoes-julgadoras'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['outras-informacoes-relevantes'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['premios'] ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $docente['contagem']['eventos'] ?? 0 }}
                                    </td>
                                    <td class="text-muted text-center small">
                                        {{ !empty($docente['ultimaAtualizacao']) ? \Carbon\Carbon::createFromFormat('dmY', $docente['ultimaAtualizacao'])->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-success" data-toggle="modal"
                                            data-target="#modalResumo{{ $docente['docente']['codpes'] }}">_
                                            <i class="-eye"></i>
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('lattes.exportar', $docente['docente']['codpes']) }}"
                                            class="btn btn-sm btn-outline-primary" title="Exportar Excel">_
                                            <i class="-download"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="37">
                                        <div class="alert alert-warning mb-0">Nenhum docente encontrado ou dados indisponíveis.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            {{ $docentes->appends(request()->query())->links() }}
        </div>

        <!-- Modal para resumo -->
        @foreach ($docentes as $docente)
            <div class="modal de" id="modalResumo{{ $docente['docente']['codpes'] }}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Resumo Completo - {{ $docente['docente']['nompes'] }}</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <h6><i class="-graduation-cap"></i> Formação Acadêmica</h6>
                                <ul class="list-group small">
                                    @foreach(($docente['formacaoAcademica'] ?? []) as $formacao)
                                        <li class="list-group-item">{{ $formacao['titulo'] ?? 'N/A' }} -
                                            {{ $formacao['instituicao'] ?? 'N/A' }} ({{ $formacao['anoConclusao'] ?? 'N/A' }})</li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="-chart-pie"></i> Estatísticas</h6>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-unstyled">
                                                <li><strong>Artigos:</strong> {{ count($docente['artigos'] ?? []) }}</li>
                                                <li><strong>Livros:</strong> {{ count($docente['livros'] ?? []) }}</li>
                                                <li><strong>Capítulos:</strong> {{ count($docente['capitulosLivros'] ?? []) }}
                                                </li>
                                                <li><strong>Doutorado:</strong>
                                                    {{ count($docente['orientacoesConcluidasDoc'] ?? []) }}</li>
                                                <li><strong>Eventos:</strong>
                                                    {{ count($docente['eventos'] ?? []) }}</li>
                                                <li><strong>Mestrado:</strong>
                                                    {{ count($docente['orientacoesMestrado'] ?? []) }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="-trophy"></i> Prêmios</h6>
                                        </div>
                                        <div class="card-body">
                                            @if(!empty($docente['premios']))
                                                <ul class="list-unstyled">
                                                    @foreach($docente['premios'] as $premio)
                                                        <ul>
                                                            <li>{{ $premio['nome'] ?? 'N/A' }} ({{ $premio['ano'] ?? 'N/A' }})</li>
                                                        </ul>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p class="text-muted">Nenhum prêmio registrado</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <h6><i class="-quote-left"></i> Resumo CV</h6>
                                <div class="card card-body bg-light">
                                    {{ $docente['resumoCV'] ?? 'Resumo não disponível' }}
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('lattes.exportar_detalhado', $docente['docente']['codpes']) }}"
                                class="btn btn-outline-primary">
                                <i class="-file-excel"></i> Exportar Dados Detalhados
                            </a>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('javascripts_bottom')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection