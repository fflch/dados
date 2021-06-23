<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use Illuminate\Http\Request;
use App\Utils\Util;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use Uspdev\Replicado\Uteis;
use Khill\Lavacharts\Lavacharts;
class AlunosAtivosAutodeclaradosController extends Controller
{
    private $data;
    private $excel;
    private $vinculo;
    private $nome_vinculo;
    
    public function __construct(Excel $excel,Request $request)
    {
        $this->excel = $excel;
        $data = [];

        $vinculos = [
            'ALUNOGR' => 'Aluno de Graduação', 
            'ALUNOPOS' => 'Aluno de Pós-Graduação', 
            'ALUNOCEU' => 'Aluno de Cultura e Extensão', 
            'ALUNOPD' => 'Aluno de Pós-Doutorado'
        ];

        $this->vinculo = $request->route()->parameter('vinculo') ?? 'ALUNOGR';

        $cores = Util::racas;

        $this->nome_vinculo = isset($vinculos[$this->vinculo]) ? $vinculos[$this->vinculo] : '"Vínculo não encontrado"';

        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_alunos_autodeclarados.sql');
        foreach ($cores as $key => $cor) {
            $query_por_cor = str_replace('__cor__', $cor, $query);
            $query_por_cor = str_replace('__vinculo__', $this->vinculo, $query_por_cor);
            $result = DB::fetch($query_por_cor);
            $data[$key] = $result['computed'];
        }
        $this->data = $data;
    }

    public function grafico()
    {
        $vinculo = $this->vinculo;
        $cores = Util::racas;
        $nome_vinculo = $this->nome_vinculo;

        $lava = new Lavacharts; 
        $ativos_col = $lava->DataTable();

        $formatter = $lava->NumberFormat([ 
            'pattern' => '#.###',
        ]);
       
        $ativos_col->addStringColumn('Tipo Vínculo')
                ->addNumberColumn('Quantidade', $formatter);

        foreach($this->data as $key=>$data) {
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

        return view('ativosAlunosAutodeclarados', compact('vinculo', 'cores', 'nome_vinculo', 'lava'));
    }

    public function export($format, Request $request)
    {
        $vinculo = $request->route()->parameter('vinculo') ?? 'ALUNOGR';
        
        $nome_vinculo = isset($vinculos[$vinculo]) ? $vinculos[$vinculo] : 'Vínculo não encontrado';
    
        $nome_vinculo = str_replace(' ','_', Uteis::removeAcentos(strtolower($nome_vinculo)));

        if ($format == 'excel') {
            $export = new DadosExport([$this->data], ['Indígena',
            'Branca',
            'Preta/Negra',
            'Amarela',
            'Parda',
            'Não informado']);
            return $this->excel->download($export, 'ativos_'.$vinculo.'_autodeclarados.xlsx');
        }
    }
}
