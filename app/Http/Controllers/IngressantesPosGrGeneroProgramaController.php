<?php

namespace App\Http\Controllers;

use Uspdev\Replicado\DB;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Khill\Lavacharts\Lavacharts;
use Illuminate\Http\Request;
use App\Models\Programa as ProgramaModel;
use App\Models\Pessoa;

class IngressantesPosGrGeneroProgramaController extends Controller
{
    private $data;
    private $excel;
    public function __construct(Excel $excel,  Request $request){

        $this->excel = $excel;
        $data = [];
        
        $anos = [];
        $ano_ini = $request->ano_ini ?? date("Y") - 5;
        $ano_fim = $request->ano_fim ?? date("Y");

        $nivpgm = $request->nivpgm ?? false;
        

        if($ano_ini > $ano_fim){ 
            $aux = $ano_fim;
            $ano_fim = $ano_ini;
            $ano_ini = $aux;
        }
        
        for ($i = $ano_ini; $i <= $ano_fim ; $i++) { 
            array_push($anos,(int) $i);
        }

        $codare = $request->codare ?? 8133;
       

        foreach ($anos as $ano){
            
            if($nivpgm){
                $data[$ano]['Masculino'] = Pessoa::whereIn('tipo_vinculo', array('ALUNOPOS', 'ALUNOPD'))->whereYear('dtainivin', $ano)->where('codare', $codare)->where('sexpes', 'M')->where('nivpgm', $nivpgm)->get()->count();
                $data[$ano]['Feminino'] = Pessoa::whereIn('tipo_vinculo', array('ALUNOPOS', 'ALUNOPD'))->whereYear('dtainivin', $ano)->where('codare', $codare)->where('sexpes', 'F')->where('nivpgm', $nivpgm)->get()->count();
            }else{
                $data[$ano]['Masculino'] = Pessoa::whereIn('tipo_vinculo', array('ALUNOPOS', 'ALUNOPD'))->whereYear('dtainivin', $ano)->where('codare', $codare)->where('sexpes', 'M')->get()->count();
                $data[$ano]['Feminino'] = Pessoa::whereIn('tipo_vinculo', array('ALUNOPOS', 'ALUNOPD'))->whereYear('dtainivin', $ano)->where('codare', $codare)->where('sexpes', 'F')->get()->count();
            }
        } 

        $this->data = $data;
    }

    public function grafico(Request $request){
        
        $anos = [];
        
        for($year = (int)date("Y"); $year >= 2000; $year--){
            array_push($anos, $year);
        }

        $aux_programas = ProgramaModel::index();
        $programas = [];
        foreach($aux_programas as $programa){
            $programas[$programa->codare] = $programa->nomare;
        }


        $codare = $request->codare ?? 8133;
        $nomare = $programas[$codare];
        $nivpgm = $request->nivpgm ? '('.$request->nivpgm.')' : '';

        $lava = new Lavacharts; // See note below for Laravel
        $genero  = $lava->DataTable();

        $genero->addStringColumn('Ano')
            ->addNumberColumn('Masculino')
            ->addNumberColumn('Feminino');
          
        
        foreach($this->data as $key=>$data) {
            $genero->addRow([$key, $data['Masculino'], $data['Feminino']]);
        }


        $lava->LineChart('Genero', $genero, [
            'legend' => [
                'position' => 'top',
                'alignment' => 'center',
                
            ],
            'height' => 500,
            'interpolateNulls' => true,
            'vAxis' => ['format' => 0],
            'colors' => ['#273e74', 'green'],
            'animation' => [
                'startup' => true,
                'easing' => 'inAndOut'
            ],

        ]);

        

        return view('ingressantesPosGrGeneroPrograma', compact('lava', 'anos', 'programas', 'nomare', 'nivpgm'));
    }

    public function export($format, Request $request){
        $data = [];
        $masculino = [];
        foreach($this->data as $_data){
            array_push($masculino, $_data['Masculino']);
        }
        array_unshift($masculino, 'Masculino');
        $feminino = [];
        foreach($this->data as $_data){
            array_push($feminino, $_data['Feminino']);
        }
        array_unshift($feminino, 'Feminino');
        array_push($data, $masculino, $feminino);


        $labels = array_keys($this->data);
        array_unshift($labels, 'Ano');

        if($format == 'excel') {
            $export = new DadosExport($data,$labels);
            return $this->excel->download($export, 'ingressantes_por_genero_e_ano.xlsx');
        }
    }
}
