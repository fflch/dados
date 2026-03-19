<?php

namespace App\Services\Replicado;

use Uspdev\Replicado\Lattes as LattesBase;
use Illuminate\Support\Arr;

class Lattes extends LattesBase
{
    /**
     * Recebe o número USP e devolve array com as participações em eventos e congressos.
     *
     * Os campos $tipo, $limit_ini e $limit_fim são usado em diversos métodos e o signifcado e valores default são os mesmos
     * Default: tipo = registro, limit_ini = 5
     *
     * Dependendo de $tipo, o resultado é modificado:
     * $tipo == 'anual': retorna os eventos dos últimos $limit_ini anos
     * $tipo == 'registros': retorna os $limit_ini eventos mais recentes
     * $tipo == 'periodo': retorna todos os eventos dos anos entre $limit_ini e $limit_fim
     *
     * @param Integer $codpes = Número USP
     * @param Array $lattes_array (opcional) Lattes convertido para array
     * @param String $tipo (opcional) Valores possíveis para determinar o limite: 'anual' e 'registros', 'periodo'. Default: últimos 5 registros.
     * @param Integer $limit_ini (opcional) Limite de retorno conforme o tipo.
     * @param Integer $limit_fim (opcional) Se o tipo for periodo, irá pegar os registros do ano entre limit_ini e limit_fim
     * @return Array|Bool
     */
    public static function listarParticipacaoEventos($codpes, $lattes_array = null, $tipo = 'registros', $limit_ini = 5, $limit_fim = null)
    {
        // A chamada a `self::obterArray` funcionará porque nossa classe herda de LattesBase
        if (!$lattes = self::obterArray($codpes, $lattes_array)) {
            return false;
        }

        $eventos = Arr::get($lattes, 'DADOS-COMPLEMENTARES.PARTICIPACAO-EM-EVENTOS-CONGRESSOS', false);
        if (!$eventos) {
            return false;
        }

        $tipos_evento = [
            'PARTICIPACAO-EM-CONGRESSO' => 'Congresso',
            'PARTICIPACAO-EM-SEMINARIO' => 'Seminário',
            'PARTICIPACAO-EM-SIMPOSIO' => 'Simpósio',
            'PARTICIPACAO-EM-OFICINA' => 'Oficina',
            'PARTICIPACAO-EM-ENCONTRO' => 'Encontro',
            'OUTRAS-PARTICIPACOES-EM-EVENTOS-CONGRESSOS' => 'Outro',
        ];

        $todos_eventos = [];
        foreach ($tipos_evento as $chave_lattes => $nome_tipo) {
            $participacoes = Arr::get($eventos, $chave_lattes, []);

            // Normaliza a estrutura: se for um único evento (array associativo), coloca-o dentro de um array numérico.
            if (!empty($participacoes) && !is_numeric(key($participacoes))) {
                $participacoes = [$participacoes];
            }

            foreach ($participacoes as $participacao) {
                // As chaves são dinâmicas, baseadas no tipo de evento (ex: ...-EM-CONGRESSO)
                $dados_basicos_key = str_replace('PARTICIPACAO-EM-', 'DADOS-BASICOS-DA-PARTICIPACAO-EM-', $chave_lattes);
                $detalhamento_key = str_replace('PARTICIPACAO-EM-', 'DETALHAMENTO-DA-PARTICIPACAO-EM-', $chave_lattes);

                $dados_basicos = Arr::get($participacao, "{$dados_basicos_key}.@attributes", []);
                $detalhamento = Arr::get($participacao, "{$detalhamento_key}.@attributes", []);
                $todos_eventos[] = [
                    'TIPO_EVENTO'        => $nome_tipo,
                    'NOME_EVENTO'        => Arr::get($detalhamento, 'NOME-DO-EVENTO', ''),
                    
                    // O campo de ano pode variar, então verificamos as duas possibilidades.
                    'ANO'                => Arr::get($dados_basicos, 'ANO', Arr::get($dados_basicos, 'ANO-DE-REALIZACAO', '')),
                    
                    // A forma de participação está nos dados básicos, não no detalhamento.
                    'FORMA_PARTICIPACAO' => Arr::get($dados_basicos, 'FORMA-PARTICIPACAO', ''),
                    'LOCAL_EVENTO'       => Arr::get($detalhamento, 'LOCAL-DO-EVENTO', ''),
                ];
            }
        }

        // Ordena todos os eventos por ano, do mais recente para o mais antigo
        usort($todos_eventos, function ($a, $b) {
            return (int) $b['ANO'] - (int) $a['ANO'];
        });

        $eventos_filtrados = [];
        $i = 0;
        foreach ($todos_eventos as $evento) {
            $i++;
            // A chamada a `self::verificarFiltro` também funcionará, pois o método é `protected` na classe pai.
            if (self::verificarFiltro($tipo, $evento['ANO'], $limit_ini, $limit_fim, $i)) {
                $eventos_filtrados[] = $evento;
            }
        }

        return $eventos_filtrados;
    }

