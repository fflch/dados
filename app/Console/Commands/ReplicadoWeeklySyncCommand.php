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

        $this->sync_comissao_pesquisa();

        $programas = Posgraduacao::programas(8);

       
        foreach($programas as $key=>$value) {
            $programa = Programa::where('codare',$value['codare'])->first();
            if(!$programa) $programa = new Programa;

            $programas[$key]['docentes'] = count(ReplicadoTemp::credenciados($value['codare']));
            $programas[$key]['discentes'] = Posgraduacao::contarAtivos($value['codare']);
            $programas[$key]['egressos'] = Posgraduacao::contarEgressosAreaAgrupadoPorAno($value['codare']);
            $programa->codare = $value['codare'];
            $programa->json = json_encode($programas[$key]);
            $programa->save();
        }
        
        $this->syncJson(ReplicadoTemp::credenciados(), null, 'docentes');
        
        
        foreach($programas as $value) {
            $discentes = ReplicadoTemp::listarAlunosAtivosPrograma($value['codare'],8);
            $this->syncJson($discentes, $value['codare'], 'discentes');  
            $this->sync_alunos_posgr($discentes);
            
        }
        
        foreach($programas as $value) {
            $this->syncJson(Posgraduacao::egressosArea($value['codare']), $value['codare'], 'egressos');
        }        

        return 0;
    }

    private function sync_alunos_posgr($discentes){
        putenv('REPLICADO_SYBASE=1');
        
        $codpes = PessoaModel::select('codpes')->whereIn('tipo_vinculo', array('ALUNOPOS', 'ALUNOPD'))->get()->pluck('codpes')->toArray(); //buscando os registros no banco local
        $codpes_replicado = array_column($discentes, 'codpes');
        $diff = array_diff($codpes, $codpes_replicado);
        PessoaModel::whereIn('codpes', $diff)->whereIn('tipo_vinculo', array('ALUNOPOS', 'ALUNOPD'))->delete();//deletando as diferenças no banco local, para mentê-lo atualizado


        foreach($discentes as $discente){
            
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

        putenv('REPLICADO_SYBASE=1');

        $codproj = ComissaoPesquisa::select('codproj')->get()->pluck('codproj')->toArray(); //buscando os registros no banco local

        //iniciação cientifica
        $iniciacao_cientifica = Pesquisa::listarIniciacaoCientifica(); //traz todas as iniciações cientificas presentes no replicado
        //pesquisas de pos doutorandos ativos
        $pesquisa = Pesquisa::listarPesquisaPosDoutorandos();
        //pesquisadores colaborativos ativos
        $pesquisadores_colab = Pesquisa::listarPesquisadoresColaboradoresAtivos();

        
        $codproj_ic = array_column($iniciacao_cientifica, 'cod_projeto');
        $codproj_pes = array_column($pesquisa, 'codprj');
        $codproj_pes_colab = array_column($pesquisadores_colab, 'codprj');
        $codproj_replicado = array_merge($codproj_ic, $codproj_pes, $codproj_pes_colab);
       
        $diff = array_diff($codproj, $codproj_replicado);
        ComissaoPesquisa::whereIn('codproj', $diff)->delete();//deletando as diferenças no banco local, para mentê-lo atualizado

        if($iniciacao_cientifica){
            foreach($iniciacao_cientifica as $ic){
                
                $comissao = ComissaoPesquisa::where('codproj',$ic['cod_projeto'])->where('codpes_discente',$ic['aluno'])->first();
                if(!$comissao) $comissao = new ComissaoPesquisa;
                $comissao->codproj = $ic['cod_projeto'];
                $comissao->codpes_discente = $ic['aluno'];
                $comissao->nome_discente= $ic['nome_aluno'];
                $comissao->codpes_supervisor= $ic['orientador'];
                $comissao->nome_supervisor= $ic['nome_orientador'];
                $comissao->titulo_pesquisa= $ic['titulo_pesquisa'];
                $comissao->data_ini = !empty($ic['data_ini']) ? $ic['data_ini'] : null;
                $comissao->data_fim = !empty($ic['data_fim']) ? $ic['data_fim'] : null;
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
        
         //projetos de pesquisa dos docentes
         putenv('REPLICADO_SYBASE=0');
         foreach(Util::getDepartamentos() as $key=>$value){
             foreach(Pessoa::listarDocentes($value[0]) as $docente){
                 $pesquisas  = Lattes::listarProjetosPesquisa($docente['codpes'], null, 'anual', -1, null);
                 $docente = Uteis::utf8_converter($docente);
                 if(isset($pesquisas) && is_array($pesquisas) && count($pesquisas) > 0){
                     foreach($pesquisas as $pesquisa){
                         $comissao = ComissaoPesquisa::where('codpes_discente',$docente['codpes'])->where('titulo_pesquisa',$pesquisa['NOME-DO-PROJETO'] )->first();
                         if(!$comissao) $comissao = new ComissaoPesquisa;
 
                         $comissao->titulo_pesquisa = $pesquisa['NOME-DO-PROJETO'];
                         $comissao->codpes_discente = $docente['codpes'];
                         $comissao->nome_discente = $docente['nompes'];
                         $comissao->data_ini = !empty($pesquisa['ANO-INICIO']) ? $pesquisa['ANO-INICIO']."-01-01 00:00:00" : null;
                         $comissao->data_fim = !empty($pesquisa['ANO-FIM']) ?  $pesquisa['ANO-FIM']."-01-01 00:00:00" : null;
                         $comissao->sigla_departamento = $key;
                         $comissao->nome_departamento = $value[1];
                         $curso = Util::retornarCursoGrdPorDepartamento($key);
                         $comissao->cod_curso= isset($curso['codcur']) ? $curso['codcur'] : null;
                         $comissao->nome_curso= isset($curso['nome_curso']) ? $curso['nome_curso'] : null;
                         $comissao->codpes_supervisor= null;
                         $comissao->codproj = null;
                         $comissao->nome_supervisor= null;
                         $comissao->ano_proj = null;
                         $comissao->bolsa = null;
                         $comissao->cod_departamento = null;
                         $comissao->tipo= 'PP';
                     
                         $comissao->save();
                     }
                 }
             }
         }
        
    }

    private function syncJson($pessoas, $codare = null, $tipo_pessoa = null){
       
        if(!is_array($pessoas))return;

        if($tipo_pessoa == 'docentes'){
            $codpes = LattesModel::select('codpes')->where('tipo_pessoa',$tipo_pessoa)->get()->pluck('codpes')->toArray(); //buscando os registros no banco local
        }else{
            $codpes = LattesModel::select('codpes')->where('tipo_pessoa',$tipo_pessoa)->where('codare', $codare)->get()->pluck('codpes')->toArray(); //buscando os registros no banco local
        }
        $codpes_replicado = array_column($pessoas, 'codpes');
        $diff = array_diff($codpes, $codpes_replicado);
        
        LattesModel::whereIn('codpes', $diff)->delete();//deletando as diferenças no banco local, para mentê-lo atualizado
        
        if($tipo_pessoa != 'docentes'){
            LattesModel::where(function ($query) {
                $query->where('nivpgm',null)->orWhere('nivpgm','');
            })->where('tipo_pessoa', '!=', 'docentes')->delete();
        }
       
        foreach($pessoas as $pessoa) {
          
            
            if(!isset($pessoa['codpes']) || empty($pessoa['codpes'])) continue;

           
            if($tipo_pessoa != 'docentes' && empty($pessoa['nivpgm'])) continue;

            $aux_codare = $codare == null ? $pessoa['codare'] : $codare;
            $nivpgm = isset($pessoa['nivpgm']) ? $pessoa['nivpgm'] : null;

            
            $lattes = LattesModel::where('codpes',$pessoa['codpes'])->where('codare',$aux_codare)->where('tipo_pessoa',$tipo_pessoa)->where('nivpgm',$nivpgm)->first();
            
            if(!$lattes) {
                $lattes = new LattesModel;
            }
            $lattes_array = Lattes::obterArray($pessoa['codpes']);
           
            if($lattes_array){
                $info_lattes = [];

                putenv('REPLICADO_SYBASE=1');
                $info_lattes['nome'] = Pessoa::dump($pessoa['codpes'])['nompes'];
                $info_lattes['orientandos'] = Posgraduacao::listarOrientandosAtivos($pessoa['codpes']);
                $info_lattes['orientandos_concluidos'] = Posgraduacao::obterOrientandosConcluidos($pessoa['codpes']);

                putenv('REPLICADO_SYBASE=0');
                $info_lattes['id_lattes'] = Lattes::id($pessoa['codpes']);
                $info_lattes['orcid'] = Lattes::retornarOrcidID($pessoa['codpes'], $lattes_array);
                $data_atualizacao = Lattes::retornarUltimaAtualizacao($pessoa['codpes'], $lattes_array) ;
                $info_lattes['data_atualizacao'] = $data_atualizacao ? substr($data_atualizacao, 0,2) . '/' . substr($data_atualizacao,2,2) . '/' . substr($data_atualizacao,4,4) : '-';
                $info_lattes['resumo'] = Lattes::retornarResumoCV($pessoa['codpes'], 'pt', $lattes_array);
                $info_lattes['livros'] = Lattes::listarLivrosPublicados($pessoa['codpes'], $lattes_array, 'anual', -1, null);
                $info_lattes['linhas_pesquisa'] = Lattes::listarLinhasPesquisa($pessoa['codpes'], $lattes_array);
                $info_lattes['artigos'] = Lattes::listarArtigos($pessoa['codpes'], $lattes_array, 'anual', -1, null);
                $info_lattes['capitulos'] = Lattes::listarCapitulosLivros($pessoa['codpes'], $lattes_array, 'anual', -1, null);
                $info_lattes['jornal_revista'] = Lattes::listarTextosJornaisRevistas($pessoa['codpes'], $lattes_array, 'anual', -1, null);
                $info_lattes['trabalhos_anais'] = Lattes::listarTrabalhosAnais($pessoa['codpes'], $lattes_array, 'anual', -1, null);
                $info_lattes['outras_producoes_bibliograficas'] = Lattes::listarOutrasProducoesBibliograficas($pessoa['codpes'], $lattes_array, 'anual', -1, null);
                $info_lattes['trabalhos_tecnicos'] = Lattes::listarTrabalhosTecnicos($pessoa['codpes'], $lattes_array, 'anual', -1, null);
                $info_lattes['ultimo_vinculo_profissional'] = Lattes::listarFormacaoProfissional($pessoa['codpes'], $lattes_array, 'anual', -1, null);
                $info_lattes['ultima_formacao'] = Lattes::retornarFormacaoAcademica($pessoa['codpes'], $lattes_array, 'anual', -1, null);
                $info_lattes['ultimo_vinculo_profissional'] = Lattes::listarFormacaoProfissional($pessoa['codpes'], $lattes_array, 'anual', -1, null);
                $info_lattes['organizacao_evento'] = Lattes::listarOrganizacaoEvento($pessoa['codpes'], $lattes_array, 'anual', -1, null);
                $info_lattes['outras_producoes_tecnicas'] = Lattes::listarOutrasProducoesTecnicas($pessoa['codpes'], $lattes_array, 'anual', -1, null);
                $info_lattes['curso_curta_duracao'] = Lattes::listarCursosCurtaDuracao($pessoa['codpes'], $lattes_array, 'anual', -1, null);
                $info_lattes['relatorio_pesquisa'] = Lattes::listarRelatorioPesquisa($pessoa['codpes'], $lattes_array, 'anual', -1, null);
                $info_lattes['material_didatico'] = Lattes::listarMaterialDidaticoInstrucional($pessoa['codpes'], $lattes_array, 'anual', -1, null);
                $info_lattes['projetos_pesquisa'] = Lattes::listarProjetosPesquisa($pessoa['codpes'], $lattes_array, 'anual', -1, null);
                $info_lattes['radio_tv'] = Lattes::listarRadioTV($pessoa['codpes'], $lattes_array, 'anual', -1, null);
                $info_lattes['apresentacao_trabalho'] = Lattes::listarApresentacaoTrabalho($pessoa['codpes'], $lattes_array, 'anual', -1, null);

                $lattes->codpes = $pessoa['codpes'];
                $lattes->tipo_pessoa = $tipo_pessoa;
                $lattes->codare = $aux_codare;
                $lattes->nivpgm =  $nivpgm;
                $lattes->json = json_encode($info_lattes);
               
                $lattes->save();
            } else {
                $lattes->codpes = $pessoa['codpes'];
                $lattes->tipo_pessoa = $tipo_pessoa;
                $lattes->codare = $aux_codare;
                $lattes->nivpgm =  $nivpgm;
                $lattes->json = null;
                $lattes->save();
                echo $pessoa['codpes'] .";". Pessoa::dump($pessoa['codpes'])['nompes'] .";". Lattes::id($pessoa['codpes']) .";lattes não encontrado\n";
            }
        }
       
    }

}

