<?php

namespace App\Exports;

use App\Services\LattesMetricsService;
use Maatwebsite\Excel\Concerns\FromArray;

class DocenteExport implements FromArray
{
    protected $codpes;

    public function __construct($codpes)
    {
        $this->codpes = $codpes;
    }

    public function array(): array
    {
        $service = new LattesMetricsService();
        $dados = $service->getMetricasDetalhadas($this->codpes);

        // Exporta apenas as contagens com nomes legíveis
        $formatado = [];
        foreach ($dados['contagem'] as $chave => $valor) {
            $formatado[] = [ucwords(str_replace('-', ' ', $chave)), $valor];
        }

        return $formatado;
    }
}
