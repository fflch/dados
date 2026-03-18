<?php

namespace App\Http\Controllers\Restrito;

use App\Exports\DadosExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Utils\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Excel;

class DocentesController extends Controller
{
    
    private $header = ['NUSP',"Nome","Departamento","Mérito","Classe",   "Função","Status", "Ultima Ocorrência", "Fim do Vínculo", "Fim da Atividade"];

    public function index(Request $request)
    {

        Gate::authorize('admin');
        $tipmer = ['MS-1','MS-2','MS-3','MS-4','MS-5','MS-6'];
        $sitatl= [
            'A' => "Ativo",
            'D' => "Desligado",
            'P' => "Aposentado"
        ];
        $keys = ['codpes', 'nompes', 'nomset', 'tipmer', 'nomabvcla', 'nomabvfnc', 'sitatl', 'sitoco', 'dtafimvin', 'dtafimdctati'];

        if ($request->tabela == null) {
            return view('restrito.docentes',['departamentos'=>Util::departamentos, 
                                         'status' => $sitatl,
                                         'meritos' => $tipmer]);
        }
        
        $request->validate(
            [
                'status.*' =>  'alpha|size:1',
                'departamento.*' =>  'alpha|size:3',
                'merito.*' =>  'alpha_dash:ascii|size:4',
                'fimvin' =>  'date',
                'fimativ' =>  'date',

            ]
        );


        if ($request->departamento == null) { //seleciona todos os departamentos
            $dep = implode(", ",array_column(Util::departamentos,0));
        }
        else{
            foreach($request->departamento as $departamento){
                $dep[] = Util::departamentos[$departamento][0];

            }
            $dep = implode(", ",$dep);
        }
        
        $filtroMerito = "";
        if ($request->merito !=null) {
            $filtroMerito = "AND V.tipmer in ('".implode("', '",$request->merito)."')\n";
        }
        
        $filtroStatus = "";
        if ($request->status !=null) {
            $filtroStatus = "AND V.sitatl in ('".implode("', '",$request->status)."')\n";
        }
        $filtroFimVin = "";
        if ($request->fimvin !=null) {
            
            $filtroFimVin = "AND (V.dtafimvin IS NULL OR V.dtafimvin >'".$request->fimvin."')\n";
        }

        $filtroFimAtiv = "";
        if ($request->fimativ !=null) {
            
            $filtroFimAtiv = "AND (V.dtafimdctati IS NULL OR V.dtafimdctati > '".$request->fimativ."')\n";
        }
        
        $data = Util::query("listar_docentes",[
            "__filtros__" => $filtroStatus.$filtroFimVin.$filtroFimAtiv.$filtroMerito,
            "__departamentos__" => $dep
        ]);
        Cache::put($request->session()->getId().'docentes',$data,600);
        return view('restrito.docentes',
        [
            'departamentos'=>Util::departamentos, 
            'status' => $sitatl,
            'meritos' => $tipmer,
            'dataDocentes' => $data,
            'table_labels' => $this->header,
            'table_keys' => $keys
        ]);
                                        
    }


    public function planilhaDocentes(Request $request, Excel $excel){
        Gate::authorize('admin');
        $data = Cache::get($request->session()->getId().'docentes');
        $export = new DadosExport([$data], 
        $this->header);
         return $excel->download($export, 'Docentes.xlsx');
    }

}
