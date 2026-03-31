<?php

namespace App\Exports;

use App\Services\LattesMetricsService;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DocenteDetalhadoExport implements WithMultipleSheets
{
    protected $codpes;
    protected $dados;

    public function __construct($codpes)
    {
        $this->codpes = $codpes;
        $service = new LattesMetricsService();
        $this->dados = $service->getMetricasDetalhadas($this->codpes);
    }

    public function sheets(): array
    {
        // Mapeia as chaves de dados para nomes de planilhas legíveis
        $map = [
            'artigos' => 'Artigos',
            'livros' => 'Livros',
            'capitulosLivros' => 'Capítulos',
            'eventos' => 'Participação em Eventos',
            'organizacaoEventos' => 'Organização de Eventos',
            'premios' => 'Prêmios e Títulos',
            'membroCorpoEditorial' => 'Membro de Corpo Editorial',
            'membroComiteAssessoramento' => 'Membro Comitê Assessoramento',
            'orientacoesEmAndamento' => 'Orientações em Andamento',
            'outrasProducoesBibliograficas' => 'Outras Produções Bibliográficas',
            'outrasInformacoesRelevantes' => 'Outras Informações Relevantes',
            'linhasDePesquisa' => 'Linhas de Pesquisa',
            'orientacoesConcluidasDoc' => 'Orientações de Doutorado',
            'orientacoesMestrado' => 'Orientações de Mestrado',
            'orientacoesIC' => 'Orientações IC',
            'orientacoesPosDoc' => 'Orientações de Pós-Doc',
            'bancasDoutorado' => 'Bancas de Doutorado',
            'bancasMestrado' => 'Bancas de Mestrado',
            'bancasQualificacaoDoutorado' => 'Bancas de Qual. Doutorado',
            'bancasQualificacaoMestrado' => 'Bancas de Qual. Mestrado',
            'bancasGraduacao' => 'Bancas de Graduação',
            'bancasComissoesJulgadoras' => 'Comissões Julgadoras',
            'trabAnais' => 'Trabalhos em Anais',
            'trabTecnicos' => 'Trabalhos Técnicos',
            'apresTrab' => 'Apresentações de Trabalho',
            'textosJornaisRevistas' => 'Textos em Jornais/Revistas',
            'relatoriosPesquisa' => 'Relatórios de Pesquisa',
            'materialDidatico' => 'Material Didático',
            'formacaoAcademica' => 'Formação Acadêmica',
        ];

        $sheets = [];
        
        // Add specific project sheets
        if (!empty($this->dados['projetosPesquisa'])) {
            $sheets[] = new ArraySheetWithHeaderExport($this->processarProjetosPesquisa($this->dados['projetosPesquisa']), 'Projetos de Pesquisa');
        }

        if (!empty($this->dados['projetosExtensao'])) {
            $sheets[] = new ArraySheetWithHeaderExport($this->processarProjetos($this->dados['projetosExtensao']), 'Projetos de Extensão');
        }

        // Combine Desenvolvimento, Ensino, and Outros into a single "Projetos de Desenvolvimento" sheet
        $combinedDesenvolvimentoProjects = array_merge(
            $this->dados['projetosDesenvolvimento'] ?? [],
            $this->dados['projetosEnsino'] ?? [],
            $this->dados['outrosProjetos'] ?? []
        );
        if (!empty($combinedDesenvolvimentoProjects)) {
            $sheets[] = new ArraySheetWithHeaderExport($this->processarProjetos($combinedDesenvolvimentoProjects), 'Projetos de Desenvolvimento');
        }

        if (!empty($this->dados['membroComiteAssessoramento'])) {
            $sheets[] = new ArraySheetWithHeaderExport($this->processarMembroComiteAssessoramento($this->dados['membroComiteAssessoramento']), 'Membro Comitê Assessoramento');
        }

        foreach ($map as $key => $nome) {
            // Skip project keys as they are handled above
            if (!in_array($key, ['projetosPesquisa', 'projetosExtensao', 'projetosDesenvolvimento', 'projetosEnsino', 'outrosProjetos'])) {
                if (!empty($this->dados[$key]) && is_array($this->dados[$key])) {
                    $handlerMethod = 'processar' . ucfirst($key);
                    $processedData = method_exists($this, $handlerMethod)
                        ? $this->{$handlerMethod}($this->dados[$key])
                        : $this->processarDadosGenericos($this->dados[$key]);

                    $sheets[] = new ArraySheetWithHeaderExport($processedData, $nome);
                }
            }
        }

        return $sheets;
    }

    /**
     * Processador de dados genérico. Formata a coluna de autores.
     */
    private function processarDadosGenericos(array $data): array
    {
        foreach ($data as &$item) {
            if (isset($item['AUTORES']) && is_array($item['AUTORES'])) {
                $autoresNomes = array_map(fn($autor) => $autor['NOME-COMPLETO-DO-AUTOR'] ?? 'N/A', $item['AUTORES']);
                $item['AUTORES'] = implode('; ', $autoresNomes);
            }
        }
        return $data;
    }

    /**
     * Manipulador específico para projetos (Pesquisa, Extensão, Desenvolvimento).
     * Assumes the structure of project data from Lattes.
     */
    private function processarProjetos(array $data): array
    {
        $projetosFormatados = [];
        foreach ($data as $projeto) {
            $equipe = '';
            if (isset($projeto['EQUIPE-DO-PROJETO']) && is_array($projeto['EQUIPE-DO-PROJETO'])) {
                $nomesEquipe = array_map(fn($membro) => $membro['NOME-COMPLETO'] ?? 'N/A', $projeto['EQUIPE-DO-PROJETO']);
                $equipe = implode('; ', $nomesEquipe);
            }

            $projetosFormatados[] = [
                'NOME-DO-PROJETO' => $projeto['NOME-DO-PROJETO'] ?? 'N/A',
                'ANO-INICIO' => $projeto['ANO-INICIO'] ?? 'N/A',
                'ANO-FIM' => $projeto['ANO-FIM'] ?? 'N/A',
                'SITUACAO' => $projeto['SITUACAO'] ?? 'N/A',
                'NATUREZA' => $projeto['NATUREZA'] ?? 'N/A',
                'DESCRICAO-DO-PROJETO' => $projeto['DESCRICAO-DO-PROJETO'] ?? 'N/A',
                'EQUIPE-DO-PROJETO' => $equipe,
            ];
        }
        return $projetosFormatados;
    }

    /**
     * Manipulador específico para 'projetosPesquisa' com tratamento robusto de estrutura e novos campos.
     */
    private function processarProjetosPesquisa(array $data): array
    {
        $projetosFormatados = [];
        foreach ($data as $processedProject) {
            // Use the raw data embedded by Lattes::processarProjeto for full details
            $projetoData = $processedProject['RAW_DATA'] ?? null;

            // If RAW_DATA is not present, it means the data is already raw, or it's the old processed format.
            // The logic below attempts to handle both, but prefers the raw structure.
            if (is_null($projetoData)) {
                $projetoData = $processedProject;
            }
            $projeto = $projetoData['@attributes'] ?? $projetoData;

            // Identificação básica
            $nome = $projeto['NOME-DO-PROJETO'] ?? 'N/A';
            $anoInicio = $projeto['ANO-INICIO'] ?? 'N/A';
            $anoFim = $projeto['ANO-FIM'] ?? 'N/A';
            $situacao = $projeto['SITUACAO'] ?? 'N/A';
            $natureza = $projeto['NATUREZA'] ?? 'N/A';
            $descricao = $projeto['DESCRICAO-DO-PROJETO'] ?? 'N/A';

            // Tratamento de Equipe
            // A equipe é um nó irmão de '@attributes'
            $equipeContainer = $projetoData['EQUIPE-DO-PROJETO'] ?? [];
            $integrantes = $equipeContainer['INTEGRANTES-DO-PROJETO'] ?? [];
            
            // Se não encontrou em INTEGRANTES-DO-PROJETO, tenta usar o container direto (fallback)
            if (empty($integrantes) && !empty($equipeContainer) && !isset($equipeContainer['INTEGRANTES-DO-PROJETO'])) {
                 $integrantes = $equipeContainer;
            }

            $equipeLista = $this->normalizarLista($integrantes);
            
            $equipeNomes = [];
            $coordenadores = [];
            
            foreach ($equipeLista as $integranteItem) {
                // Os dados de cada integrante também estão em '@attributes'
                $integrante = $integranteItem['@attributes'] ?? $integranteItem;

                $nomeInt = $integrante['NOME-COMPLETO'] ?? 'N/A';
                $equipeNomes[] = $nomeInt;
                
                // Verifica flag de responsável/coordenador
                $flagResponsavel = $integrante['FLAG-RESPONSAVEL'] ?? 'NAO';
                if (strtoupper($flagResponsavel) === 'SIM') {
                    $coordenadores[] = $nomeInt;
                }
            }
            
            $equipeStr = implode('; ', $equipeNomes);
            $coordenadorStr = implode('; ', $coordenadores);

            // Tratamento de Financiadores
            // Os financiadores são um nó irmão de '@attributes'
            $financiadoresLista = [];
            if (isset($projetoData['FINANCIADORES-DO-PROJETO'])) {
                $financiadoresRaw = $projetoData['FINANCIADORES-DO-PROJETO']['FINANCIADOR-DO-PROJETO'] ?? $projetoData['FINANCIADORES-DO-PROJETO'];
                $financiadoresLista = $this->normalizarLista($financiadoresRaw);
            }

            $financiadoresStr = [];
            $conveniosStr = [];
            
            foreach ($financiadoresLista as $financiadorItem) {
                // Os dados de cada financiador também estão em '@attributes'
                $financiador = $financiadorItem['@attributes'] ?? $financiadorItem;
                $inst = $financiador['NOME-INSTITUICAO'] ?? '';
                $natFin = $financiador['NATUREZA'] ?? '';
                $conv = $financiador['NUMERO-CONVENIO'] ?? '';
                
                if ($inst) {
                    $info = $inst;
                    if ($natFin) $info .= " ({$natFin})";
                    $financiadoresStr[] = $info;
                }
                
                if ($conv) {
                    $conveniosStr[] = $conv;
                }
            }
            
            $financiadoresCol = implode('; ', $financiadoresStr);
            $conveniosCol = implode('; ', $conveniosStr);

            $projetosFormatados[] = [
                'NOME-DO-PROJETO' => $nome,
                'ANO-INICIO' => $anoInicio,
                'ANO-FIM' => $anoFim,
                'SITUACAO' => $situacao,
                'NATUREZA' => $natureza,
                'DESCRICAO-DO-PROJETO' => $descricao,
                'COORDENADORES' => $coordenadorStr,
                'EQUIPE-DO-PROJETO' => $equipeStr,
                'FINANCIADORES' => $financiadoresCol,
                'NUMERO-CONVENIO' => $conveniosCol,
            ];
        }
        return $projetosFormatados;
    }

    /**
     * Normaliza um item que pode ser um array associativo (item único) ou uma lista de arrays (vários itens).
     */
    private function normalizarLista($item): array
    {
        if (empty($item) || !is_array($item)) {
            return [];
        }

        // Se a chave 0 existe, é uma lista numérica (lista de objetos)
        if (isset($item[0])) {
            return $item;
        }

        // Caso contrário, é um único objeto (array associativo), retornamos envolto em array
        return [$item];
    }

    /**
     * Manipulador específico para 'bancasMestrado'.
     */
    private function processarBancasMestrado(array $data): array
    {
        $bancasFormatadas = [];
        foreach ($data as $banca) {
            if (is_array($banca) && isset($banca['DADOS-BASICOS-DA-PARTICIPACAO-EM-BANCA-DE-MESTRADO']['@attributes'])) {
                $dadosBasicos = $banca['DADOS-BASICOS-DA-PARTICIPACAO-EM-BANCA-DE-MESTRADO']['@attributes'];
                $detalhamento = $banca['DETALHAMENTO-DA-PARTICIPACAO-EM-BANCA-DE-MESTRADO']['@attributes'] ?? [];
                $bancasFormatadas[] = [
                    'TITULO' => $dadosBasicos['TITULO'] ?? 'N/A',
                    'ANO' => $dadosBasicos['ANO'] ?? 'N/A',
                    'CANDIDATO' => $detalhamento['NOME-DO-CANDIDATO'] ?? 'N/A',
                ];
            } elseif (is_string($banca)) {
                $bancasFormatadas[] = ['TITULO' => $banca, 'ANO' => 'N/A', 'CANDIDATO' => 'N/A'];
            }
        }
        return $bancasFormatadas;
    }

    /**
     * Manipulador específico para 'bancasDoutorado'.
     */
    private function processarBancasDoutorado(array $data): array
    {
        $bancasFormatadas = [];
        foreach ($data as $banca) {
            if (is_array($banca) && isset($banca['DADOS-BASICOS-DA-PARTICIPACAO-EM-BANCA-DE-DOUTORADO']['@attributes'])) {
                $dadosBasicos = $banca['DADOS-BASICOS-DA-PARTICIPACAO-EM-BANCA-DE-DOUTORADO']['@attributes'];
                $detalhamento = $banca['DETALHAMENTO-DA-PARTICIPACAO-EM-BANCA-DE-DOUTORADO']['@attributes'] ?? [];
                $bancasFormatadas[] = [
                    'TITULO' => $dadosBasicos['TITULO'] ?? 'N/A',
                    'ANO' => $dadosBasicos['ANO'] ?? 'N/A',
                    'CANDIDATO' => $detalhamento['NOME-DO-CANDIDATO'] ?? 'N/A',
                ];
            } elseif (is_string($banca)) {
                $bancasFormatadas[] = ['TITULO' => $banca, 'ANO' => 'N/A', 'CANDIDATO' => 'N/A'];
            }
        }
        return $bancasFormatadas;
    }

    /**
     * Manipulador específico para Membro de Comitê de Assessoramento.
     */
    private function processarMembroComiteAssessoramento(array $data): array
    {
        $formatado = [];
        foreach ($data as $item) {
            $formatado[] = [
                'NOME-INSTITUICAO' => $item['NOME-INSTITUICAO'] ?? 'N/A',
                'ANO-INICIO' => $item['ANO-INICIO'] ?? 'N/A',
                'ANO-FIM' => $item['ANO-FIM'] ?? 'N/A',
                'TIPO-DE-VINCULO' => $item['TIPO-DE-VINCULO'] ?? 'N/A',
                'OUTRO-VINCULO-INFORMADO' => $item['OUTRO-VINCULO-INFORMADO'] ?? 'N/A',
                'OUTRAS-INFORMACOES' => $item['OUTRAS-INFORMACOES'] ?? 'N/A',
            ];
        }
        return $formatado;
    }
}
