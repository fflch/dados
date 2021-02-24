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
       
        #$credenciados = ReplicadoTemp::credenciados($codare);
      
        echo "nusp;nome;lattes id;obs\n";
        foreach(Posgraduacao::egressosArea($value['codare']) as $egresso) {
            
            $lattes = LattesModel::where('codpes',$egresso['codpes'])->first();
            if(!$lattes) {
                $lattes = new LattesModel;
            }
            if(Lattes::obterArray($egresso['codpes'])){
                $info_lattes = [];
                $info_lattes['nome'] = Pessoa::dump($egresso['codpes'])['nompes'];
                $info_lattes['id_lattes'] = Lattes::id($egresso['codpes']);
                $data_atualizacao = Lattes::retornarUltimaAtualizacao($egresso['codpes'], null) ; 
                $info_lattes['data_atualizacao'] = $data_atualizacao ? substr($data_atualizacao, 0,2) . '/' . substr($data_atualizacao,2,2) . '/' . substr($data_atualizacao,4,4) : '-';
                $info_lattes['resumo'] = Lattes::retornarResumoCV($egresso['codpes'], 'pt', null);
                $info_lattes['livros'] = Lattes::listarLivrosPublicados($egresso['codpes'], null, 'anual', -1, null);
                $info_lattes['linhas_pesquisa'] = Lattes::listarLinhasPesquisa($egresso['codpes'], null);
                $info_lattes['artigos'] = Lattes::listarArtigos($egresso['codpes'], null, 'anual', -1, null);
                $info_lattes['capitulos'] = Lattes::listarCapitulosLivros($egresso['codpes'], null, 'anual', -1, null);
                $info_lattes['jornal_revista'] = Lattes::listarTextosJornaisRevistas($egresso['codpes'], null, 'anual', -1, null);
                $info_lattes['trabalhos_anais'] = Lattes::listarTrabalhosAnais($egresso['codpes'], null, 'anual', -1, null);
                $info_lattes['outras_producoes_bibliograficas'] = Lattes::listarOutrasProducoesBibliograficas($egresso['codpes'], null, 'anual', -1, null);
                $info_lattes['trabalhos_tecnicos'] = Lattes::listarTrabalhosTecnicos($egresso['codpes'], null, 'anual', -1, null);
                #$info_lattes['organizacao_evento'] = Lattes::getOrganizacaoEvento($egresso['codpes'], null, 'anual', -1, null);
                #$info_lattes['outras_producoes_tecnicas'] = Lattes::getOutrasProducoesTecnicas($egresso['codpes'], null, 'anual', -1, null);
                foreach(Lattes::retornarFormacaoAcademica($egresso['codpes']) as $key=>$value)
                {
                    $value['TIPO'] = $key;
                    $info_lattes['ultima_formacao'] = $value;
                    break;
                }
                
                $lattes->codpes = $egresso['codpes'];
                $lattes->json = $this->safe_json_encode($info_lattes);
                
                $lattes->save();
                
                if(!$lattes->json){
                    echo $egresso['codpes'] .";". Pessoa::dump($egresso['codpes'])['nompes'] .";". Lattes::id($egresso['codpes']) .";erro no json_encode\n";
                }
            }else{
                echo $egresso['codpes'] .";". Pessoa::dump($egresso['codpes'])['nompes'] .";". Lattes::id($egresso['codpes']) .";lattes não encontrado\n";
            }
        }

        foreach(ReplicadoTemp::credenciados() as $docente) {
            
            $lattes = LattesModel::where('codpes',$docente['codpes'])->first();
            if(!$lattes) {
                $lattes = new LattesModel;
            }
            if(Lattes::obterArray($docente['codpes'])){
                $info_lattes = [];
                $info_lattes['nome'] = Pessoa::dump($docente['codpes'])['nompes'];
                $info_lattes['id_lattes'] = Lattes::id($docente['codpes']);
                $data_atualizacao = Lattes::retornarUltimaAtualizacao($docente['codpes'], null) ; 
                $info_lattes['data_atualizacao'] = $data_atualizacao ? substr($data_atualizacao, 0,2) . '/' . substr($data_atualizacao,2,2) . '/' . substr($data_atualizacao,4,4) : '-';
                $info_lattes['resumo'] = Lattes::retornarResumoCV($docente['codpes'], 'pt', null);
                $info_lattes['livros'] = Lattes::listarLivrosPublicados($docente['codpes'], null, 'anual', -1, null);
                $info_lattes['linhas_pesquisa'] = Lattes::listarLinhasPesquisa($docente['codpes'], null);
                $info_lattes['artigos'] = Lattes::listarArtigos($docente['codpes'], null, 'anual', -1, null);
                $info_lattes['capitulos'] = Lattes::listarCapitulosLivros($docente['codpes'], null, 'anual', -1, null);
                $info_lattes['jornal_revista'] = Lattes::listarTextosJornaisRevistas($docente['codpes'], null, 'anual', -1, null);
                $info_lattes['trabalhos_anais'] = Lattes::listarTrabalhosAnais($docente['codpes'], null, 'anual', -1, null);
                $info_lattes['outras_producoes_bibliograficas'] = Lattes::listarOutrasProducoesBibliograficas($docente['codpes'], null, 'anual', -1, null);
                $info_lattes['trabalhos_tecnicos'] = Lattes::listarTrabalhosTecnicos($docente['codpes'], null, 'anual', -1, null);
                #$info_lattes['organizacao_evento'] = Lattes::getOrganizacaoEvento($egresso['codpes'], null, 'anual', -1, null);
                #$info_lattes['outras_producoes_tecnicas'] = Lattes::getOutrasProducoesTecnicas($egresso['codpes'], null, 'anual', -1, null);

                //$info_lattes['orientandos'] = Posgraduacao::obterOrientandosAtivos($docente['codpes']);
                //$info_lattes['orientandos_concluidos'] = Posgraduacao::obterOrientandosConcluidos($docente['codpes']);
                
                $lattes->codpes = $docente['codpes'];
                $lattes->json = $this->safe_json_encode($info_lattes);
                
                $lattes->save();
                
                if(!$lattes->json){
                    echo $docente['codpes'] .";". Pessoa::dump($docente['codpes'])['nompes'] .";". Lattes::id($docente['codpes']) .";erro no json_encode\n";
                }
            }else{
                echo $docente['codpes'] .";". Pessoa::dump($docente['codpes'])['nompes'] .";". Lattes::id($docente['codpes']) .";lattes não encontrado\n";
            }
        }

        foreach(Posgraduacao::obterAtivosPorArea($value['codare'],8) as $discente) {
            
            $lattes = LattesModel::where('codpes',$discente['codpes'])->first();
            if(!$lattes) {
                $lattes = new LattesModel;
            }
            if(Lattes::obterArray($discente['codpes'])){
                $info_lattes = [];
                $info_lattes['nome'] = Pessoa::dump($discente['codpes'])['nompes'];
                $info_lattes['id_lattes'] = Lattes::id($discente['codpes']);
                $data_atualizacao = Lattes::retornarUltimaAtualizacao($discente['codpes'], null) ; 
                $info_lattes['data_atualizacao'] = $data_atualizacao ? substr($data_atualizacao, 0,2) . '/' . substr($data_atualizacao,2,2) . '/' . substr($data_atualizacao,4,4) : '-';
                $info_lattes['resumo'] = Lattes::retornarResumoCV($discente['codpes'], 'pt', null);
                $info_lattes['livros'] = Lattes::listarLivrosPublicados($discente['codpes'], null, 'anual', -1, null);
                $info_lattes['linhas_pesquisa'] = Lattes::listarLinhasPesquisa($discente['codpes'], null);
                $info_lattes['artigos'] = Lattes::listarArtigos($discente['codpes'], null, 'anual', -1, null);
                $info_lattes['capitulos'] = Lattes::listarCapitulosLivros($discente['codpes'], null, 'anual', -1, null);
                $info_lattes['jornal_revista'] = Lattes::listarTextosJornaisRevistas($discente['codpes'], null, 'anual', -1, null);
                $info_lattes['trabalhos_anais'] = Lattes::listarTrabalhosAnais($discente['codpes'], null, 'anual', -1, null);
                $info_lattes['outras_producoes_bibliograficas'] = Lattes::listarOutrasProducoesBibliograficas($discente['codpes'], null, 'anual', -1, null);
                $info_lattes['trabalhos_tecnicos'] = Lattes::listarTrabalhosTecnicos($discente['codpes'], null, 'anual', -1, null);
                #$info_lattes['organizacao_evento'] = Lattes::getOrganizacaoEvento($egresso['codpes'], null, 'anual', -1, null);
                #$info_lattes['outras_producoes_tecnicas'] = Lattes::getOutrasProducoesTecnicas($egresso['codpes'], null, 'anual', -1, null);

                $lattes->codpes = $discente['codpes'];
                $lattes->json = $this->safe_json_encode($info_lattes);
                
                $lattes->save();
                
                if(!$lattes->json){
                    echo $discente['codpes'] .";". Pessoa::dump($discente['codpes'])['nompes'] .";". Lattes::id($discente['codpes']) .";erro no json_encode\n";
                }
            }else{
                echo $discente['codpes'] .";". Pessoa::dump($discente['codpes'])['nompes'] .";". Lattes::id($discente['codpes']) .";lattes não encontrado\n";
            }
        }

        return 0;
    }

    function safe_json_encode($value, $options = 0, $depth = 512, $utfErrorFlag = false) {
        $encoded = json_encode($value, $options, $depth);
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return $encoded;
            case JSON_ERROR_DEPTH:
                return 'Maximum stack depth exceeded'; // or trigger_error() or throw new Exception()
            case JSON_ERROR_STATE_MISMATCH:
                return 'Underflow or the modes mismatch'; // or trigger_error() or throw new Exception()
            case JSON_ERROR_CTRL_CHAR:
                return 'Unexpected control character found';
            case JSON_ERROR_SYNTAX:
                return 'Syntax error, malformed JSON'; // or trigger_error() or throw new Exception()
            case JSON_ERROR_UTF8:
                $clean = $this->utf8ize($value);
                if ($utfErrorFlag) {
                    return 'UTF8 encoding error'; // or trigger_error() or throw new Exception()
                }
                return $this->safe_json_encode($clean, $options, $depth, true);
            default:
                return 'Unknown error'; // or trigger_error() or throw new Exception()
    
        }
    }
    
    function utf8ize($mixed) {
        if (is_array($mixed)) {
            foreach ($mixed as $key => $value) {
                $mixed[$key] = $this->utf8ize($value);
            }
        } else if (is_string ($mixed)) {
            return utf8_encode($mixed);
        }
        return $mixed;
    }
}
