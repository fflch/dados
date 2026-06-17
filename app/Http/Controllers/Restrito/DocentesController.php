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
use App\Models\Docente;
use App\Models\Disciplina;
use function Illuminate\Log\log;

class DocentesController extends Controller
{
    
    private $header = ['NUSP',"Nome","Departamento","Mérito","Classe",   "Função","Status", "Ultima Ocorrência", "Fim do Vínculo", "Fim da Atividade"];
    private $tipmer = ['MS-1','MS-2','MS-3','MS-4','MS-5','MS-6'];
    private $sitatl= [
            'A' => "Ativo",
            'D' => "Desligado",
            'P' => "Aposentado"
        ];
    private $keysLista = ['codpes', 'nome', 'departamento', 'merito', 'classe', 'funcao', 'status', 'ultimaOcorrencia', 'dtaFimVinculo', 'dtaFimAtividade'];
    private $headerDisciplinas = ['NUSP','Departamento','Mérito','Nome', 'Disciplinas', 'Média de Disciplinas por Ano'];
    public function index(Request $request)
    {

        Gate::authorize('admin');
        $tipmer = ['MS-1','MS-2','MS-3','MS-4','MS-5','MS-6'];
        $sitatl= [
            'A' => "Ativo",
            'D' => "Desligado",
            'P' => "Aposentado"
        ];

        if ($request->tabela == null) {
            return view('restrito.docentes',['departamentos'=>Util::departamentos, 
                                         'status' => $this->sitatl,
                                         'meritos' => $this->tipmer]);
        }
    }

    public function listar(Request $request)
    {


        Gate::authorize('admin');
        

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
            foreach($request->departamento as $departamento){
                $dep[] = array_column(Util::departamentos,0);
                }
            }
        else{
            foreach($request->departamento as $departamento){
                $dep[] = Util::departamentos[$departamento][0];

            }
        }

        $data = Docente::whereIn('codset', $dep);

        if ($request->merito !=null) {
            $data->whereIn('merito', $request->merito);
        }
        
        if ($request->status !=null) {
            $data->whereIn('status', $request->status);
        }

        if ($request->fimvin !=null) {
            $data->where('dtaFimVinculo','>=', $request->fimvin);
        }

        if ($request->fimativ !=null) {
            $data->where('dtaFimAtividade','>=', $request->fimativ);
        }

        $data = $data->get()->toarray();
        
        Cache::put($request->session()->getId().'docentes',$data,600);
        return view('restrito.docentes',
        [
            'departamentos'=>Util::departamentos, 
            'status' => $this->sitatl,
            'meritos' => $this->tipmer,
            'dataDocentes' => $data,
            'table_labels' => $this->header,
            'table_keys' => $this->keysLista
        ]);
                                        
    }
    public function disciplinas(Request $request)
    {


        Gate::authorize('admin');
        $keysDisciplinas = ['nomeDepartamento','meritoDocente','codpes','nomeDocente', 'disciplinas', 'media'];
        
        $request->validate(
            [
                'inidis' =>  'required|integer|min:2000',
                'fimdis' =>  'required|integer|min:2000',
                'departamento.*' =>  'required|alpha|size:3'
            ]
        );

        //achar o NUSP dos docentes dodepartamento
        foreach($request->departamento as $departamento){
                $dep[] = Util::departamentos[$departamento][0];
            }
        $doc = Docente::select('codpes')->whereIn('codset', $dep)->get()->toarray();
        $nuspS = [];
        foreach($doc as $cod_doc){
            $nuspS[] = $cod_doc['codpes'];
            }

        $interval = $request->fimdis-$request->inidis+1;

        //agrupar os semestres do periodo
        $sem= [];
        for ($i=$request->inidis; $i <= $request->fimdis ; $i++) { 
            $sem[] = $i.'1';
            $sem[] = $i.'2';
        }
        $keysDisciplinas = array_merge($keysDisciplinas,$sem);
        $semS = implode('|', $sem);
        $reg_ex = '/^(' . $semS . ')/';


        $data = Disciplina::whereIn('codpes', $nuspS)
                          ->where('turma', 'regex', $reg_ex)
                          ->get()
                          ->toarray();

        //contar as disciplinas
        $dis_doscentes = [];
        foreach ($data as $tur) {
            if(array_key_exists($tur["codpes"],$dis_doscentes)){
                $dis_doscentes[$tur["codpes"]][substr($tur['turma'],0,5)][$tur['disciplina'].substr($tur['turma'],0,5)]=1;
            }else{
                $dis_doscentes[$tur["codpes"]]=$tur;
                foreach ($sem as $s){
                    $dis_doscentes[$tur["codpes"]][$s]=[];    
                }
                $dis_doscentes[$tur["codpes"]][substr($tur['turma'],0,5)][$tur['disciplina'].substr($tur['turma'],0,5)]=1;
            }     
        }

        foreach ($dis_doscentes as $n => $doc) {
            $dis_doscentes[$n]['disciplinas']=0;
            foreach ($sem as $s) {
                $dis_doscentes[$n]['disciplinas']+=count($doc[$s]);
                $dis_doscentes[$n][$s]=count($doc[$s]);
            }
            $dis_doscentes[$n]['media'] = round($dis_doscentes[$n]['disciplinas']/$interval,3);
            unset($dis_doscentes[$n]["disciplina"]);
            unset($dis_doscentes[$n]["turma"]);

        }


        Cache::put($request->session()->getId().'docentes-disciplinas',$dis_doscentes,600);
        Cache::put($request->session()->getId().'docentes-disciplinas-semestres',$sem,600);
        return view('restrito.docentes',
        [
            'departamentos'=>Util::departamentos, 
            'status' => $this->sitatl,
            'meritos' => $this->tipmer,
            'dataDisciplinas' => $dis_doscentes,
            'table_labels' => array_merge($this->headerDisciplinas,$sem),
            'table_keys' => $keysDisciplinas
        ]);
                                        
    }

    public function planilhaDisciplinas(Request $request, Excel $excel){
        Gate::authorize('admin');
        $data = Cache::get($request->session()->getId().'docentes-disciplinas');
        $sem =  Cache::get($request->session()->getId().'docentes-disciplinas-semestres');

        $head = array_slice($this->headerDisciplinas,0,count($this->headerDisciplinas)-2);
        $head = array_merge($head,$sem);
        $head = array_merge($head,array_slice($this->headerDisciplinas,count($this->headerDisciplinas)-2,2));

        $export = new DadosExport([$data], $head);
        return $excel->download($export, 'Docentes - Disciplinas.xlsx');
    }

    public function planilhaDocentes(Request $request, Excel $excel){
        Gate::authorize('admin');
        $data = Cache::get($request->session()->getId().'docentes');
        $export = new DadosExport([$data], 
        $this->header);
         return $excel->download($export, 'Docentes.xlsx');
    }

}
