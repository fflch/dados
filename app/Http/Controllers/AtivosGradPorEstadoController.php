<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Khill\Lavacharts\Lavacharts;
use Uspdev\Replicado\DB;

class AtivosGradPorEstadoController extends Controller
{
    private $data;
    private $excel;
    public function __construct(Excel $excel){
        $this->excel = $excel;
        $data = [];

        $siglas = [
            'AC'=>'Acre',
            'AL'=>'Alagoas',
            'AP'=>'Amapá',
            'AM'=>'Amazonas',
            'BA'=>'Bahia',
            'CE'=>'Ceará',
            'DF'=>'Distrito Federal',
            'ES'=>'Espírito Santo',
            'GO'=>'Goiás',
            'MA'=>'Maranhão',
            'MT'=>'Mato Grosso',
            'MS'=>'Mato Grosso do Sul',
            'MG'=>'Minas Gerais',
            'PA'=>'Pará',
            'PB'=>'Paraíba',
            'PR'=>'Paraná',
            'PE'=>'Pernambuco',
            'PI'=>'Piauí',
            'RJ'=>'Rio de Janeiro',
            'RN'=>'Rio Grande do Norte',
            'RS'=>'Rio Grande do Sul',
            'RO'=>'Rondônia',
            'RR'=>'Roraima',
            'SC'=>'Santa Catarina',
            'SP'=>'São Paulo',
            'SE'=>'Sergipe',
            'TO'=>'Tocantins'
        ];

        /* Contabiliza alunos da Graduação, Pós Graduação, Pós Doutorado e Cultura e Extensão
        nascidos no estado escolhido */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_por_estado.sql');
        foreach ($siglas as $key => $sigla){
            $query_por_estado = str_replace('__sigla__', $key, $query); 
            $result = DB::fetch($query_por_estado);
            $data[$sigla] = $result['computed'];  
        }            

        $this->data = $data;
    }    

    public function grafico(){
        $lava = new Lavacharts; 

        $estados = $lava->DataTable();

        $estados->addStringColumn('Estados')
                ->addNumberColumn('Percent');

        foreach($this->data as $key=>$data) {
            $estados->addRow([$key, (int)$data]);
        }
        
        $lava->PieChart('Estados', $estados, [
            'title'  => 'Quantidade de Alunos de Gradução, Pós Graduação, Pós Doutorado e de Cultura e Extensão da FFLCH por estado.',
            'is3D'   => true,
            'height' => 700,

        ]);

        return view('ativosAlunosEstado', compact('lava'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'alunos_ativos_por_estado.xlsx');
        }
    }
}