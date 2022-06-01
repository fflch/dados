<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Uspdev\Replicado\Lattes;
use Uspdev\Replicado\Pessoa;
use Uspdev\Replicado\Pesquisa;
use Uspdev\Replicado\Posgraduacao;
use App\Utils\ReplicadoTemp;
use Carbon\Carbon;
use Uspdev\Utils\Generic;
use App\Models\Pessoa as PessoaModel;
use App\Models\Defesa as DefesaModel;


class ReplicadoDailySyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'replicadodailysync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincronização diária do armazenamento de dados do replicado para o banco local';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {       
        if(getenv('REPLICADO_SYBASE') != '1') putenv('REPLICADO_SYBASE=1');

        $this->sync_defesas();

        $this->sync_docentes(); 
        
        $this->sync_estagiarios();   
        
        $this->sync_monitores();
        
        $this->sync_servidores();

        $this->sync_chefes_departamento();
        
        $this->sync_chefes_administrativos();

        return 0;
    }


    private function sync_docentes(){        
        $docentes = Pessoa::listarDocentes(null, 'A,P');
        $this->sync_pessoas_local_replicado($docentes, 'Docente');

        foreach($docentes as $docente){
            
            $pessoa = PessoaModel::where('codpes',$docente['codpes'])->first();
            if(!$pessoa) $pessoa = new PessoaModel;
            
            $id_lattes = Lattes::id($docente['codpes']);
         

            $pessoa->codpes = $docente['codpes'];
            $pessoa->id_lattes = isset($id_lattes) ? $id_lattes : null;
            $pessoa->sitatl = $docente['sitatl'];
            $pessoa->nompes = $docente['nompes'];
            $pessoa->codset = isset($docente['codset']) ? $docente['codset'] : null;
            $pessoa->nomset = isset($docente['nomset']) ? $docente['nomset'] : null;
            $pessoa->email = isset($docente['codema']) ? $docente['codema'] : null;
            
            $json = ['nomfnc' => $docente['nomfnc']];
            $pessoa->json = json_encode($json); 
            
            $pessoa->tipo_vinculo = 'Docente'; 

            $pessoa->save();
        }        
    }

    private function sync_estagiarios(){
        $estagiarios = Pessoa::estagiarios(8);
        $this->sync_pessoas_local_replicado($estagiarios, 'Estagiario');

        foreach($estagiarios as $estagiario){
            
            $pessoa = PessoaModel::where('codpes',$estagiario['codpes'])->where('tipo_vinculo', 'Estagiario')->first();
            if(!$pessoa) $pessoa = new PessoaModel;
         
            $pessoa->codpes = $estagiario['codpes'];
            $pessoa->nompes = $estagiario['nompes'];
            $pessoa->codset = isset($estagiario['codset']) ? $estagiario['codset'] : null;
            $pessoa->nomset = isset($estagiario['nomset']) ? $estagiario['nomset'] : null;
            $pessoa->email = isset($estagiario['codema']) ? $estagiario['codema'] : null;
            $pessoa->tipo_vinculo = 'Estagiario'; 
            $pessoa->save();
        }        
    }
    
    private function sync_defesas(){
        $intervalo = [
            'inicio' => '1950-01-01',
            'fim'    => Date('Y') . '-12-31'
        ];
        $defesas = Posgraduacao::listarDefesas($intervalo);
    
        foreach($defesas as $defesa){
            $data = Carbon::createFromFormat('Y-m-d H:i:s', $defesa['dtadfapgm'])->format('d/m/Y');
            $defesa_id = md5($defesa['codpes'] + $defesa['codare'] + $defesa['codcur'] + str_replace('/','',$data));
            
            
            $defesaModel = DefesaModel::where('defesa_id',$defesa_id)->first();
            if(!$defesaModel) $defesaModel = new DefesaModel;
            
         
        
            $defesaModel->defesa_id = $defesa_id;
            $defesaModel->discente_id = Generic::crazyHash($defesa['codpes']);
            $defesaModel->nompes = $defesa['nompes'];
            $defesaModel->data_defesa = isset($defesa['dtadfapgm']) ? $defesa['dtadfapgm'] : null;
            $defesaModel->nivpgm = isset($defesa['nivpgm']) ? $defesa['nivpgm'] : null;
            $defesaModel->codare = isset($defesa['codare']) ? $defesa['codare'] : null;
            $defesaModel->nomare = isset($defesa['nomare']) ? $defesa['nomare'] : null;
            $defesaModel->codcur = isset($defesa['codcur']) ? $defesa['codcur'] : null;
            $defesaModel->nomcur = isset($defesa['nomcur']) ? $defesa['nomcur'] : null;
            $defesaModel->titulo = isset($defesa['tittrb']) ? $defesa['tittrb'] : null;
            $defesaModel->save();
        }        
    } 

    /**
     * Método para sincronizar a tabela pessoas no banco de dados local com o banco do replicado
     * @param Array $dados_replicado, array que contenha o codpes das pessoas para atualizar os registros
     * @param String $tipo_vinculo, tipo de vínculo da pessoa conforme cadastrado no banco local 
     * @return void
     */
    private function sync_pessoas_local_replicado($dados_replicado, $tipo_vinculo){
        $codpes = PessoaModel::select('codpes')->where('tipo_vinculo', $tipo_vinculo)->get()->pluck('codpes')->toArray(); //buscando os registros no banco local
        $codpes_replicado = array_column($dados_replicado, 'codpes');
        $diff = array_diff($codpes, $codpes_replicado);
        PessoaModel::whereIn('codpes', $diff)->delete();//deletando as diferenças no banco local, para mentê-lo atualizado
    }

    private function sync_chefes_administrativos(){
        $chefes = ReplicadoTemp::listarChefesAdministrativos();
        $this->sync_pessoas_local_replicado($chefes, 'Chefe Administrativo');

        foreach($chefes as $chefe){
            
            $pessoa = PessoaModel::where('codpes',$chefe['codpes'])->where('tipo_vinculo', 'Chefe Administrativo')->first();
            if(!$pessoa) $pessoa = new PessoaModel;
         
            $pessoa->codpes = $chefe['codpes'];
            $pessoa->nompes = $chefe['nompes'];
            $pessoa->nomset = isset($chefe['nomset']) ? $chefe['nomset'] : null;
            $pessoa->email = isset($chefe['codema']) ? $chefe['codema'] : null;
            $pessoa->tipo_vinculo = 'Chefe Administrativo'; 
            $pessoa->save();
        }        
    }

    private function sync_chefes_departamento(){
        $chefes_departamento = ReplicadoTemp::listarChefesDepartamento();
        $this->sync_pessoas_local_replicado($chefes_departamento, 'Chefe Departamento');

        foreach($chefes_departamento as $chefe){
            
            $pessoa = PessoaModel::where('codpes',$chefe['codpes'])->where('tipo_vinculo', 'Chefe Departamento')->first();
            if(!$pessoa) $pessoa = new PessoaModel;
         
            $pessoa->codpes = $chefe['codpes'];
            $pessoa->nompes = $chefe['nompes'];
            $pessoa->nomset = isset($chefe['nomset']) ? $chefe['nomset'] : null;
            $pessoa->email = isset($chefe['codema']) ? $chefe['codema'] : null;
            $pessoa->tipo_vinculo = 'Chefe Departamento'; 
            $pessoa->save();
        }        
    }
    
    private function sync_servidores(){
        $servidores = Pessoa::servidores(8);
        $this->sync_pessoas_local_replicado($servidores, 'Funcionário');

        foreach($servidores as $servidor){
            
            $pessoa = PessoaModel::where('codpes',$servidor['codpes'])->where('tipo_vinculo', 'Funcionário')->first();
            if(!$pessoa) $pessoa = new PessoaModel;
         
            $pessoa->codpes = $servidor['codpes'];
            $pessoa->nompes = $servidor['nompes'];
            $pessoa->codset = isset($servidor['codset']) ? $servidor['codset'] : null;
            $pessoa->nomset = isset($servidor['nomset']) ? $servidor['nomset'] : null;
            $pessoa->email = isset($servidor['codema']) ? $servidor['codema'] : null;
            $pessoa->tipo_vinculo = 'Funcionário'; 
            $pessoa->save();
        }        
    }
    
    private function sync_monitores(){
        $monitores = ReplicadoTemp::listarMonitores();
        $this->sync_pessoas_local_replicado($monitores, 'Monitor');

        foreach($monitores as $monitor){
            
            $pessoa = PessoaModel::where('codpes',$monitor['codpes'])->where('tipo_vinculo', 'Monitor')->first();
            if(!$pessoa) $pessoa = new PessoaModel;
         
            $pessoa->codpes = $monitor['codpes'];
            $pessoa->nompes = $monitor['Nome'];
            $pessoa->email = isset($monitor['E-mail']) ? $monitor['E-mail'] : null;
            $json = ['bolsa_ini' => $monitor['Início da Bolsa'],
                    'bolsa_fim' => $monitor['Fim da Bolsa']];
            $pessoa->json = json_encode($json);
            $pessoa->tipo_vinculo = 'Monitor'; 
            $pessoa->save();
        }        
    }

}

