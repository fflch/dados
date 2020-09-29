<?php

namespace App\Http\Controllers;

use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class AlunosAtivosGradTipoIngressoController extends Controller
{
    private $data;
    private $excel;
    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];

        // Array com os tipos de ingresso cadastrados no banco dos alunos de graduação. 
        $ingresso = [
                    'Vestibular',
                    'Vestibular%Lista',
                    '%SISU%',
                    'Transf USP',
                    'Transf Externa',
                    'Conv%',
                    'Cortesia Diplom%',
                    'Liminar',
                    'REGULAR',
                    'processo seletivo',
                    'ESPECIAL',
                    'Especial',
                    'anterior a out/2002',
        ];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_ativos_ingresso.sql');

        /* Contabiliza alunos da Graduação por tipo de ingresso */
        foreach ($ingresso as $tipo) {
            $query_por_tipo = str_replace('__tipo__', $tipo, $query);
            $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query_por_tipo);
            $data[$tipo] = $result['computed'];
        }
        $this->data = $data;
    }

    public function grafico()
    {
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;
        $chart->labels([
            'Vesitbular',
            'Vestibular Lista de espera',
            'SISU',
            'Transferência interna USP',
            'Transferência externa',
            'Convênio',
            'Cortesia Diplomática',
            'Liminar',
            'REGULAR',
            'Processo seletivo',
            'ESPECIAL',
            'Especial',
            'Anterior a out/2002',
        ]);
        $chart->dataset('Quantidade', 'bar', array_values($this->data));

        return view('ativosAlunosGradTipoIngresso', compact('chart'));
    }

    public function export($format)
    {
        if ($format == 'excel') {
            $export = new DadosExport([$this->data], array_keys($this->data));
            return $this->excel->download($export, 'alunos_ativos_grad_ingresso.xlsx');
        }
    }
}