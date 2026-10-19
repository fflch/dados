<?php

namespace App\Imports;

use App\Models\ProjetoFapesp;
use App\Utils\Util;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Uspdev\Replicado\DB;
use Uspdev\Replicado\Posgraduacao;

use function PHPUnit\Framework\isNull;

class FapespImport implements OnEachRow
{
    private $pos = [];
    public function __construct(){
        Log::alert("Buscando alunos no replicado");
        $areas = Posgraduacao::programas(8);
        $areas = implode(", ",array_column($areas,"codare"));
        $this->pos = Util::query('listar_posgr_ativos',[
            '__area__' => $areas
        ]);
        Log::alert("Alunos salvos");
        $this->pos = array_map(function ($item){
            $item['Nome'] = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$item['Nome']));
            return $item;
        },$this->pos);
    }

    public function onRow(Row $row)
    {
        $r = $row->toArray();

        if ($r[4] != "Universidade de São Paulo (USP). Faculdade de Filosofia, Letras e Ciências Humanas (FFLCH)") {
            return;
        }

        
        
        $nivel = $this->trataNivel($r[18]);

        if ($nivel == 'doutorado direto' || $nivel == 'mestrado' || $nivel == 'doutorado') {
            //BUSCAR ALUNO
            $vinc = array_find($this->pos,function ($item) use ($r) {
                return $item['Nome'] == strtolower(iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$r[3]));
            });
            
            if (!isset($vinc['NUSP'])){
                Log::alert($vinc);
                //busca pessoa pelo nome no replicado
                $vinc = $this->achaPessoa($r[3]);
            }

            ProjetoFapesp::create([
                'titulo' => $r[1],
                'processo' => $r[0],
                'pesquisador_responsavel' => $r[9],
                'bolsista' => $r[3],
                'nivel' => $nivel,
                'grande_area' => $r[19],
                'area' => $r[20],
                'subarea' => $r[21],
                'data_inicio' => $r[23],
                'data_termino' => $r[24],
                'nusp' => $vinc['NUSP'] ?? null,
                'programa' => $vinc['Curso'] ?? null

            ]);
        }else{
            ProjetoFapesp::create([
                'titulo' => $r[1],
                'processo' => $r[0],
                'pesquisador_responsavel' => $r[9],
                'bolsista' => $r[3],
                'nivel' => $nivel,
                'grande_area' => $r[19],
                'area' => $r[20],
                'subarea' => $r[21],
                'data_inicio' => $r[23],
                'data_termino' => $r[24]
            ]);
        }
        
        
        
    }

    private function trataNivel($niv){
        $nivel = '';
        if($niv == 'Bolsas no Brasil - Pós-Doutorado'){
            $nivel = 'pós-doutorado';

        }
        else if($niv == 'Bolsas no Brasil - Mestrado'){
            $nivel = 'mestrado';

        }
        else if($niv == 'Bolsas no Brasil - Iniciação Científica'){
            $nivel = 'iniciação científica';

        }
        else if($niv == 'Bolsas no Brasil - Doutorado'){
            $nivel = 'doutorado';

        }
        else if($niv == 'Bolsas no Brasil - Doutorado Direto'){
            $nivel = 'doutorado direto';

        }
        else{
            $nivel  = 'outros';
        }
        return $nivel;
    }

    private function achaPessoa(string $nome){
        // busca NUSP do aluno no replicado
        $nome = preg_replace('/[^a-zA-Z0-9 ]/', '%', $nome);
        $query = "select top 1 codpes from PESSOA where nompes like '$nome' or nompesttd like '$nome'";
        $nusp = DB::fetchAll($query);
        
        if(!isset($nusp[0]['codpes'])) return null;

        $pes = [];
        $pes['NUSP'] = $nusp[0]['codpes'];

        // busca programa do aluno no replicado
        $query = "SELECT top 1 nomcur from VINCULOPESSOAUSP V
        INNER JOIN AREA A ON A.codare = V.codare  
        INNER JOIN NOMECURSO AS NC 
    	ON A.codcur = NC.codcur and NC.dtafimcur is null
        where codpes = ".$pes['NUSP']." AND V.tipvin = 'ALUNOPOS' ORDER BY dtainivin DESC";
        $pes['Curso'] = DB::fetchAll($query)[0]['nomcur'] ?? null;

        return $pes;



    }
}
