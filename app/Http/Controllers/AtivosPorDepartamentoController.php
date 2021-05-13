<?php

namespace App\Http\Controllers;

use App\Charts\GenericChart;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use Illuminate\Http\Request;
use App\Utils\Util;
use Uspdev\Replicado\Uteis;

class AtivosPorDepartamentoController extends Controller
{
    private $data;
    private $excel;
    private $codfnc;

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
        $chart = new GenericChart;

        $chart->labels(array_keys($this->data));
        $chart->dataset('Quantidade', 'pie', array_values($this->data));
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
        

        return view('ativosTipvinDepartamento', compact('chart', 'tipovin_text', 'codfnc'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'ativos_por_departamento_funcionarios.xlsx');
        }
    }

}
