<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ArraySheetWithHeaderExport extends ArraySheetExport implements FromArray, WithHeadings, WithTitle
{
    public function headings(): array
    {
        if (empty($this->data)) {
            return [];
        }

        // Mapa de tradução de chaves para nomes de colunas legíveis
        $headerMap = [
            // Genérico
            'TITULO' => 'Título',
            'ANO' => 'Ano',
            'TIPO' => 'Tipo',
            'NOME' => 'Nome',
            'AUTORES' => 'Autores',

            // Bancas
            'CANDIDATO' => 'Candidato(a)',

            // Eventos
            'TIPO_EVENTO' => 'Tipo de Evento',
            'NOME_EVENTO' => 'Nome do Evento',
            'FORMA_PARTICIPACAO' => 'Forma de Participação',
            'LOCAL_EVENTO' => 'Local',

            // Formação
            'NOME_INSTITUICAO' => 'Instituição',
            'instituicao' => 'Instituição',
            'titulo' => 'Título/Curso',
            'anoConclusao' => 'Ano de Conclusão',
            'nivel' => 'Nível',
            'Descrição' => 'Título', // Para listas simples

            // Projetos
            'NOME-DO-PROJETO' => 'Nome do Projeto',
            'ANO-INICIO' => 'Ano Início',
            'ANO-FIM' => 'Ano Fim',
            'SITUACAO' => 'Situação',
            'NATUREZA' => 'Natureza',
            'DESCRICAO-DO-PROJETO' => 'Descrição',
            'COORDENADORES' => 'Coordenador(es)',
            'EQUIPE-DO-PROJETO' => 'Equipe',
            'FINANCIADORES' => 'Financiadores',
            'NUMERO-CONVENIO' => 'Número(s) Convênio',
        ];

        // Pega as chaves do primeiro item para usar como cabeçalho
        $firstItem = reset($this->data);
        $keys = is_array($firstItem) ? array_keys($firstItem) : ['Descrição'];

        // Traduz as chaves para os nomes do mapa, se existirem, senão usa a própria chave
        return array_map(function ($key) use ($headerMap) {
            return $headerMap[$key] ?? ucwords(str_replace(['_', '-'], ' ', $key));
        }, $keys);
    }
}