    /**
     * Lista as linhas de pesquisa ativas de um docente.
     *
     * Este método sobrescreve o da classe pai para retornar mais detalhes
     * e garantir que apenas linhas de pesquisa ativas sejam listadas.
     *
     * @param Integer $codpes
     * @param Array $lattes_array (opcional)
     * @return Array|Bool
     */
    public static function listarLinhasPesquisa($codpes, $lattes_array = null)
    {
        if (!$lattes = $lattes_array ?? self::obterArray($codpes)) {
            return false;
        }

        $linhasDePesquisa = [];
        $atuacoes = Arr::get($lattes, 'DADOS-GERAIS.ATUACOES-PROFISSIONAIS.ATUACAO-PROFISSIONAL', []);

        // Normaliza para um array de atuações
        if (!empty($atuacoes) && !is_numeric(key($atuacoes))) {
            $atuacoes = [$atuacoes];
        }

        foreach ($atuacoes as $atuacao) {
            $pesquisas = Arr::get($atuacao, 'ATIVIDADES-DE-PESQUISA-E-DESENVOLVIMENTO.PESQUISA-E-DESENVOLVIMENTO', []);

            if (!empty($pesquisas) && !is_numeric(key($pesquisas))) {
                $pesquisas = [$pesquisas];
            }

            foreach ($pesquisas as $pesquisa) {
                $linhas = Arr::get($pesquisa, 'LINHA-DE-PESQUISA', []);
                if (!empty($linhas) && !is_numeric(key($linhas))) {
                    $linhas = [$linhas];
                }

                foreach ($linhas as $linha) {
                    $attributes = $linha['@attributes'] ?? null;
                    if ($attributes && ($attributes['FLAG-LINHA-DE-PESQUISA-ATIVA'] ?? 'NAO') === 'SIM') {
                        $linhasDePesquisa[$attributes['TITULO-DA-LINHA-DE-PESQUISA']] = $attributes;
                    }
                }
            }
        }

        return array_values($linhasDePesquisa); // Retorna apenas os valores, reindexando o array
    }

    /**
     * Lista as participações como membro de corpo editorial.
     *
     * @param Integer $codpes
     * @param Array $lattes_array (opcional)
     * @param String $tipo (opcional)
     * @param Integer $limit_ini (opcional)
     * @param Integer $limit_fim (opcional)
     * @return Array|Bool
     */
    public static function listarMembroCorpoEditorial($codpes, $lattes_array = null, $tipo = 'registros', $limit_ini = -1, $limit_fim = null)
    {
        if (!$lattes = $lattes_array ?? self::obterArray($codpes)) {
            return false;
        }

        $atuacoes = Arr::get($lattes, 'DADOS-GERAIS.ATUACOES-PROFISSIONAIS.ATUACAO-PROFISSIONAL', []);

        if (!empty($atuacoes) && !is_numeric(key($atuacoes))) {
            $atuacoes = [$atuacoes];
        }

        $corpoEditorial = [];
        $i = 0;
        foreach ($atuacoes as $atuacao) {
            $vinculos = Arr::get($atuacao, 'VINCULOS', []);
            if (!empty($vinculos) && !is_numeric(key($vinculos))) {
                $vinculos = [$vinculos];
            }

            foreach ($vinculos as $vinculo) {
                $vinculoAttrs = $vinculo['@attributes'] ?? [];
                if (($vinculoAttrs['OUTRO-VINCULO-INFORMADO'] ?? '') === 'Membro de corpo editorial') {
                    $i++;
                    if (self::verificarFiltro($tipo, $vinculoAttrs['ANO-INICIO'], $limit_ini, $limit_fim, $i)) {
                        $corpoEditorial[] = [
                            'NOME-INSTITUICAO' => $atuacao['@attributes']['NOME-INSTITUICAO'] ?? 'N/A',
                            'ANO-INICIO' => $vinculoAttrs['ANO-INICIO'] ?? 'N/A',
                            'ANO-FIM' => $vinculoAttrs['ANO-FIM'] ?? 'N/A',
                        ];
                    }
                }
            }
        }
        return $corpoEditorial;
    }

