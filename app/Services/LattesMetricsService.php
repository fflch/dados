<?php

namespace App\Services;
 
use App\Services\Replicado\Lattes as LattesService;

use Uspdev\Replicado\Pessoa;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LattesMetricsService
{
    /**
     * Retorna os docentes com suas métricas detalhadas
     */
    public function getDocentesComMetricas(int $limit = 10): array
    {
        $todosDocentes = Pessoa::listarDocentes();
        $docentes = array_slice($todosDocentes, 0, $limit);

        $resultado = [];

        foreach ($docentes as $docente) {
            $codpes = $docente['codpes'];
            $metricas = $this->getMetricasDetalhadas($codpes);

            $resultado[] = [
                'docente' => $docente,
                'artigos' => $metricas['artigos'],
                'livros' => $metricas['livros'],
                'capitulosLivros' => $metricas['capitulosLivros'],
                'projetosPesquisa' => $metricas['projetosPesquisa'],
                'projetosExtensao' => $metricas['projetosExtensao'],
                'projetosEnsino' => $metricas['projetosEnsino'],
                'projetosDesenvolvimento' => $metricas['projetosDesenvolvimento'],
                'outrosProjetos' => $metricas['outrosProjetos'],
                'orientacoesIC' => $metricas['orientacoesIC'],
                'orientacoesConcluidasDoc' => $metricas['orientacoesConcluidasDoc'],
                'orientacoesMestrado' => $metricas['orientacoesMestrado'],
                'premios' => $metricas['premios'] ?? [],
                'contagem' => $metricas['contagem'],
                'ultimaAtualizacao' => $metricas['ultimaAtualizacao'],
                'resumoCV' => $metricas['resumoCV'] ?? '',
            ];

        }

        return $resultado;
    }

    /**
     * Retorna os dados brutos e contagens de um docente
     */
    public function getMetricasDetalhadas(int $codpes): array
    {
        $lattesArray = LattesService::obterArray($codpes);

        $artigos = LattesService::listarArtigos($codpes, $lattesArray, 'registros', -1);
        //$artigos = is_array($artigos) ? $artigos : [];

        $livros = LattesService::listarLivrosPublicados($codpes, $lattesArray, 'registros', -1);
        $livros = is_array($livros) ? $livros : [];

        $projetosPesquisa = LattesService::listarProjetosPesquisa($codpes, $lattesArray, 'registros', -1);
        $projetosPesquisa = is_array($projetosPesquisa) ? $projetosPesquisa : [];

        $projetosExtensao = LattesService::listarProjetosExtensao($codpes, $lattesArray, 'registros', -1);
        $projetosExtensao = is_array($projetosExtensao) ? $projetosExtensao : [];

        $projetosEnsino = LattesService::listarProjetosEnsino($codpes, $lattesArray, 'registros', -1);
        $projetosEnsino = is_array($projetosEnsino) ? $projetosEnsino : [];

        $projetosDesenvolvimento = LattesService::listarProjetosDesenvolvimento($codpes, $lattesArray, 'registros', -1);
        $projetosDesenvolvimento = is_array($projetosDesenvolvimento) ? $projetosDesenvolvimento : [];

        $outrosProjetos = LattesService::listarOutrosProjetos($codpes, $lattesArray, 'registros', -1);
        $outrosProjetos = is_array($outrosProjetos) ? $outrosProjetos : [];

        $linhasDePesquisa = LattesService::listarLinhasPesquisa($codpes, $lattesArray);
        $linhasDePesquisa = is_array($linhasDePesquisa) ? $linhasDePesquisa : [];

        $textosJornaisRevistas = LattesService::listarTextosJornaisRevistas($codpes, $lattesArray, 'registros', -1);
        $textosJornaisRevistas = is_array($textosJornaisRevistas) ? $textosJornaisRevistas : [];

        $trabAnais = LattesService::listarTrabalhosAnais($codpes, $lattesArray, 'registros', -1);
        $trabAnais = is_array($trabAnais) ? $trabAnais : [];

        $trabTecnicos = LattesService::listarTrabalhosTecnicos($codpes, $lattesArray, 'registros', -1);
        $trabTecnicos = is_array($trabTecnicos) ? $trabTecnicos : [];

        $apresTrab = LattesService::listarApresentacaoTrabalho($codpes, $lattesArray, 'registros', -1);
        $apresTrab = is_array($apresTrab) ? $apresTrab : [];

        $capitulosLivros = LattesService::listarCapitulosLivros($codpes, $lattesArray, 'registros', -1);
        $capitulosLivros = is_array($capitulosLivros) ? $capitulosLivros : [];

        $bancasMestrado = LattesService::retornarBancaMestrado($codpes, $lattesArray);
        $bancasMestrado = is_array($bancasMestrado) ? $bancasMestrado : [];

        $bancasDoutorado = LattesService::retornarBancaDoutorado($codpes, $lattesArray);
        $bancasDoutorado = is_array($bancasDoutorado) ? $bancasDoutorado : [];

        $bancasQualificacaoDoutorado = LattesService::listarBancasQualificacaoDoutorado($codpes, $lattesArray);
        $bancasQualificacaoDoutorado = is_array($bancasQualificacaoDoutorado) ? $bancasQualificacaoDoutorado : [];

        $bancasQualificacaoMestrado = LattesService::listarBancasQualificacaoMestrado($codpes, $lattesArray);
        $bancasQualificacaoMestrado = is_array($bancasQualificacaoMestrado) ? $bancasQualificacaoMestrado : [];

        $bancasGraduacao = LattesService::listarBancasGraduacao($codpes, $lattesArray);
        $bancasGraduacao = is_array($bancasGraduacao) ? $bancasGraduacao : [];

        $bancasComissoesJulgadoras = LattesService::listarBancasComissoesJulgadoras($codpes, $lattesArray);
        $bancasComissoesJulgadoras = is_array($bancasComissoesJulgadoras) ? $bancasComissoesJulgadoras : [];

        $relatoriosPesquisa = LattesService::listarRelatorioPesquisa($codpes, $lattesArray, 'registros', -1);
        $relatoriosPesquisa = is_array($relatoriosPesquisa) ? $relatoriosPesquisa : [];

        $formacaoAcademica = LattesService::retornarFormacaoAcademica($codpes, $lattesArray);
        $formacaoAcademica = is_array($formacaoAcademica) ? $formacaoAcademica : [];

        $formacaoProfissional = LattesService::listarFormacaoProfissional($codpes, $lattesArray, 'periodo', -1);
        $formacaoProfissional = is_array($formacaoProfissional) ? $formacaoProfissional : [];

        $premios = LattesService::listarPremios($codpes, $lattesArray);
        $premios = is_array($premios) ? $premios : [];

        $organizacaoEventos = LattesService::listarOrganizacaoEvento($codpes, $lattesArray, 'registros', -1);
        $organizacaoEventos = is_array($organizacaoEventos) ? $organizacaoEventos : [];

        $materialDidatico = LattesService::listarMaterialDidaticoInstrucional($codpes, $lattesArray, 'registros', -1);
        $materialDidatico = is_array($materialDidatico) ? $materialDidatico : [];

        $resumoCV = LattesService::retornarResumoCV($codpes, 'pt', $lattesArray);
        $resumoCV = is_string($resumoCV) ? $resumoCV : [];

        $ultimaAtualizacao = LattesService::retornarUltimaAtualizacao($codpes, $lattesArray);
        $ultimaAtualizacao = is_array($ultimaAtualizacao) ? $ultimaAtualizacao : [];

        $orcid = LattesService::retornarOrcidID($codpes, $lattesArray);
        $orcid = is_array($orcid) ? $orcid : [];

        $orientacoesConcluidasDoc = LattesService::listarOrientacoesConcluidasDoutorado($codpes, $lattesArray, 'registros', -1);
        $orientacoesConcluidasDoc = is_array($orientacoesConcluidasDoc) ? $orientacoesConcluidasDoc : [];

        $orientacoesMestrado = LattesService::listarOrientacoesConcluidasMestrado($codpes, $lattesArray, 'registros', -1);
        $orientacoesMestrado = is_array($orientacoesMestrado) ? $orientacoesMestrado : [];

        $orientacoesPosDoc = LattesService::listarOrientacoesConcluidasPosDoutorado($codpes, $lattesArray, 'registros', -1);
        $orientacoesPosDoc = is_array($orientacoesPosDoc) ? $orientacoesPosDoc : [];

        $orientacoesIC = LattesService::listarOrientacoesConcluidasIC($codpes, $lattesArray, 'registros', -1);
        $orientacoesIC = is_array($orientacoesIC) ? $orientacoesIC : [];

        $eventos = LattesService::listarParticipacaoEventos($codpes, $lattesArray, 'registros', -1);
        $eventos = is_array($eventos) ? $eventos : [];

        $membroCorpoEditorial = LattesService::listarMembroCorpoEditorial($codpes, $lattesArray, 'registros', -1);
        $membroCorpoEditorial = is_array($membroCorpoEditorial) ? $membroCorpoEditorial : [];

        $membroComiteAssessoramento = LattesService::listarMembroComiteAssessoramento($codpes, $lattesArray, 'registros', -1);
        $membroComiteAssessoramento = is_array($membroComiteAssessoramento) ? $membroComiteAssessoramento : [];

        $outrasInformacoesRelevantes = LattesService::listarOutrasInformacoesRelevantes($codpes, $lattesArray);
        $outrasInformacoesRelevantes = is_array($outrasInformacoesRelevantes) ? $outrasInformacoesRelevantes : [];

        $orientacoesEmAndamento = LattesService::listarOrientacoesEmAndamento($codpes, $lattesArray, 'registros', -1);
        $orientacoesEmAndamento = is_array($orientacoesEmAndamento) ? $orientacoesEmAndamento : [];

        $outrasProducoesBibliograficas = LattesService::listarOutrasProducoesBibliograficas($codpes, $lattesArray, 'registros', -1);
        $outrasProducoesBibliograficas = is_array($outrasProducoesBibliograficas) ? $outrasProducoesBibliograficas : [];

        $premios = LattesService::listarPremios($codpes, $lattesArray);
        $premios = is_array($premios) ? $premios : [];

        $ultimaAtualizacao = LattesService::retornarUltimaAtualizacao($codpes, $lattesArray);


        $contagem = [
            'artigos' => count($artigos),
            'livros' => count($livros),
            'projetos-pesquisa' => count($projetosPesquisa),
            'projetos-extensao' => count($projetosExtensao),
            'projetos-ensino' => count($projetosEnsino),
            'projetos-desenvolvimento' => count($projetosDesenvolvimento),
            'outros-projetos' => count($outrosProjetos),
            'linhas-de-pesquisa' => count($linhasDePesquisa),
            'textos-jornais-revistas' => count($textosJornaisRevistas),
            'trabalhos-anais' => count($trabAnais),
            'trabalhos-tecnicos' => count($trabTecnicos),
            'apresentacao-de-trabalho' => count($apresTrab),
            'capitulos-livros' => count($capitulosLivros),
            'bancas-mestrado' => count($bancasMestrado),
            'bancas-doutorado' => count($bancasDoutorado),
            'bancas-qualificacao-mestrado' => count($bancasQualificacaoMestrado),
            'bancas-qualificacao-doutorado' => count($bancasQualificacaoDoutorado),
            'bancas-graduacao' => count($bancasGraduacao),
            'bancas-comissoes-julgadoras' => count($bancasComissoesJulgadoras),
            'relatorios-pesquisa' => count($relatoriosPesquisa),
            'formacao-academica' => count($formacaoAcademica),
            'formacao-profissional' => count($formacaoProfissional),
            'organizacao-eventos' => count($organizacaoEventos),
            'material-didatico' => count($materialDidatico),
            'orientacoes-concluidas-doutorado' => count($orientacoesConcluidasDoc),
            'orientacoes-concluidas-mestrado' => count($orientacoesMestrado),
            'orientacoes-concluidas-pos-doutorado' => count($orientacoesPosDoc),
            'orientacoes-concluidas-ic' => count($orientacoesIC),
            'eventos' => count($eventos),
            'membro-comite-assessoramento' => count($membroComiteAssessoramento),
            'membro-corpo-editorial' => count($membroCorpoEditorial),
            'outras-informacoes-relevantes' => count($outrasInformacoesRelevantes),
            'orientacoes-em-andamento' => count($orientacoesEmAndamento),
            'outras-producoes-bibliograficas' => count($outrasProducoesBibliograficas),
            'linhas-pesquisa' => count($linhasDePesquisa),
            'premios' => count($premios),
        ];


        return compact(
            'artigos',
            'livros',
            'capitulosLivros',
            'projetosPesquisa',
            'projetosExtensao',
            'projetosEnsino',
            'projetosDesenvolvimento',
            'outrosProjetos',
            'orientacoesIC',
            'orientacoesConcluidasDoc',
            'orientacoesMestrado',
            'orientacoesPosDoc',
            'membroComiteAssessoramento',
            'membroCorpoEditorial',
            'orientacoesEmAndamento',
            'outrasProducoesBibliograficas',
            'outrasInformacoesRelevantes',
            'linhasDePesquisa',
            'linhasDePesquisa',
            'textosJornaisRevistas',
            'trabAnais',
            'trabTecnicos',
            'apresTrab',
            'bancasMestrado',
            'bancasDoutorado',
            'bancasQualificacaoMestrado',
            'bancasQualificacaoDoutorado',
            'bancasGraduacao',
            'bancasComissoesJulgadoras',
            'relatoriosPesquisa',
            'formacaoAcademica',
            'formacaoProfissional',
            'premios',
            'organizacaoEventos',
            'materialDidatico',
            'eventos',
            'membroComiteAssessoramento',
            'outrasProducoesBibliograficas',
            'orientacoesEmAndamento',
            'outrasInformacoesRelevantes',
            'membroCorpoEditorial',
            'resumoCV',
            'ultimaAtualizacao',
            'orcid',
            'contagem'
        );

    }

    private function metricasVazias(): array
    {
        return [
            'artigos' => [],
            'livros' => [],
            'projetosPesquisa' => [],
            'projetosExtensao' => [],
            'projetosEnsino' => [],
            'projetosDesenvolvimento' => [],
            'outrosProjetos' => [],
            'orientacoesIC' => [],
            'contagem' => [
                'artigos' => 0,
                'livros' => 0,
                'projetos-pesquisa' => 0,
                'orientacoes' => 0,
            ],
            'ultimaAtualizacao' => null,
        ];
    }

    // App\Services\LattesMetricsService.php
    public function getDocentesComMetricasParaLista(array $docentes): array
    {
        $resultado = [];

        foreach ($docentes as $docente) {
            $codpes = $docente['codpes'];
            $metricas = $this->getMetricasDetalhadas($codpes);

            $resultado[] = [
                'docente' => $docente,
                'artigos' => $metricas['artigos'],
                'livros' => $metricas['livros'],
                'capitulosLivros' => $metricas['capitulosLivros'],
                'projetosPesquisa' => $metricas['projetosPesquisa'],
                'projetosExtensao' => $metricas['projetosExtensao'],
                'projetosEnsino' => $metricas['projetosEnsino'],
                'projetosDesenvolvimento' => $metricas['projetosDesenvolvimento'],
                'outrosProjetos' => $metricas['outrosProjetos'],
                'orientacoesIC' => $metricas['orientacoesIC'],
                'orientacoesConcluidasDoc' => $metricas['orientacoesConcluidasDoc'],
                'orientacoesMestrado' => $metricas['orientacoesMestrado'],
                'premios' => $metricas['premios'] ?? [],
                'contagem' => $metricas['contagem'],
                'ultimaAtualizacao' => $metricas['ultimaAtualizacao'],
                'resumoCV' => $metricas['resumoCV'] ?? '',
            ];
        }

        return $resultado;
    }


}
