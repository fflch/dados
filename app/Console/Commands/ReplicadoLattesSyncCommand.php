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

class ReplicadoLattesSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'replicadolattessync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincronização da parte do lattes (cnpq) do armazenamento de dados do replicado para o banco local';

    /**
     * Create a new command instance.
     *
     * @return void
     **/
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

        if(getenv('REPLICADO_SYBASE') != '0') putenv('REPLICADO_SYBASE=0');

        $docentes = array_column(Pessoa::listarDocentes(null, 'A,P'), 'codpes');
        $credenciados = array_column(ReplicadoTemp::credenciados(), 'codpes');
        $discentes = [];
        $egressos = [];

        $codpes = array_merge($credenciados, $docentes);

        $programas = Posgraduacao::programas(8);
        foreach($programas as $value) {
            $discentes[$value['codare']] = array_column(ReplicadoTemp::listarAlunosAtivosPrograma($value['codare'],8), 'codpes');
            $egressos[$value['codare']] = array_column(Posgraduacao::egressosArea($value['codare']), 'codpes');
            $codpes = array_merge($codpes, $discentes[$value['codare']], $egressos[$value['codare']]);
        }
        $codpes = array_unique($codpes);
        sort($codpes);

        $this->syncLattes($codpes);

        //salvando departamentos em programas
        $departamentos = [];
        for($i = 0; $i < sizeof(Util::departamentos); $i++){
            $departamento = Util::departamentos[array_keys(Util::departamentos)[$i]];
            $aux_departamento = [];
            $aux_departamento['sigla'] = array_keys(Util::departamentos)[$i];
            $aux_departamento['codigo'] = $departamento[0];
            $aux_departamento['nome'] = $departamento[1];
            $aux_departamento['codpes_docentes'] =  array_column(Pessoa::listarDocentes($aux_departamento['codigo']), 'codpes');
            $aux_departamento['id_lattes_docentes'] = $this->listar_id_lattes_por_nusp($aux_departamento['codpes_docentes']);
            $aux_departamento['total_docentes'] = LattesModel::whereIn('codpes', $aux_departamento['codpes_docentes'])->get()->count();
            $departamentos[] = $aux_departamento;
        }
        $departamento = Programa::where('codare',0)->first();
        if(!$departamento) $departamento = new Programa;
        $departamento->codare = 0;
        $departamento->json = json_encode($departamentos);
        $departamento->save();

        $this->sync_comissao_pesquisa();

        putenv('REPLICADO_SYBASE=1');

        $programas = Posgraduacao::programas(8);

        foreach($programas as $key=>$value) {
            $programa = Programa::where('codare',$value['codare'])->first();
            if(!$programa) $programa = new Programa;

            $cred = array_column(ReplicadoTemp::credenciados($value['codare']), 'codpes');
            $programas[$key]['docentes'] =  $cred;
            $programas[$key]['discentes'] = $discentes[$value['codare']];
            $programas[$key]['egressos'] = $egressos[$value['codare']];

            $programas[$key]['docentes'] =  $this->listar_id_lattes_por_nusp($cred);
            $programas[$key]['discentes'] = $this->listar_id_lattes_por_nusp($discentes[$value['codare']]);
            $programas[$key]['egressos'] = $this->listar_id_lattes_por_nusp($egressos[$value['codare']]);

            $programas[$key]['total_docentes'] =  LattesModel::whereIn('codpes', $cred)->get()->count();
            $programas[$key]['total_discentes'] = LattesModel::whereIn('codpes', $discentes[$value['codare']])->get()->count();
            $programas[$key]['total_egressos'] = LattesModel::whereIn('codpes', $egressos[$value['codare']])->get()->count();
            $programa->codare = $value['codare'];

            $programa->json = json_encode($programas[$key]);
            $programa->save();
        }

        return 0;
    }

    private function listar_id_lattes_por_nusp($lista_nusp){
        $codpes_pessoas = implode(',', $lista_nusp);
        $id_lattes = \DB::select("SELECT id_lattes FROM lattes WHERE codpes  IN ( $codpes_pessoas )");
        $lista_id_lattes = [];
        foreach($id_lattes as $id)
            $lista_id_lattes[] = $id->id_lattes;
        return $lista_id_lattes;
    }

    private function sync_comissao_pesquisa(){
         //projetos de pesquisa dos docentes
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
                         $comissao->tipo= 'PP';

                         $comissao->save();
                     }
                 }
             }
         }
    }

    private function syncLattes($pessoas){

        foreach($pessoas as $codpes) {

            $lattes = LattesModel::where('codpes',$codpes)->first();

            if(!$lattes) {
                $lattes = new LattesModel;
            }

            $lattes_array = Lattes::obterArray($codpes);

            if($lattes_array){
                if(!empty($lattes->json)){
                    $info_lattes = json_decode($lattes->json, true);
                }else{
                    $info_lattes = [];
                }

                $info_lattes['id_lattes'] = Lattes::id($codpes);

                $info_lattes['orcid'] = Lattes::retornarOrcidID($codpes, $lattes_array);
                $data_atualizacao = Lattes::retornarUltimaAtualizacao($codpes, $lattes_array) ;
                $info_lattes['data_atualizacao'] = $data_atualizacao ? substr($data_atualizacao, 0,2) . '/' . substr($data_atualizacao,2,2) . '/' . substr($data_atualizacao,4,4) : '-';
                $info_lattes['resumo'] = Lattes::retornarResumoCV($codpes, 'pt', $lattes_array);
                $info_lattes['livros'] = Lattes::listarLivrosPublicados($codpes, $lattes_array, 'anual', -1, null);
                $info_lattes['linhas_pesquisa'] = Lattes::listarLinhasPesquisa($codpes, $lattes_array);
                $info_lattes['artigos'] = Lattes::listarArtigos($codpes, $lattes_array, 'anual', -1, null);
                $info_lattes['capitulos'] = Lattes::listarCapitulosLivros($codpes, $lattes_array, 'anual', -1, null);
                $info_lattes['jornal_revista'] = Lattes::listarTextosJornaisRevistas($codpes, $lattes_array, 'anual', -1, null);
                $info_lattes['trabalhos_anais'] = Lattes::listarTrabalhosAnais($codpes, $lattes_array, 'anual', -1, null);
                $info_lattes['outras_producoes_bibliograficas'] = Lattes::listarOutrasProducoesBibliograficas($codpes, $lattes_array, 'anual', -1, null);
                $info_lattes['trabalhos_tecnicos'] = Lattes::listarTrabalhosTecnicos($codpes, $lattes_array, 'anual', -1, null);
                $info_lattes['ultimo_vinculo_profissional'] = Lattes::listarFormacaoProfissional($codpes, $lattes_array, 'anual', -1, null);
                $info_lattes['ultima_formacao'] = Lattes::retornarFormacaoAcademica($codpes, $lattes_array, 'anual', -1, null);
                $info_lattes['ultimo_vinculo_profissional'] = Lattes::listarFormacaoProfissional($codpes, $lattes_array, 'anual', -1, null);
                $info_lattes['organizacao_evento'] = Lattes::listarOrganizacaoEvento($codpes, $lattes_array, 'anual', -1, null);
                $info_lattes['outras_producoes_tecnicas'] = Lattes::listarOutrasProducoesTecnicas($codpes, $lattes_array, 'anual', -1, null);
                $info_lattes['curso_curta_duracao'] = Lattes::listarCursosCurtaDuracao($codpes, $lattes_array, 'anual', -1, null);
                $info_lattes['relatorio_pesquisa'] = Lattes::listarRelatorioPesquisa($codpes, $lattes_array, 'anual', -1, null);
                $info_lattes['material_didatico'] = Lattes::listarMaterialDidaticoInstrucional($codpes, $lattes_array, 'anual', -1, null);
                $info_lattes['projetos_pesquisa'] = Lattes::listarProjetosPesquisa($codpes, $lattes_array, 'anual', -1, null);
                $info_lattes['radio_tv'] = Lattes::listarRadioTV($codpes, $lattes_array, 'anual', -1, null);
                $info_lattes['apresentacao_trabalho'] = Lattes::listarApresentacaoTrabalho($codpes, $lattes_array, 'anual', -1, null);

                $lattes->id_lattes = $info_lattes['id_lattes'] ?? null;
                $lattes->codpes = $codpes;
                $lattes->json = json_encode($info_lattes);

                $lattes->save();

            } else {
                $lattes->codpes = $codpes;
                $lattes->json = null;
                $lattes->save();
            }

        }

    }

}