    /**
     * Lista as participações como membro de comitê de assessoramento.
     *
     * @param Integer $codpes
     * @param Array $lattes_array (opcional)
     * @param String $tipo (opcional)
     * @param Integer $limit_ini (opcional)
     * @param Integer $limit_fim (opcional)
     * @return Array|Bool
     */
    public static function listarMembroComiteAssessoramento($codpes, $lattes_array = null, $tipo = 'registros', $limit_ini = -1, $limit_fim = null)
    {
        if (!$lattes = $lattes_array ?? self::obterArray($codpes)) {
            return false;
        }

        $atuacoes = Arr::get($lattes, 'DADOS-GERAIS.ATUACOES-PROFISSIONAIS.ATUACAO-PROFISSIONAL', []);

        if (!empty($atuacoes) && !is_numeric(key($atuacoes))) {
            $atuacoes = [$atuacoes];
        }

        $comiteAssessoramento = [];
        $i = 0;
        foreach ($atuacoes as $atuacao) {
            $vinculos = Arr::get($atuacao, 'VINCULOS', []);
            if (!empty($vinculos) && !is_numeric(key($vinculos))) {
                $vinculos = [$vinculos];
            }

            foreach ($vinculos as $vinculo) {
                $vinculoAttrs = $vinculo['@attributes'] ?? [];
                if (($vinculoAttrs['OUTRO-VINCULO-INFORMADO'] ?? '') === 'Membro de comitê de assessoramento') {
                    $i++;
                    if (self::verificarFiltro($tipo, $vinculoAttrs['ANO-INICIO'], $limit_ini, $limit_fim, $i)) {
                        $comiteAssessoramento[] = $vinculoAttrs; // Retorna todos os atributos do vínculo
                    }
                }
            }
        }
        return $comiteAssessoramento;
    }

    /**
     * Lista as "Outras Informações Relevantes".
     *
     * @param Integer $codpes
     * @param Array $lattes_array (opcional)
     * @return Array|Bool
     */
    public static function listarOutrasInformacoesRelevantes($codpes, $lattes_array = null)
    {
        if (!$lattes = $lattes_array ?? self::obterArray($codpes)) {
            return false;
        }

        $informacoes = Arr::get($lattes, 'DADOS-GERAIS.OUTRAS-INFORMACOES-RELEVANTES.@attributes.OUTRAS-INFORMACOES-RELEVANTES', '');

        if (empty($informacoes)) {
            return [];
        }

        // O texto é um bloco único com itens separados por ponto e vírgula e quebras de linha.
        // Vamos dividi-los em um array para contagem e melhor exibição.
        $items = preg_split('/;[ \n\r\t]+/', $informacoes);

        // Remove itens vazios resultantes da separação e limpa espaços em branco
        return array_filter(array_map('trim', $items));
    }

