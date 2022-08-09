<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use Illuminate\Http\Request;
use App\Utils\Util;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use Uspdev\Replicado\Uteis;
use Khill\Lavacharts\Lavacharts;
use App\Http\Requests\AlunosAtivosAutodeclaradosRequest;
use App\Http\Controllers\Dados\AlunosAtivosAutodeclaradosDados;

class AlunosAtivosAutodeclaradosController extends Controller
{
    private $data = [];
    private $excel;
    
    public function __construct(Excel $excel,AlunosAtivosAutodeclaradosRequest $request)
    {
        $this->excel = $excel;
        $this->data = AlunosAtivosAutodeclaradosDados::listar($request);
    }

    public function grafico()
    {
        $vinculo = $this->data['vinculo'];
        $nome_vinculo = $this->data['nome_vinculo'];

        $lava = new Lavacharts; 
        $ativos_col = $lava->DataTable();

        $formatter = $lava->NumberFormat([ 
            'pattern' => '#.###',
        ]);
       
        $ativos_col->addStringColumn('Tipo Vínculo')
                ->addNumberColumn('Quantidade', $formatter);

        foreach($this->data['dados'] as $key=>$data) {
            $ativos_col->addRow([$key, (int)$data]);
        }
        
        $lava->ColumnChart('AtivosCOL', $ativos_col, [
            'legend' => [
                'position' => 'top',
                
            ],
            'titlePosition' => 'out',
            'height' => 500,
            'vAxis' => ['format' => 0],
            'colors' => ['#273e74']

        ]);

        return view('alunosAtivosAutodeclarados', compact('vinculo', 'nome_vinculo', 'lava'));
    }

    public function export($format, Request $request)
    {
        $vinculo = $request->route()->parameter('vinculo') ?? 'ALUNOGR';
        
        $nome_vinculo = isset($vinculos[$vinculo]) ? $vinculos[$vinculo] : 'Vínculo não encontrado';
    
        $nome_vinculo = str_replace(' ','_', Uteis::removeAcentos(strtolower($nome_vinculo)));

        if ($format == 'excel') {
            $export = new DadosExport([$this->data['dados']], ['Indígena',
            'Branca',
            'Preta/Negra',
            'Amarela',
            'Parda',
            'Não informado']);
            return $this->excel->download($export, 'ativos_'.$vinculo.'_autodeclarados.xlsx');
        }
    }
}
