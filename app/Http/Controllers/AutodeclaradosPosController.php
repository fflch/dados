<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class AutodeclaradosPosController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];

        /* Contabiliza alunos indígenas da pós-graduação por raça/cor */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ativos_pos_indigenas.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query);
        $data['Indígena'] = $result['computed'];

        /* Contabiliza alunos brancos(as) da pós-graduação por raça/cor */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ativos_pos_brancas.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query);
        $data['Branca'] = $result['computed'];

        /* Contabiliza alunos negros(as) da pós-graduação por raça/cor */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ativos_pos_negras.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query);
        $data['Preta / negra'] = $result['computed'];

        /* Contabiliza alunos amarelo(as) da pós-graduação por raça/cor */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ativos_pos_amarelas.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query);
        $data['Amarela*'] = $result['computed'];

        /* Contabiliza alunos pardos(as) da pós-graduação por raça/cor */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ativos_pos_pardas.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query);
        $data['Parda**'] = $result['computed'];

        /* Contabiliza alunos da pós-graduação não autodeclarados ou sem informações de raça/cor */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ativos_pos_raca_nao_informada.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch', $query);
        $data['Não informado***'] = $result['computed'];

        $this->data = $data;
    }

    public function grafico()
    {
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;

        $chart->labels(array_keys($this->data));
        $chart->dataset('Quantidade de alunos(as) da Pós-Graduação contabilizados por raça/cor.', 'bar', array_values($this->data));

        return view('autodeclaradosPosAtivos', compact('chart'));
    }

    public function export($format)
    {
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'auto_declarados_pos.xlsx'); 
        }
    }
}