    /**
     * Lista todas as orientações em andamento (Mestrado, Doutorado, etc.).
     *
     * @param Integer $codpes
     * @param Array $lattes_array (opcional)
     * @param String $tipo (opcional)
     * @param Integer $limit_ini (opcional)
     * @param Integer $limit_fim (opcional)
     * @return Array|Bool
     */
    public static function listarOrientacoesEmAndamento($codpes, $lattes_array = null, $tipo = 'registros', $limit_ini = -1, $limit_fim = null)
    {
        if (!$lattes = $lattes_array ?? self::obterArray($codpes)) {
            return false;
        }

        $orientacoes = [];
        $tiposDeOrientacao = [
            'ORIENTACAO-EM-ANDAMENTO-DE-MESTRADO' => 'DADOS-BASICOS-DA-ORIENTACAO-EM-ANDAMENTO-DE-MESTRADO',
            'ORIENTACAO-EM-ANDAMENTO-DE-DOUTORADO' => 'DADOS-BASICOS-DA-ORIENTACAO-EM-ANDAMENTO-DE-DOUTORADO',
            'ORIENTACAO-EM-ANDAMENTO-DE-POS-DOUTORADO' => 'DADOS-BASICOS-DA-ORIENTACAO-EM-ANDAMENTO-DE-POS-DOUTORADO',
            'ORIENTACAO-EM-ANDAMENTO-DE-INICIACAO-CIENTIFICA' => 'DADOS-BASICOS-DA-ORIENTACAO-EM-ANDAMENTO-DE-INICIACAO-CIENTIFICA',
        ];

        $caminhoBase = 'DADOS-COMPLEMENTARES.ORIENTACOES-EM-ANDAMENTO';

        foreach ($tiposDeOrientacao as $chaveOrientacao => $chaveDadosBasicos) {
            $items = Arr::get($lattes, "{$caminhoBase}.{$chaveOrientacao}", []);

            if (!empty($items) && !is_numeric(key($items))) {
                $items = [$items];
            }

            foreach ($items as $item) {
                $dadosBasicos = Arr::get($item, "{$chaveDadosBasicos}.@attributes", []);
                $detalhamento = Arr::get($item, str_replace('DADOS-BASICOS', 'DETALHAMENTO', $chaveDadosBasicos) . '.@attributes', []);

                $orientacoes[] = [
                    'NATUREZA' => $dadosBasicos['NATUREZA'] ?? 'N/A',
                    'TITULO' => $dadosBasicos['TITULO-DO-TRABALHO'] ?? 'N/A',
                    'ANO' => $dadosBasicos['ANO'] ?? 'N/A',
                    'NOME_ORIENTANDO' => $detalhamento['NOME-DO-ORIENTANDO'] ?? 'N/A',
                    'TIPO_ORIENTACAO' => $detalhamento['TIPO-DE-ORIENTACAO'] ?? 'N/A',
                    'INSTITUICAO' => $detalhamento['NOME-INSTITUICAO'] ?? 'N/A',
                ];
            }
        }

        // Ordena por ano, do mais recente para o mais antigo
        usort($orientacoes, fn($a, $b) => (int)$b['ANO'] - (int)$a['ANO']);

        // Aplica o filtro de limite (se houver)
        return array_slice($orientacoes, 0, $limit_ini > 0 ? $limit_ini : null);
    }

    /**
     * Lista as "Outras Produções Bibliográficas" (Traduções, Prefácios, etc.).
     *
     * @param Integer $codpes
     * @param Array $lattes_array (opcional)
     * @param String $tipo (opcional)
     * @param Integer $limit_ini (opcional)
     * @param Integer $limit_fim (opcional)
     * @return Array|Bool
     */
    public static function listarOutrasProducoesBibliograficas($codpes, $lattes_array = null, $tipo = 'registros', $limit_ini = -1, $limit_fim = null)
    {
        if (!$lattes = $lattes_array ?? self::obterArray($codpes)) {
            return false;
        }

        $producoes = [];
        $caminhoBase = 'PRODUCAO-BIBLIOGRAFICA.DEMAIS-TIPOS-DE-PRODUCAO-BIBLIOGRAFICA';

        $tiposDeProducao = [
            'OUTRA-PRODUCAO-BIBLIOGRAFICA' => [
                'dados' => 'DADOS-BASICOS-DE-OUTRA-PRODUCAO',
                'detalhes' => 'DETALHAMENTO-DE-OUTRA-PRODUCAO',
                'titulo' => 'TITULO',
                'tipo' => 'NATUREZA'
            ],
            'PREFACIO-POSFACIO' => [
                'dados' => 'DADOS-BASICOS-DO-PREFACIO-POSFACIO',
                'detalhes' => 'DETALHAMENTO-DO-PREFACIO-POSFACIO',
                'titulo' => 'TITULO',
                'tipo' => 'TIPO'
            ],
            'TRADUCAO' => [
                'dados' => 'DADOS-BASICOS-DA-TRADUCAO',
                'detalhes' => 'DETALHAMENTO-DA-TRADUCAO',
                'titulo' => 'TITULO',
                'tipo' => 'NATUREZA'
            ],
        ];

        foreach ($tiposDeProducao as $chaveProducao => $mapa) {
            $items = Arr::get($lattes, "{$caminhoBase}.{$chaveProducao}", []);

            if (!empty($items) && !is_numeric(key($items))) {
                $items = [$items];
            }

            foreach ($items as $item) {
                $dadosBasicos = Arr::get($item, "{$mapa['dados']}.@attributes", []);
                $detalhamento = Arr::get($item, "{$mapa['detalhes']}.@attributes", []);
                $autores = self::listarAutores(Arr::get($item, 'AUTORES', []));

                $producoes[] = [
                    'TITULO' => $dadosBasicos[$mapa['titulo']] ?? 'N/A',
                    'TIPO' => $dadosBasicos[$mapa['tipo']] ?? 'N/A',
                    'ANO' => $dadosBasicos['ANO'] ?? 'N/A',
                    'EDITORA' => $detalhamento['EDITORA-DA-TRADUCAO'] ?? $detalhamento['EDITORA-DO-PREFACIO-POSFACIO'] ?? $detalhamento['EDITORA'] ?? 'N/A',
                    'AUTORES' => $autores,
                ];
            }
        }

        // Ordena por ano, do mais recente para o mais antigo
        usort($producoes, fn($a, $b) => (int)$b['ANO'] - (int)$a['ANO']);

        // Aplica o filtro de limite (se houver)
        return array_slice($producoes, 0, $limit_ini > 0 ? $limit_ini : null);
    }

