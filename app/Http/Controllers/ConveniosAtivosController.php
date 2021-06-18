<?php

namespace App\Http\Controllers;

use App\Charts\GenericChart;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Khill\Lavacharts\Lavacharts;
use Uspdev\Replicado\DB;

class ConveniosAtivosController extends Controller
{
    private $data;
    private $excel;

    public function __construct(Excel $excel){
        $this->excel = $excel;
        $data = [];

        /* Contabiliza dos convênios os que são financeiros */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_convenios_fin.sql');
        $result = DB::fetch($query);
        $data['Convenios Financeiros'] = $result['computed'];

        /* Contabiliza dos convênios os que são acadêmicos */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_convenios_acad.sql');
        $result = DB::fetch($query);
        $data['Convenios Acadêmicos'] = $result['computed'];

        $this->data = $data;
    }    
    
    public function grafico(){
        $lava = new Lavacharts; // See note below for Laravel

        $convenios  = $lava->DataTable();

        $convenios->addStringColumn('Tipo de convênio')
            ->addNumberColumn('Quantidade');
            
        foreach($this->data as $key=>$data) {
            $convenios->addRow([$key, (int)$data]);
        }


        $max = max($this->data) + 10;
        $div = $max/10;

        $lava->ColumnChart('Convenios', $convenios, [
            'legend' => [
                'position' => 'top',
                
            ],
            'vAxis'=>['ticks'=>range(0,$max, round($div))],
            'height' => 500,
            'colors' => ['#273e74']

        ]);

        return view('conveniosAtivos', compact('lava'));
    }

    public function export($format){
        if($format == 'excel') {
            $export = new DadosExport([$this->data],array_keys($this->data));
            return $this->excel->download($export, 'ativos_convenios.xlsx');
        }
    }

}