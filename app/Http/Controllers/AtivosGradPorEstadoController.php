<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;
use Uspdev\Cache\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;

class AtivosGradPorEstadoController extends Controller
{
    private $data;
    private $excel;
    public function __construct(Excel $excel){
        $this->excel = $excel;
        $cache = new Cache();
        $data = [];

        /* Contabiliza alunos da Graduação nascidos no estado SP */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_SP.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['SP'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado RJ */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_RJ.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['RJ'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado MG */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_MG.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['MG'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado BA */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_BA.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['BA'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado CE */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_CE.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['CE'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado AL */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_AL.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['AL'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado PR */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_PR.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['PR'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado TO */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_TO.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['TO'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado AC */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_AC.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['AC'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado PA */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_PA.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['PA'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado RR */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_RR.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['RR'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado PE */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_PE.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['PE'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado RO */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_RO.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['RO'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado DF */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_DF.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['DF'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado Es */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_ES.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['ES'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado MT */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_MT.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['MT'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado MS */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_MS.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['MS'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado MA */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_MA.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['MA'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado PI */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_PI.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['PI'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado RN */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_RN.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['RN'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado SE */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_SE.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['SE'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado PB */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_PB.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['PB'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado GO */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_GO.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['GO'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado AP */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_AP.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['AP'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado SC */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_SC.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['SC'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado SC */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_AM.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['AM'] = $result['computed'];

        /* Contabiliza alunos da Graduação nascidos no estado SC */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_aluno_RS.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['RS'] = $result['computed'];

        $this->data = $data;
    }    
    
    public function grafico(){
        /* Tipos de gráficos:
         * https://www.highcharts.com/docs/chart-and-series-types/chart-types
         */
        $chart = new GenericChart;

        $chart->labels(array_keys($this->data));
        $chart->dataset('Quantidade', 'pie', array_values($this->data));

        return view('ativosAlunosEstado', compact('chart'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'alunos_ativos_por_estado.xlsx');
        }
    }
}
