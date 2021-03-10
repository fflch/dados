<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Uspdev\Replicado\Lattes;
use Uspdev\Replicado\Pessoa;
use Uspdev\Replicado\Posgraduacao;
use App\Models\Lattes as LattesModel;
use App\Utils\ReplicadoTemp;
use App\Models\Programa;

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
        $this->syncJson(ReplicadoTemp::credenciados());
        
        foreach($programas as $value) {
            $this->syncJson(Posgraduacao::egressosArea($value['codare']));
            $this->syncJson(Posgraduacao::obterAtivosPorArea($value['codare'],8));
        }

        return 0;
    }

    private function syncJson($pessoas){
        foreach($pessoas as $pessoa) {

            if(!isset($pessoa['codpes']) || empty($pessoa['codpes'])) continue;


            $lattes = LattesModel::where('codpes',$pessoa['codpes'])->first();
            if(!$lattes) {
                $lattes = new LattesModel;
            }
            if(Lattes::obterArray($pessoa['codpes'])){
                $info_lattes = [];

                putenv('REPLICADO_SYBASE=1');
                $info_lattes['nome'] = Pessoa::dump($pessoa['codpes'])['nompes'];
                $info_lattes['orientandos'] = Posgraduacao::obterOrientandosAtivos($pessoa['codpes']);
                $info_lattes['orientandos_concluidos'] = Posgraduacao::obterOrientandosConcluidos($pessoa['codpes']);

                putenv('REPLICADO_SYBASE=0');
                $info_lattes['id_lattes'] = Lattes::id($pessoa['codpes']);
                $data_atualizacao = Lattes::retornarUltimaAtualizacao($pessoa['codpes'], null) ;
                $info_lattes['data_atualizacao'] = $data_atualizacao ? substr($data_atualizacao, 0,2) . '/' . substr($data_atualizacao,2,2) . '/' . substr($data_atualizacao,4,4) : '-';
                $info_lattes['resumo'] = Lattes::retornarResumoCV($pessoa['codpes'], 'pt', null);
                $info_lattes['livros'] = Lattes::listarLivrosPublicados($pessoa['codpes'], null, 'anual', -1, null);
                $info_lattes['linhas_pesquisa'] = Lattes::listarLinhasPesquisa($pessoa['codpes'], null);
                $info_lattes['artigos'] = Lattes::listarArtigos($pessoa['codpes'], null, 'anual', -1, null);
                $info_lattes['capitulos'] = Lattes::listarCapitulosLivros($pessoa['codpes'], null, 'anual', -1, null);
                $info_lattes['jornal_revista'] = Lattes::listarTextosJornaisRevistas($pessoa['codpes'], null, 'anual', -1, null);
                $info_lattes['trabalhos_anais'] = Lattes::listarTrabalhosAnais($pessoa['codpes'], null, 'anual', -1, null);
                $info_lattes['outras_producoes_bibliograficas'] = Lattes::listarOutrasProducoesBibliograficas($pessoa['codpes'], null, 'anual', -1, null);
                $info_lattes['trabalhos_tecnicos'] = Lattes::listarTrabalhosTecnicos($pessoa['codpes'], null, 'anual', -1, null);
                $info_lattes['ultimo_vinculo_profissional'] = Lattes::listarFormacaoProfissional($pessoa['codpes'], null, 'anual', -1, null);
                $info_lattes['ultima_formacao'] = Lattes::retornarFormacaoAcademica($pessoa['codpes'], null, 'anual', -1, null);
                $info_lattes['ultimo_vinculo_profissional'] = Lattes::listarFormacaoProfissional($pessoa['codpes'], null, 'anual', -1, null);
                $info_lattes['organizacao_evento'] = Lattes::listarOrganizacaoEvento($pessoa['codpes'], null, 'anual', -1, null);
                $info_lattes['outras_producoes_tecnicas'] = Lattes::listarOutrasProducoesTecnicas($pessoa['codpes'], null, 'anual', -1, null);
                $info_lattes['curso_curta_duracao'] = Lattes::listarCursosCurtaDuracao($pessoa['codpes'], null, 'anual', -1, null);
                $info_lattes['relatorio_pesquisa'] = Lattes::listarRelatorioPesquisa($pessoa['codpes'], null, 'anual', -1, null);
                $info_lattes['material_didatico'] = Lattes::listarMaterialDidaticoInstrucional($pessoa['codpes'], null, 'anual', -1, null);

                $lattes->codpes = $pessoa['codpes'];
                $lattes->json = json_encode($info_lattes);
                $lattes->save();

                # talvez não precise
                if(!$lattes->json){
                    echo $pessoa['codpes'] .";". Pessoa::dump($pessoa['codpes'])['nompes'] .";". Lattes::id($pessoa['codpes']) .";erro no json_encode\n";
                }
            } else {
                echo $pessoa['codpes'] .";". Pessoa::dump($pessoa['codpes'])['nompes'] .";". Lattes::id($pessoa['codpes']) .";lattes não encontrado\n";
            }
        }
    }

}

