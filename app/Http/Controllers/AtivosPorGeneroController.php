<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use Illuminate\Http\Request;
use App\Utils\Util;
use Uspdev\Replicado\Uteis;
use Khill\Lavacharts\Lavacharts;

class AtivosPorGeneroController extends Controller
{
    private $data;
    private $excel;
    private $cod_curso;
    private $nome_curso;
    private $tipvin;
    private $filtro;

    public function __construct(Excel $excel,Request $request){
        $this->excel = $excel;
        
        
        $data = [];
        $siglas = ['F', 'M'];

        $this->tipvin = $request->route()->parameter('tipvin') ?? 'ALUNOGR0';
        
        $aux_tipvin  = preg_replace('/[0-9]+/', '', $this->tipvin );
        $this->cod_curso = $request->route()->parameter('cod_curso') ?? 8051;
        
        
        $this->filtro = [
            'ALUNOGR0' => ['url' => 'ativosGenero/ALUNOGR0/0', 'nome' => 'Alunos da Graduação'],
            'ALUNOGR1' => ['url' => 'ativosGenero/ALUNOGR1/8051', 'nome' => 'Alunos da Graduação de Letras'],
            'ALUNOGR2' => ['url' => 'ativosGenero/ALUNOGR2/8010', 'nome' => 'Alunos da Graduação de Filosofia'],
            'ALUNOGR3' => ['url' => 'ativosGenero/ALUNOGR3/8021', 'nome' => 'Alunos da Graduação de Geografia'],
            'ALUNOGR4' => ['url' => 'ativosGenero/ALUNOGR4/8030', 'nome' => 'Alunos da Graduação de História'],
            'ALUNOGR5' => ['url' => 'ativosGenero/ALUNOGR5/8040', 'nome' => 'Alunos da Graduação de Ciências Sociais'],
            'DOCENTES' => ['url' => 'ativosGenero/DOCENTES/0', 'nome' => 'Docentes'],
            'ESTAGIARIORH' => ['url' => 'ativosGenero/ESTAGIARIORH/0', 'nome' => 'Estagiários'],
            'SERVIDOR' => ['url' => 'ativosGenero/SERVIDOR/0', 'nome' => 'Funcionários'],
            'ALUNOPOS' => ['url' => 'ativosGenero/ALUNOPOS/0', 'nome' => 'Alunos de Pós Graduação'],
            'ALUNOPD' => ['url' => 'ativosGenero/ALUNOPD/0', 'nome' => 'Alunos de Pós Doutorado'],
            'ALUNOCEU' => ['url' => 'ativosGenero/ALUNOCEU/0', 'nome' => 'Alunos de Cultura e Extensão'],
            'CHEFESADM' => ['url' => 'ativosGenero/CHEFESADM/0', 'nome' => 'Chefes Administrativos'],
            'COORD' => ['url' => 'ativosGenero/COORD/0', 'nome' => 'Coordenadores de Cursos de Graduação'],
        ];


        /* Contabiliza alunos graduação gênero */
        $query = file_get_contents(__DIR__ . '/../../../Queries/conta_ativos_genero.sql');
        foreach($siglas as $sigla){
            if($aux_tipvin == 'DOCENTES'){
                $query = file_get_contents(__DIR__ . '/../../../Queries/conta_docentes_genero.sql');                
            }else if($aux_tipvin == 'SERVIDOR'){
                $query = file_get_contents(__DIR__ . '/../../../Queries/conta_funcionarios_genero.sql');                
            }else if($aux_tipvin == 'CHEFESADM'){
                $query = file_get_contents(__DIR__ . '/../../../Queries/conta_chefes_administrativos_genero.sql');                
            }else if($aux_tipvin == 'COORD'){
                $query = file_get_contents(__DIR__ . '/../../../Queries/conta_coordcursosgrad_genero.sql');                
            }
            $query_genero = str_replace('__genero__', $sigla, $query);
            $query_genero = str_replace('__tipvin__', $aux_tipvin, $query_genero);

            
            if($aux_tipvin == 'ALUNOGR' && $this->cod_curso != 0){
                $query_genero = str_replace('__join_alunogr__', 'JOIN SITALUNOATIVOGR s ON s.codpes = l.codpes', $query_genero);
                $query_genero = str_replace('__curso__', 'AND s.codcur = ' . $this->cod_curso, $query_genero);
            }else{
                $query_genero = str_replace('__join_alunogr__', '', $query_genero);
                $query_genero = str_replace('__curso__', '', $query_genero);

            }
             
            $result = DB::fetch($query_genero);
            
            $data[$sigla] = $result['computed'];
            
        }
        

        $this->data = $data;
    }    
    
    public function grafico(){
       
        $nome_curso = $this->nome_curso;
        $cod_curso = $this->cod_curso;
        $cursos = Util::cursos;
        $tipvin =  $this->tipvin;

        $filtro =  $this->filtro;
                    
        $texto = isset($filtro[$tipvin]['nome']) ? $filtro[$tipvin]['nome'] : 'Não encontrado';


        $lava = new Lavacharts; // See note below for Laravel

        $genero  = $lava->DataTable();

        $formatter = $lava->NumberFormat([ 
            'pattern' => '#.###',
        ]);
        $genero->addStringColumn('Tipo de convênio')
            ->addNumberColumn('Quantidade', $formatter);
            

        $genero->addRow(['Feminino', $this->data['F']]);
        $genero->addRow(['Masculino', $this->data['M']]);

        
        $max = max($this->data);
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
       

     
        return view('ativosGenero', compact( 'nome_curso', 'cod_curso', 'cursos', 'filtro', 'tipvin', 'texto', 'lava'));
    }

    public function export($format, Request $request)
    {
        $texto = $this->filtro[$this->tipvin]['nome'];

        $texto = str_replace(' ','_', Uteis::removeAcentos(strtolower($texto)));
        
        if($format == 'excel') {
            $export = new DadosExport([$this->data],['Feminino', 'Masculino']);
            return $this->excel->download($export, $texto.'_ativos_por_genero.xlsx'); 
        }
    }
}
