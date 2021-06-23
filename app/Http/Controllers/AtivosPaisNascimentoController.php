<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use Uspdev\Replicado\DB;
use App\Exports\DadosExport;
use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;


class AtivosPaisNascimentoController extends Controller
{
    private $data;
    private $excel;
    private $tipo_vinculo;

    public function __construct(Excel $excel, Request $request){
        $this->excel = $excel;

        $data = [];

        $vinculos = [
            0 => "ALUNOCEU",
            1 => "ALUNOPOS",
            2 => "ALUNOGR",
            3 => "ALUNOPD",
            4 => "SERVIDOR"
        ];

        $nacionalidades = [
            0 => ['nome' => 'Nascidos no Brasil', 'where' => 'AND cp.codpasnas = 1'],
            1 => ['nome' => 'Estrangeiros', 'where' => 'AND cp.codpasnas <> 1 AND cp.codpasnas <> NULL'],
            2 => ['nome' => 'Sem informações', 'where' => 'AND cp.codpasnas = NULL']
        ];

        $this->tipo_vinculo = $request->route()->parameter('tipo_vinculo') ?? 0;
        $nome_vinculo = isset($vinculos[$this->tipo_vinculo]) ? $vinculos[$this->tipo_vinculo] : 'Vínculo não encontrado';

        /* Contabiliza alunos e docentes nascidos e não nascidos no BR */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ativos_nacionalidade.sql');
        foreach ($nacionalidades as $nacionalidade){
            $query_por_vinculo = str_replace('__vinculo__', $nome_vinculo, $query);

            if($nome_vinculo == 'SERVIDOR'){
                $query_por_vinculo = str_replace('__codpasnas__', $nacionalidade['where']." AND lp.tipvinext = 'Docente'", $query_por_vinculo);
            
            } else {
                $query_por_vinculo = str_replace('__codpasnas__', $nacionalidade['where'], $query_por_vinculo);
            }
            $result = DB::fetch($query_por_vinculo);

            $data[$nacionalidade['nome']] = $result['computed'];    
        }
    
        $this->data = $data;
    }    
    
    public function grafico(){
       
        $tipo_vinculo = $this->tipo_vinculo;

        switch((int)$tipo_vinculo){
            case 0:
                $nome_vinculo = 'Alunos de Cultura e Extensão';
                break;
            case 1:
                $nome_vinculo = 'Alunos de Pós-Graduação';
                break;
            case 2:
                $nome_vinculo = 'Alunos de Graduação';
                break;
            case 3:
                $nome_vinculo = 'Alunos de Pós-Doutorado';
                break;
            case 4:
                $nome_vinculo = 'Docentes';
                break;
            default:
                $nome_vinculo = "Vínculo não encontrado";
        }



        $lava = new Lavacharts; // See note below for Laravel

        $ativos  = $lava->DataTable();

        $formatter = $lava->NumberFormat([ 
            'pattern' => '#.###',
        ]);
        $ativos->addStringColumn('Nacionalidade')
            ->addNumberColumn($nome_vinculo. ' - quantidade');
            
        foreach($this->data as $key=>$data) {
            $ativos->addRow([$key, $data]);
        }


        $lava->ColumnChart('Ativos', $ativos, [
            'legend' => [
                'position' => 'top',
                'alignment' => 'center',
                
            ],
            'height' => 500,
            'vAxis' => ['format' => 0],
            'colors' => ['#273e74']

        ]);

        return view('ativosPaisNascimento', compact('tipo_vinculo', 'nome_vinculo', 'lava'));
    }

    public function export($format){       
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'ativos_nascimento.xlsx');
        }
    }
}