    /**
     * Helper para listar bancas de qualificação por nível (Mestrado/Doutorado).
     *
     * @param string $natureza O tipo de qualificação a ser filtrada.
     * @param Integer $codpes
     * @param Array $lattes_array (opcional)
     * @return Array|Bool
     */
    private static function listarBancasQualificacaoPorNivel($natureza, $codpes, $lattes_array = null)
    {
        if (!$lattes = $lattes_array ?? self::obterArray($codpes)) {
            return false;
        }

        $bancas = Arr::get($lattes, 'DADOS-COMPLEMENTARES.PARTICIPACAO-EM-BANCA-TRABALHOS-CONCLUSAO.PARTICIPACAO-EM-BANCA-DE-EXAME-QUALIFICACAO', []);

        if (empty($bancas)) {
            return [];
        }

        if (!is_numeric(key($bancas))) {
            $bancas = [$bancas];
        }

        $qualificacoes = [];
        foreach ($bancas as $banca) {
            $dadosBasicos = Arr::get($banca, 'DADOS-BASICOS-DA-PARTICIPACAO-EM-BANCA-DE-EXAME-QUALIFICACAO.@attributes', []);

            if (($dadosBasicos['NATUREZA'] ?? '') === $natureza) {
                $detalhamento = Arr::get($banca, 'DETALHAMENTO-DA-PARTICIPACAO-EM-BANCA-DE-EXAME-QUALIFICACAO.@attributes', []);
                $qualificacoes[] = [
                    'TITULO' => $dadosBasicos['TITULO'] ?? 'N/A',
                    'ANO' => $dadosBasicos['ANO'] ?? 'N/A',
                    'CANDIDATO' => $detalhamento['NOME-DO-CANDIDATO'] ?? 'N/A',
                ];
            }
        }

        return $qualificacoes;
    }

    /**
     * Lista as participações em bancas de qualificação de Doutorado.
     *
     * @param Integer $codpes
     * @param Array $lattes_array (opcional)
     * @return Array|Bool
     */
    public static function listarBancasQualificacaoDoutorado($codpes, $lattes_array = null)
    {
        return self::listarBancasQualificacaoPorNivel('Exame de qualificação de doutorado', $codpes, $lattes_array);
    }

    /**
     * Lista as participações em bancas de qualificação de Mestrado.
     *
     * @param Integer $codpes
     * @param Array $lattes_array (opcional)
     * @return Array|Bool
     */
    public static function listarBancasQualificacaoMestrado($codpes, $lattes_array = null)
    {
        return self::listarBancasQualificacaoPorNivel('Exame de qualificação de mestrado', $codpes, $lattes_array);
    }

