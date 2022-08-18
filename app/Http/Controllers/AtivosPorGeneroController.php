<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use Illuminate\Http\Request;
use App\Utils\Util;
use Uspdev\Replicado\Uteis;
use Khill\Lavacharts\Lavacharts;
use App\Http\Requests\AtivosPorGeneroRequest;
use App\Http\Controllers\Dados\AtivosPorGeneroDados;

class AtivosPorGeneroController extends Controller
{
    private $codcur;
    private $data;
    private $excel;
    private $vinculo;

    public function __construct(Excel $excel, AtivosPorGeneroRequest $request){

        $this->excel = $excel;
        $this->data = AtivosPorGeneroDados::listar($request->validated());
    }
    
    public function grafico(){

        $codcur = $this->data['codcur'];
        $vinculo =  $this->data['vinculo'];
        $listaVinculos = Util::vinculosExt;

        $vinculoExt = array_search(['vinculo' => $vinculo, 'codcur' => $codcur], $listaVinculos);


        $lava = new Lavacharts; // See note below for Laravel

        $genero  = $lava->DataTable();

        $formatter = $lava->NumberFormat([ 
            'pattern' => '#.###',
        ]);
        $genero->addStringColumn('Tipo de convênio')
            ->addNumberColumn('Quantidade', $formatter);


        $genero->addRow(['Feminino', $this->data['dados']['F']]);
        $genero->addRow(['Masculino', $this->data['dados']['M']]);


        $max = max($this->data['dados']);
        $div = $max/10;


        $lava->ColumnChart('Genero', $genero, [
            'legend' => [
                'position' => 'top',
                ' alignment' => 'center',
            ],
            'vAxis'=>['ticks'=>range(0,$max, round($div))],
            'height' => 500,
            'colors' => ['#273e74']

        ]);

        return view('ativosPorGenero', compact('codcur', 'vinculo', 'listaVinculos', 'vinculoExt', 'lava'));
    }

    public function export($format)
    {   
        $codcur = $this->data['codcur'];
        $vinculo =  $this->data['vinculo'];
        $listaVinculos = Util::vinculosExt;

        $vinculoExt = array_search(['vinculo' => $vinculo, 'codcur' => $codcur], $listaVinculos);

        $vinculoExt = str_replace(' ','_', Uteis::removeAcentos(strtolower($vinculoExt)));

        if($format == 'excel') {
            $export = new DadosExport([$this->data['dados']],['Feminino', 'Masculino']);
            return $this->excel->download($export, $vinculoExt.'_ativos_por_genero.xlsx'); 
        }
    }
}
