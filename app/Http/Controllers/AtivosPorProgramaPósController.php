<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GenericChart;
use Uspdev\Cache\Cache;

class AtivosPorProgramaPósController extends Controller
{
    private $data;

    public function __construct(){

        $cache = new Cache();
        $data = [];

        /* Contabiliza alunos de pós graduação ativos no programa de Estudos Lingüísticos e Literários em Inglês */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_estudos_linguisticos_ingles.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Estudos Lingüísticos e Literários em Inglês'] = $result['computed'];

        /* Contabiliza alunos de pós graduação ativos no programa de Estudos da Tradução */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_estudos_traducao.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Estudos da Tradução'] = $result['computed'];

        /* Contabiliza alunos de pós graduação ativos no programa de Filosofia */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_filosofia.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Filosofia'] = $result['computed'];

        /* Contabiliza alunos de pós graduação ativos no programa de Língua Espanhola e Literaturas Espanhola e HispanoAmericana */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_lingua_espanhola.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Língua Espanhola e Literaturas Espanhola e HispanoAmericana'] = $result['computed'];

        /* Contabiliza alunos de pós graduação ativos no programa de Língua e Literatura Alemão */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_lingua_alemao.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Língua e Literatura Alemão'] = $result['computed'];

        /* Contabiliza alunos de pós graduação ativos no programa de Língua e Literatura Francesa */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_lingua_francesa.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Língua e Literatura Francesa'] = $result['computed'];

        /* Contabiliza alunos de pós graduação ativos no programa de Língua, Literatura e Cultura Italianas */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_lingua_italiana.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Língua, Literatura e Cultura Italianas'] = $result['computed'];

        /* Contabiliza alunos de pós graduação ativos no programa de Sociologia */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_sociologia.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Sociologia'] = $result['computed'];

        /* Contabiliza alunos de pós graduação ativos no programa de Antropologia Social */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_antropologia_social.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Antropologia Social'] = $result['computed'];

        /* Contabiliza alunos de pós graduação ativos no programa de Ciência Política */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_ciencia_politica.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Ciência Política'] = $result['computed'];

        /* Contabiliza alunos de pós graduação ativos no programa de Estudos Comparados de Literaturas de Língua Portuguesa */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_estudos_comparados.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Estudos Comparados de Literaturas de Língua Portuguesa'] = $result['computed'];

        /* Contabiliza alunos de pós graduação ativos no programa de Estudos Judaicos */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_estudos_judaicos.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Estudos Judaicos'] = $result['computed'];

        /* Contabiliza alunos de pós graduação ativos no programa de Filologia e Língua Portuguesa */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_filologia.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Filologia e Língua Portuguesa'] = $result['computed'];

        /* Contabiliza alunos de pós graduação ativos no programa de Geografia Física */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_geo_fisica.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Geografia Física'] = $result['computed'];

        /* Contabiliza alunos de pós graduação ativos no programa de Geografia Humana */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_geo_humana.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Geografia Humana'] = $result['computed'];

        /* Contabiliza alunos de pós graduação ativos no programa de História Econômica */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_hist_economica.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['História Econômica'] = $result['computed'];

        /* Contabiliza alunos de pós graduação ativos no programa de História Social */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_hist_social.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['História Social'] = $result['computed'];

        /* Contabiliza alunos de pós graduação ativos no programa de Humanidades, Direitos e Outras Legitimidades */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_humanidades_direitos.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Humanidades, Direitos e Outras Legitimidades'] = $result['computed'];

        /* Contabiliza alunos de pós graduação ativos no programa de Letras Clássicas */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_letras_classicas.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Letras Clássicas'] = $result['computed'];
        
        /* Contabiliza alunos de pós graduação ativos no programa de Letras Estrangeiras e Tradução */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_letras_estrangeiras.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Letras Estrangeiras e Tradução'] = $result['computed'];

        /* Contabiliza alunos de pós graduação ativos no programa de Lingüística: Semiótica e Lingüística Geral */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_linguistica.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Lingüística: Semiótica e Lingüística Geral'] = $result['computed'];

        /* Contabiliza alunos de pós graduação ativos no programa de Literatura Brasileira */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_lb.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Literatura Brasileira'] = $result['computed'];

        /* Contabiliza alunos de pós graduação ativos no programa de Literatura Portuguesa */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_lp.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Literatura Portuguesa'] = $result['computed'];

        /* Contabiliza alunos de pós graduação ativos no programa de Língua, Literatura e Cultura Japonesa */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_lingua_japonesa.sql');
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetch',$query);
        $data['Língua, Literatura e Cultura Japonesa'] = $result['computed'];

        /* Contabiliza alunos de pós graduação ativos no programa de Teoria Literária e Literatura Comparada */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_pos_teoria_literaria.sql');
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
        $chart->dataset('Quantidade', 'bar', array_values($this->data));

        return view('ativosPorProgramaPos', compact('chart'));
    }

    public function csv(){

        $data = collect($this->data);
        $csvExporter = new \Laracsv\Export(); //dd($data);
        $csvExporter->build($data, ['vinculo', 'quantidade'])->download();

    }

}