    /**
     * Lista as participações em bancas de graduação.
     *
     * @param Integer $codpes
     * @param Array $lattes_array (opcional)
     * @return Array|Bool
     */
    public static function listarBancasGraduacao($codpes, $lattes_array = null)
    {
        if (!$lattes = $lattes_array ?? self::obterArray($codpes)) {
            return false;
        }

        $bancas = Arr::get($lattes, 'DADOS-COMPLEMENTARES.PARTICIPACAO-EM-BANCA-TRABALHOS-CONCLUSAO.PARTICIPACAO-EM-BANCA-DE-GRADUACAO', []);

        if (empty($bancas)) {
            return [];
        }

        if (!is_numeric(key($bancas))) {
            $bancas = [$bancas];
        }

        $graduacao = [];
        foreach ($bancas as $banca) {
            $dadosBasicos = Arr::get($banca, 'DADOS-BASICOS-DA-PARTICIPACAO-EM-BANCA-DE-GRADUACAO.@attributes', []);
            $detalhamento = Arr::get($banca, 'DETALHAMENTO-DA-PARTICIPACAO-EM-BANCA-DE-GRADUACAO.@attributes', []);
            $graduacao[] = [
                'TITULO' => $dadosBasicos['TITULO'] ?? 'N/A',
                'ANO' => $dadosBasicos['ANO'] ?? 'N/A',
                'CANDIDATO' => $detalhamento['NOME-DO-CANDIDATO'] ?? 'N/A',
            ];
        }

        return $graduacao;
    }

    /**
     * Lista as participações em bancas de comissões julgadoras.
     *
     * @param Integer $codpes
     * @param Array $lattes_array (opcional)
     * @return Array|Bool
     */
    public static function listarBancasComissoesJulgadoras($codpes, $lattes_array = null)
    {
        if (!$lattes = $lattes_array ?? self::obterArray($codpes)) {
            return false;
        }

        $comissoes = Arr::get($lattes, 'DADOS-COMPLEMENTARES.PARTICIPACAO-EM-BANCA-JULGADORA', []);
        if (empty($comissoes)) {
            return [];
        }

        $bancas = [];
        // Itera sobre os diferentes tipos de bancas julgadoras (Professor Titular, Concurso, etc.)
        foreach ($comissoes as $tipoBanca => $items) {
            if (!is_array($items)) continue;

            if (!is_numeric(key($items))) {
                $items = [$items];
            }

            foreach ($items as $item) {
                $dadosBasicosKey = str_replace('-', '_', 'DADOS-BASICOS-DA-' . strtoupper($tipoBanca));
                $detalhamentoKey = str_replace('-', '_', 'DETALHAMENTO-DA-' . strtoupper($tipoBanca));

                $dadosBasicos = Arr::get($item, "{$dadosBasicosKey}.@attributes", []);
                $detalhamento = Arr::get($item, "{$detalhamentoKey}.@attributes", []);

                $bancas[] = [
                    'TITULO' => $dadosBasicos['TITULO'] ?? 'N/A',
                    'ANO' => $dadosBasicos['ANO'] ?? 'N/A',
                    'INSTITUICAO' => $detalhamento['NOME-INSTITUICAO'] ?? 'N/A',
                ];
            }
        }
        return $bancas;
    }

    /**
     * Helper para filtrar projetos por natureza.
     *
     * @param Integer $codpes
     * @param String $natureza
     * @param Array $lattes_array
     * @param String $tipo
     * @param Integer $limit_ini
     * @param Integer $limit_fim
     * @return Array|Bool
     */
    protected static function listarProjetosPorNatureza($codpes, $natureza, $lattes_array = null, $tipo = 'registros', $limit_ini = 5, $limit_fim = null)
    {
        // Chama o método da classe pai para obter todos os projetos, que já aplica a filtragem por ano/limite
        $allProjects = parent::listarProjetosPesquisa($codpes, $lattes_array, $tipo, $limit_ini, $limit_fim);

        if (!$allProjects) {
            return false;
        }

        $filteredProjects = Arr::where($allProjects, function ($project) use ($natureza) {
            return Arr::get($project, 'NATUREZA') === $natureza;
        });

        return array_values($filteredProjects); // Reindexa o array
    }

