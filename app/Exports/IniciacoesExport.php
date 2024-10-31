<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IniciacoesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Recupera os dados do banco de dados
        $iniciacoes = DB::connection('etl')->table('iniciacoes')
            ->where('nome_departamento', 'LIKE', 'H%')
            ->get();

        // Aqui você pode manter a conversão de caracteres, se necessário
        foreach ($iniciacoes as $iniciacao) {
            $iniciacao->nome_departamento = iconv('ISO-8859-1', 'UTF-8//IGNORE', $iniciacao->nome_departamento);
            $iniciacao->titulo_projeto = iconv('ISO-8859-1', 'UTF-8//IGNORE', $iniciacao->titulo_projeto);
        }

        return $iniciacoes;
    }

    public function headings(): array
    {
        return [
            'ID Projeto',
            'Número USP',
            'Situação do Projeto',
            'Data de Início',
            'Data de Fim',
            'Ano do Projeto',
            'Código do Departamento',
            'Nome do Departamento',
            'Número USP do Orientador',
            'Título do Projeto',
            'Palavras-Chave',
        ];
    }

    public function exportExcel()
    {
        return Excel::download(new IniciacoesExport(), 'iniciacoes.xlsx', \Maatwebsite\Excel\Excel::XLSX, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8',
        ]);
    }
}
