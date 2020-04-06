<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;
use Uspdev\Cache\Cache;

class AtivosPorDepartamentoFuncionariosController extends Controller
{
    private $data;

    public function __construct(){

        $cache = new Cache();
        $data = [];

        /* Contabiliza funcionários ativos no setor de Geografia */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_funcionarios_geografia.sql');

        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Geografia'] = $result['computed'];

        /* Contabiliza funcionários ativos no setor de Antropologia */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_funcionarios_antropologia.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Antropologia'] = $result['computed'];

        /* Contabiliza funcionários ativos no setor de Ciência Política */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_funcionarios_ciencia_politica.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Ciência Política'] = $result['computed'];

        /* Contabiliza funcionários ativos no setor de Filosofia */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_funcionarios_filosofia.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Filosofia'] = $result['computed'];

        /* Contabiliza funcionários ativos no setor de História */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_funcionarios_historia.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['História'] = $result['computed'];

        /* Contabiliza funcionários ativos no setor de Letras Clássicas e Vernáculas */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_funcionarios_letras_classicas_e_vernaculas.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Letras Clássicas e Vernáculas'] = $result['computed'];

        /* Contabiliza funcionários ativos no setor de Letras Modernas */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_funcionarios_letras_modernas.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Letras Modernas'] = $result['computed'];

        /* Contabiliza funcionários ativos no setor de Letras Orientais */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_funcionarios_letras_orientais.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Letras Orientais'] = $result['computed'];

        /* Contabiliza funcionários ativos no setor de Linguística */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_funcionarios_linguistica.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Linguística'] = $result['computed'];

        /* Contabiliza funcionários ativos no setor de Sociologia */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_funcionarios_sociologia.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Sociologia'] = $result['computed'];

        /* Contabiliza funcionários ativos no setor de Teoria Literária e Literatura Comparada */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_funcionarios_teoria_literária_e_literatura_comparada.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Teoria Literária e Literatura Comparada'] = $result['computed'];

        $this->data = $data;
    }    
    
    public function grafico(){
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;

        $chart->labels(array_keys($this->data));
        $chart->dataset('Quantidade', 'pie', array_values($this->data));

        return view('ativosFuncionariosDepartamento', compact('chart'));
    }

    public function csv(){

        $data = collect($this->data);
        $csvExporter = new \Laracsv\Export(); //dd($data);
        $csvExporter->build($data, ['vinculo', 'quantidade'])->download();

    }

}