    /**
     * Recebe o número USP e devolve array com os projetos de pesquisa.
     * Este método sobrescreve o método da classe pai para retornar apenas projetos de natureza 'PESQUISA'.
     *
     * @param Integer $codpes = Número USP
     * @param Array $lattes_array (opcional) Lattes convertido para array
     * @param String $tipo (opcional) Valores possíveis para determinar o limite: 'anual' e 'registros', 'periodo'. Default: últimos 5 registros.
     * @param Integer $limit_ini (opcional) Limite de retorno conforme o tipo.
     * @param Integer $limit_fim (opcional) Se o tipo for periodo, irá pegar os registros do ano entre limit_ini e limit_fim
     * @return Array|Bool
     */
    public static function listarProjetosPesquisa($codpes, $lattes_array = null, $tipo = 'registros', $limit_ini = 5, $limit_fim = null)
    {
        return self::listarProjetosPorNatureza($codpes, 'PESQUISA', $lattes_array, $tipo, $limit_ini, $limit_fim);
    }

    /**
     * Recebe o número USP e devolve array com os projetos de extensão.
     *
     * @param Integer $codpes = Número USP
     * @param Array $lattes_array (opcional) Lattes convertido para array
     * @param String $tipo (opcional) Valores possíveis para determinar o limite: 'anual' e 'registros', 'periodo'. Default: últimos 5 registros.
     * @param Integer $limit_ini (opcional) Limite de retorno conforme o tipo.
     * @param Integer $limit_fim (opcional) Se o tipo for periodo, irá pegar os registros do ano entre limit_ini e limit_fim
     * @return Array|Bool
     */
    public static function listarProjetosExtensao($codpes, $lattes_array = null, $tipo = 'registros', $limit_ini = 5, $limit_fim = null)
    {
        return self::listarProjetosPorNatureza($codpes, 'EXTENSAO', $lattes_array, $tipo, $limit_ini, $limit_fim);
    }

    /**
     * Recebe o número USP e devolve array com os projetos de desenvolvimento.
     *
     * @param Integer $codpes = Número USP
     * @param Array $lattes_array (opcional) Lattes convertido para array
     * @param String $tipo (opcional) Valores possíveis para determinar o limite: 'anual' e 'registros', 'periodo'. Default: últimos 5 registros.
     * @param Integer $limit_ini (opcional) Limite de retorno conforme o tipo.
     * @param Integer $limit_fim (opcional) Se o tipo for periodo, irá pegar os registros do ano entre limit_ini e limit_fim
     * @return Array|Bool
     */
    public static function listarProjetosDesenvolvimento($codpes, $lattes_array = null, $tipo = 'registros', $limit_ini = 5, $limit_fim = null)
    {
        return self::listarProjetosPorNatureza($codpes, 'DESENVOLVIMENTO', $lattes_array, $tipo, $limit_ini, $limit_fim);
    }

    /**
     * Recebe o número USP e devolve array com os projetos de ensino.
     *
     * @param Integer $codpes = Número USP
     * @param Array $lattes_array (opcional) Lattes convertido para array
     * @param String $tipo (opcional) Valores possíveis para determinar o limite: 'anual' e 'registros', 'periodo'. Default: últimos 5 registros.
     * @param Integer $limit_ini (opcional) Limite de retorno conforme o tipo.
     * @param Integer $limit_fim (opcional) Se o tipo for periodo, irá pegar os registros do ano entre limit_ini e limit_fim
     * @return Array|Bool
     */
    public static function listarProjetosEnsino($codpes, $lattes_array = null, $tipo = 'registros', $limit_ini = 5, $limit_fim = null)
    {
        return self::listarProjetosPorNatureza($codpes, 'ENSINO', $lattes_array, $tipo, $limit_ini, $limit_fim);
    }

    /**
     * Recebe o número USP e devolve array com outros tipos de projetos.
     *
     * @param Integer $codpes = Número USP
     * @param Array $lattes_array (opcional) Lattes convertido para array
     * @param String $tipo (opcional) Valores possíveis para determinar o limite: 'anual' e 'registros', 'periodo'. Default: últimos 5 registros.
     * @param Integer $limit_ini (opcional) Limite de retorno conforme o tipo.
     * @param Integer $limit_fim (opcional) Se o tipo for periodo, irá pegar os registros do ano entre limit_ini e limit_fim
     * @return Array|Bool
     */
    public static function listarOutrosProjetos($codpes, $lattes_array = null, $tipo = 'registros', $limit_ini = 5, $limit_fim = null)
    {
        return self::listarProjetosPorNatureza($codpes, 'OUTRA', $lattes_array, $tipo, $limit_ini, $limit_fim);
    }
}