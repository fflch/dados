<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Uspdev\Replicado\Lattes;
use Uspdev\Replicado\Pessoa;
use Uspdev\Replicado\Posgraduacao;
use App\Models\Lattes as LattesModel;
use App\Utils\ReplicadoTemp;
use App\Models\Programa;
use App\Models\ComissaoPesquisa;
use App\Utils\Util;
use Uspdev\Replicado\Uteis;
use App\Models\Pessoa as PessoaModel;


class ReplicadoSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'replicadosync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        
        $this->sync_docentes(); 
       
        $this->sync_falecidos_periodo_covid();
        
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
            $this->syncJson(Posgraduacao::listarAlunosAtivosPrograma($value['codare'],8), $value['codare'], 'discentes');
        }
        foreach($programas as $value) {
            $this->syncJson(Posgraduacao::egressosArea($value['codare']), $value['codare'], 'egressos');
        }
       
        $this->sync_comissao_pesquisa();


        return 0;
    }

    private function sync_falecidos_periodo_covid(){
        $falecidos = Pessoa::listarFalecidosPorPeriodo('2020-02-07', date('Y-m-d'));
        foreach($falecidos as $falecido){
            
            $pessoa = PessoaModel::where('codpes',$falecido['codpes'])->first();
            if(!$pessoa) $pessoa = new PessoaModel;
            $pessoa->codpes = $falecido['codpes'];
            $pessoa->nompes = $falecido['nompes'];
            $pessoa->dtanas = $falecido['dtanas'];
            $pessoa->dtaflc = $falecido['dtaflc'];
            $pessoa->sexpes = $falecido['sexpes'];

            $pessoa->save();
        }        
    }

    private function sync_docentes(){
        $docentes = Pessoa::listarDocentes(null, 'A,P');

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
            $pessoa->tipo_vinculo = 'Docente'; 
            $pessoa->save();
        }        
    }

    private function sync_comissao_pesquisa(){

        putenv('REPLICADO_SYBASE=1');
    
        //pesquisas de pos doutorandos ativos
        $pesquisa = Pessoa::listarPesquisaPosDoutorandos();
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

                $curso = $this->retornarCursoGrdPorDepartamento($pd['sigla_departamento']);
                $comissao->cod_curso= isset($curso['codcur']) ? $curso['codcur'] : null;
                $comissao->nome_curso= isset($curso['nome_curso']) ? $curso['nome_curso'] : null;

                $comissao->cod_area= null;
                $comissao->nome_area= null;
                $comissao->tipo= 'PD';
               

                $comissao->save();
            }
        }        
        
        //pesquisadores colaborativos ativos
        $pesquisadores_colab = Pessoa::listarPesquisadoresColaboradoresAtivos();
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

                $curso = $this->retornarCursoGrdPorDepartamento($pc['sigla_departamento']);
                $comissao->cod_curso= isset($curso['codcur']) ? $curso['codcur'] : null;
                $comissao->nome_curso= isset($curso['nome_curso']) ? $curso['nome_curso'] : null;

                $comissao->cod_area= null;
                $comissao->nome_area= null;
                $comissao->tipo= 'PC';
                
                $comissao->save();
            }
        }

        //iniciação cientifica
        $iniciacao_cientifica = Pessoa::listarIniciaoCientificaAtiva();
        
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

                $curso = $this->retornarCursoGrdPorDepartamento($ic['sigla_departamento']);
                $comissao->cod_curso= isset($curso['codcur']) ? $curso['codcur'] : null;
                $comissao->nome_curso= isset($curso['nome_curso']) ? $curso['nome_curso'] : null;

                $comissao->cod_area= $ic['codare'];
                $comissao->nome_area= $ic['nome_programa'];
                $comissao->tipo= 'IC';

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
                         $curso = $this->retornarCursoGrdPorDepartamento($key);
                         $comissao->cod_curso= isset($curso['codcur']) ? $curso['codcur'] : null;
                         $comissao->nome_curso= isset($curso['nome_curso']) ? $curso['nome_curso'] : null;
                         $comissao->codpes_supervisor= null;
                         $comissao->codproj = null;
                         $comissao->nome_supervisor= null;
                         $comissao->ano_proj = null;
                         $comissao->bolsa = null;
                         $comissao->cod_departamento = null;
                         $comissao->cod_area= null;
                         $comissao->nome_area= null;
                         $comissao->tipo= 'PP';
                     
                         $comissao->save();
                     }
                 }
             }
         }
        
    }

    private function retornarCursoGrdPorDepartamento($sigla_departamento){
        $aux_cursos = [
            8010 => ['Filosofia', 'FLF'],
            8021 => ['Geografia', 'FLG'],
            8030 => ['História', 'FLH'],
            8040 => ['Ciências Sociais', 'FLA', 'FLP', 'FSL'],
            8051 => ['Letras', 'FLC', 'FLM', 'FLO', 'FLT', 'FLL'],
        ];
        $curso = [];
        foreach($aux_cursos as $key=>$value){
            if(in_array($sigla_departamento, $value)){
                $curso['codcur'] = $key; 
                $curso['nome_curso'] = $value[0]; 
            }
        }
        return $curso;
    }

    private function syncJson($pessoas, $codare = null, $tipo_pessoa = null){

        foreach($pessoas as $pessoa) {
                
            if(!isset($pessoa['codpes']) || empty($pessoa['codpes'])) continue;

            $aux_codare = $codare == null ? $pessoa['codare'] : $codare;
            $nivpgm = isset($pessoa['nivpgm']) ? $pessoa['nivpgm'] : null;

            $lattes = LattesModel::where('codpes',$pessoa['codpes'])->where('codare',$aux_codare)->where('tipo_pessoa',$tipo_pessoa)->where('tipo_pessoa',$nivpgm)->first();
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

