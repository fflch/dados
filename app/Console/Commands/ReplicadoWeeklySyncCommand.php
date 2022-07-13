<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Uspdev\Replicado\Lattes;
use Uspdev\Replicado\Pessoa;
use Uspdev\Replicado\Pesquisa;
use Uspdev\Replicado\Posgraduacao;
use App\Models\Lattes as LattesModel;
use App\Utils\ReplicadoTemp;
use App\Models\Programa;
use App\Models\ComissaoPesquisa;
use App\Utils\Util;
use Uspdev\Replicado\Uteis;
use App\Models\Pessoa as PessoaModel;


class ReplicadoWeeklySyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'replicadoweeklysync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincronização semanal do armazenamento de dados do replicado para o banco local';

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

        $this->sync_comissao_pesquisa();
/*
        $docentes = array_column(Pessoa::listarDocentes(), 'codpes');
        $credenciados = array_column(ReplicadoTemp::credenciados(), 'codpes');
        $codpes = array_merge($credenciados, $docentes);
        $codpes = array_unique($codpes);
        sort($codpes);

        $this->syncJson($codpes);

        $programas = Posgraduacao::programas(8);
        foreach($programas as $value) {
            $this->sync_alunos_posgr(ReplicadoTemp::listarAlunosAtivosPrograma($value['codare']),8);
        }
*/
        return 0;
    }

    private function sync_alunos_posgr($discentes, $codare){
        $codpes = PessoaModel::select('codpes')->whereIn('tipo_vinculo', array('ALUNOPOS'))->where('codare',$codare)->get()->pluck('codpes')->toArray(); //buscando os registros no banco local
        $codpes_replicado = array_column($discentes, 'codpes');

        $diff = array_diff($codpes, $codpes_replicado);
        PessoaModel::whereIn('codpes', $diff)->whereIn('tipo_vinculo', array('ALUNOPOS'))->where('codare',$codare)->delete();//deletando as diferenças no banco local, para mentê-lo atualizado


        foreach($discentes as $discente){
            $discente = Uteis::utf8_converter($discente);

            $pessoa = PessoaModel::where('codpes',$discente['codpes'])->first();
            if(!$pessoa) $pessoa = new PessoaModel;

            $id_lattes = Lattes::id($discente['codpes']);

            $pessoa->codpes = $discente['codpes'];
            $pessoa->id_lattes = isset($id_lattes) ? $id_lattes : null;
            $pessoa->sitatl = $discente['sitatl'];
            $pessoa->nompes = $discente['nompes'];
            $pessoa->codare = isset($discente['codare']) ? $discente['codare'] : null;
            $pessoa->email = isset($discente['codema']) ? $discente['codema'] : null;
            $pessoa->sexpes = isset($discente['sexpes']) ? $discente['sexpes'] : null;
            $pessoa->dtainivin = $discente['dtainivin'];
            $pessoa->tipo_vinculo = $discente['tipvin'];
            $pessoa->nivpgm = $discente['nivpgm'];

            $pessoa->save();
        }
    }


    private function sync_comissao_pesquisa(){
        $codproj = ComissaoPesquisa::select('codproj')->get()->pluck('codproj')->toArray(); //buscando os registros no banco local

        //iniciação cientifica
        $iniciacao_cientifica = ReplicadoTemp::listarIniciacaoCientifica(); //traz todas as iniciações cientificas presentes no replicado
        //pesquisas de pos doutorandos ativos
        $pesquisa = Pesquisa::listarPesquisaPosDoutorandos();
        //pesquisadores colaborativos ativos
        $pesquisadores_colab = Pesquisa::listarPesquisadoresColaboradoresAtivos();


        $codproj_ic = array_column($iniciacao_cientifica, 'cod_projeto');
        $codproj_pes = array_column($pesquisa, 'codprj');
        $codproj_pes_colab = array_column($pesquisadores_colab, 'codprj');
        $codproj_replicado = array_merge($codproj_ic, $codproj_pes, $codproj_pes_colab);

        $diff = array_diff($codproj, $codproj_replicado);
        ComissaoPesquisa::whereIn('codproj', $diff)->delete(); // deletando as diferenças no banco local para mantê-lo atualizado

        if($iniciacao_cientifica){
            foreach($iniciacao_cientifica as $ic){

                $comissao = ComissaoPesquisa::where('codproj',$ic['cod_projeto'])->where('codpes_discente',$ic['aluno'])->first();
                if(!$comissao) $comissao = new ComissaoPesquisa;
                $comissao->codproj = $ic['cod_projeto'];
                $comissao->codpes_discente = $ic['aluno'];
                $comissao->nome_discente= $ic['nome_aluno'];
                $comissao->genero_discente= $ic['genero_aluno'];
                $comissao->raca_cor_discente= $ic['raca_cor_aluno'];
                $comissao->codpes_supervisor= $ic['orientador'];
                $comissao->nome_supervisor= $ic['nome_orientador'];
                $comissao->genero_supervisor= $ic['genero_orientador'];
                $comissao->titulo_pesquisa= $ic['titulo_pesquisa'];
                $comissao->data_ini = !empty($ic['data_ini']) ? $ic['data_ini'] : null;
                $comissao->data_fim = !empty($ic['data_fim']) ? $ic['data_fim'] : null;
                $comissao->dtainibol = !empty($ic['dtainibol']) ? $ic['dtainibol'] : null;
                $comissao->dtafimbol = !empty($ic['dtafimbol']) ? $ic['dtafimbol'] : null;
                $comissao->ano_proj = $ic['ano_projeto'];
                $comissao->bolsa = $ic['bolsa'];
                $comissao->cod_departamento = null;
                $comissao->sigla_departamento = $ic['sigla_departamento'];
                $comissao->nome_departamento = $ic['departamento'];
                $comissao->status_projeto = $ic['status_projeto'];

                $curso = Util::retornarCursoGrdPorDepartamento($ic['sigla_departamento']);
                $comissao->cod_curso= isset($curso['codcur']) ? $curso['codcur'] : null;
                $comissao->nome_curso= isset($curso['nome_curso']) ? $curso['nome_curso'] : null;

                $comissao->tipo= 'IC';

                $comissao->save();
            }
        }


        if($pesquisa){
            foreach($pesquisa as $pd){
                $comissao = ComissaoPesquisa::where('codproj',$pd['codprj'])->where('codpes_discente',$pd['codpes'])->first();
                if(!$comissao) $comissao = new ComissaoPesquisa;
                $comissao->codproj = $pd['codprj'];
                $comissao->codpes_discente = $pd['codpes'];
                $comissao->nome_discente= $pd['nome_aluno'];
                $comissao->codpes_supervisor= null;
                $comissao->nome_supervisor= $pd['supervisor'];
                $comissao->titulo_pesquisa= $pd['titprj'];
                $comissao->data_ini = !empty($pd['dtainiprj']) ? $pd['dtainiprj'] : null;
                $comissao->data_fim = !empty($pd['dtafimprj']) ? $pd['dtafimprj'] : null;
                $comissao->ano_proj = null;
                $comissao->bolsa = $pd['bolsa'];

                $comissao->cod_departamento = null;
                $comissao->sigla_departamento = $pd['sigla_departamento'];
                $comissao->nome_departamento = $pd['departamento'];

                $curso = Util::retornarCursoGrdPorDepartamento($pd['sigla_departamento']);
                $comissao->cod_curso= isset($curso['codcur']) ? $curso['codcur'] : null;
                $comissao->nome_curso= isset($curso['nome_curso']) ? $curso['nome_curso'] : null;

                $comissao->tipo= 'PD';
                $comissao->save();
            }
        }


        if($pesquisadores_colab){
            foreach($pesquisadores_colab as $pc){
                $comissao = ComissaoPesquisa::where('codproj',$pc['codprj'])->where('codpes_discente',$pc['codpes'])->first();
                if(!$comissao) $comissao = new ComissaoPesquisa;
                $comissao->codproj = $pc['codprj'];
                $comissao->codpes_discente = $pc['codpes'];
                $comissao->nome_discente= $pc['pesquisador'];
                $comissao->codpes_supervisor= null;
                $comissao->nome_supervisor= $pc['responsavel'];
                $comissao->titulo_pesquisa= $pc['titulo_pesquisa'];
                $comissao->data_ini = !empty($pc['data_ini']) ? $pc['data_ini'] : null;
                $comissao->data_fim = !empty($pc['data_fim']) ? $pc['data_fim'] : null;
                $comissao->ano_proj = null;
                $comissao->bolsa = null;
                $comissao->cod_departamento = null;
                $comissao->sigla_departamento = $pc['sigla_departamento'];
                $comissao->nome_departamento = $pc['departamento'];

                $curso = Util::retornarCursoGrdPorDepartamento($pc['sigla_departamento']);
                $comissao->cod_curso= isset($curso['codcur']) ? $curso['codcur'] : null;
                $comissao->nome_curso= isset($curso['nome_curso']) ? $curso['nome_curso'] : null;
                $comissao->tipo= 'PC';

                $comissao->save();
            }
        }

    }

    private function syncJson($pessoas){

        if(!is_array($pessoas))return;

        foreach($pessoas as $codpes) {

            $lattes = LattesModel::where('codpes',$codpes)->first();

            if(!$lattes) {
                $lattes = new LattesModel;
            }
            if(!empty($lattes->json)){
                $info_lattes = json_decode($lattes->json, true);
            }else{
                $info_lattes = [];
            }

            $info_lattes['orientandos'] = Posgraduacao::listarOrientandosAtivos($codpes);
            $info_lattes['orientandos_concluidos'] = Posgraduacao::listarOrientandosConcluidos($codpes);

            $lattes->codpes = $codpes;
            $lattes->json = json_encode(Uteis::utf8_converter($info_lattes));

            $lattes->save();

        }

    }

}

