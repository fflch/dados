<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use Illuminate\Http\Request;
use App\Utils\Util;
use Uspdev\Replicado\Uteis;
use Khill\Lavacharts\Lavacharts;

class AtivosPorDepartamentoController extends Controller
{
    private $data;
    private $excel;
    private $codfnc;
    private $tipvin;

    public function __construct(Excel $excel, Request $request){
        $this->excel = $excel;
        $data = [];
        
        $funcoes = [
            0 => '',
            1 => 'Prof Associado',
            2 => 'Prof Doutor',
            3 => 'Prof Titular'
        ];

        $tipvin = $request->route()->parameter('tipvin') ?? ''; //Docente ou Servidor
        if($tipvin != 'Docente' && $tipvin != 'Servidor') $tipvin = '';
        $this->tipvin = $tipvin;

        $this->codfnc = $request->route()->parameter('codfnc') ?? 0;
        
        $funcao = isset($funcoes[$this->codfnc]) ? $funcoes[$this->codfnc] : -1;

        $departamentos = array_keys(Util::departamentos);


        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_tipvin_departamento.sql');
        
        /* Contabiliza funcionários ativos por departamento */
        foreach ($departamentos as $departamento){
            $query_por_departamento = str_replace('__departamento__', $departamento, $query);
            $query_por_departamento = str_replace('__tipvin__', $tipvin, $query_por_departamento);
            if($funcao != -1 && strlen($funcao) > 0){
                $query_por_departamento = str_replace('__funcao__', "and nomfnc = '$funcao'", $query_por_departamento);
            }else{
                $query_por_departamento = str_replace('__funcao__', '', $query_por_departamento);
            }
            $result = DB::fetch($query_por_departamento);
            $data[$departamento] = $result['computed'];
        }
        $this->data = $data;
    }    
    
    public function grafico(){
        $codfnc = $this->codfnc;
        switch((int)$codfnc){
            case 0:
                $tipovin_text = 'funcionários';
                break;
            case 1:
                $tipovin_text = 'professores associados';
                break;
            case 2:
                $tipovin_text = 'professores doutores';
                break;
            case 3:
                $tipovin_text = 'professores titulares';
                break;
            default:
                $tipovin_text = "";
        }
      
        $tipvin = $this->tipvin;

        $lava = new Lavacharts; // See note below for Laravel

        $ativos = $lava->DataTable();

        $ativos->addStringColumn('Departamento')
                ->addNumberColumn('Quantidade');

        foreach($this->data as $key=>$data) {
            $ativos->addRow([$key, (int)$data]);
        }
        
        $lava->PieChart('Ativos', $ativos, [
            'title' => 'Quantidade de '.$tipovin_text.' ativos na Faculdade de Filosofia, Letras e Ciências Humanas contabilizados por departamento.',
            'legend' => [
                'position' => 'bottom',
                'alignment' => 'center'
                
            ],
            'height' => 500

        ]);
        

        return view('ativosTipvinDepartamento', compact('codfnc', 'lava', 'tipvin'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'ativos_por_departamento.xlsx');
        }
    }

}
