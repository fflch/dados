<?php

namespace App\Http\Controllers\Restrito;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use App\Utils\Util;
use Illuminate\Support\Facades\Log;
use Uspdev\Replicado\DB;


class PesquisaController extends Controller
{
    private array $colunas = [
        'Título do Projeto' => 'titprj',
        'Departamento' => 'departamento',
        'Status do Projeto' => 'status',
        'Início do Projeto' => 'inicioPrj',
        'Fim do Projeto' => 'fimPrj',
        'NUSP Pós-Doutorando' => 'nuspPd',
        'Nome Pós-Doutorando' => 'nomePd',
        'CPF Pós-Doutorando' => 'cpfPd',
        'Email Pós-Doutorando' => 'emailPd',
        'NUSP Supervisor' => 'nuspSup',
        'Nome Supervisor' => 'nomeSup',
        'CPF Supervisor' => 'cpfSup',
        'Email Supervisor' => 'emailSup',
        
    ];
    public function index(){
        $status = ['Aprovado', 'Encerrado', 'Cancelado', 'Reprovado', 'Inscrito', 'Incompleto', 'Ativo', 'Recusado'];
        Gate::authorize('admin');
        return view('restrito.pesquisa', [ 
            'departamentos' => Util::departamentos,
            'status' => $status
        ]);
    }

    public function planilhaPd(Excel $excel, Request $request)
    {
        Gate::authorize('admin');
        $request->validate(
            [
                'status' =>  'alpha',
                'departamento' =>  'alpha|size:3',
                'iniprj' =>  'date',
                'fimprj' =>  'date',

            ]
        );


        // Adicionando as restrições à query
        $filtro = '';
        if ($request->departamento != null){
            $dep = Util::departamentos[$request->departamento][0];
            $filtro .= "AND (proj.codsetprj = $dep OR proj.codsetprj IS NULL)\n";
        }
        if ($request->status != null){
            $filtro .= "AND proj.staatlprj = '$request->status'\n";
        }
        if ($request->iniprj != null){
            $filtro .= "AND proj.dtainiprj >= '$request->iniprj'\n";
        }
        if ($request->fimprj != null){
            $filtro .= "AND proj.dtafimprj <= '$request->fimprj'\n";
        }

        $data = Util::query('listar_projetosPosDoc',[
            '__filtros__' => $filtro
            ]);
            

        // preencher departamentos vazios com o setor do docente
        foreach($data  as $num => $proj){
            if ($proj['departamento'] == null) {
                $query = DB::fetchAll("SELECT codset FROM VINCULOPESSOAUSP WHERE tipvin = 'SERVIDOR' AND codpes = ".$proj['nuspSup']);
                // verifica se o departamento está de acordo com o filtro
                if ($request->departamento != null && Util::departamentos[$request->departamento][0] !=  $query[0]['codset']) {
                    unset($data[$num]);
                }else{
                    $data[$num]['departamento'] = $query[0]['codset'] ?? null;
                }
            }
        }

        // preenche com o nome dos departamentos
        $dep =[];
        foreach(Util::departamentos as $d){
            $dep[$d[0]]=$d[1];
        }
        foreach($data  as $num => $proj){
            $data[$num]['departamento'] = $dep[$proj['departamento']] ?? ($proj['departamento'] ?? null);
        }

        

        $header=[];
        $projetos = [];

        // colunas 
        foreach ($this->colunas as $nom => $cod) {
            //verifica se foi selecionado o email e cpf do pesquisador ou do supervisor
            if (!(($request->pd_col == null && ($cod == 'cpfPd' || $cod == 'emailPd')) || ($request->sup_col == null && ($cod == 'cpfSup' || $cod == 'emailSup')))) {
                $header[] = $nom;

                foreach ($data as $num => $val){
                    $projetos[$num][$cod] = $val[$cod];
                }
            }
        }

            
        $export = new DadosExport([$projetos], $header);
        return $excel->download($export,  'Pós-Doutorandos.xlsx');
    }

}
