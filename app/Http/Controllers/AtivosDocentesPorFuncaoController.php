<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use Khill\Lavacharts\Lavacharts;
class AtivosDocentesPorFuncaoController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel){
        $this->excel = $excel;
        $data = [];

        $tipos = [
            'Prof Titular' => 'Professores titulares',
            'Prof Doutor' => 'Professores doutores',
            'Prof Associado' => 'Professores associados'
        ];

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_docentes_funcao.sql');

        foreach ($tipos as $key => $tipo){
            $query_por_funcao = str_replace('__tipo__', $key, $query);
            $result = DB::fetch($query_por_funcao);
            $data[$tipo] = $result['computed'];
        }        

        $this->data = $data;
    }    
    
    public function grafico(){
        $lava = new Lavacharts; 
        $docentes = $lava->DataTable();

        $docentes->addStringColumn('Docentes')
                ->addNumberColumn('Quantidade');

        foreach($this->data as $key=>$data) {
            $docentes->addRow([$key, (int)$data]);
        }
        
        $lava->PieChart('Docentes por função', $docentes, [
            'title'  => 'Quantidade de professores titulares, doutores e associados ativos na Faculdade de Filosofia, Letras e Ciências Humanas.',
            'is3D'   => true,
            'height' => 700

        ]);

        return view('ativosDocentesPorFuncao', compact('lava'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'docentes_funcao.xlsx');
        }
    }

}
