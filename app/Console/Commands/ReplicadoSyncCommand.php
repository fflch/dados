<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Uspdev\Replicado\Lattes;
use Uspdev\Replicado\Pessoa;
use Uspdev\Replicado\Posgraduacao;
use App\Models\Lattes as LattesModel;
use App\Utils\ReplicadoTemp;

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
       
        #$credenciados = ReplicadoTemp::credenciados($codare);
      
        echo "nusp;nome;lattes id;obs\n";
        foreach(ReplicadoTemp::credenciados() as $docente) {
            
            $lattes = LattesModel::where('codpes',$docente['codpes'])->first();
            if(!$lattes) {
                $lattes = new LattesModel;
            }
            if(Lattes::getArray($docente['codpes'])){
                $info_lattes = [];
                $info_lattes['nome'] = Pessoa::dump($docente['codpes'])['nompes'];
                $info_lattes['id_lattes'] = Lattes::id($docente['codpes']);
                $data_atualizacao = Lattes::getUltimaAtualizacao($docente['codpes'], null) ; 
                $info_lattes['data_atualizacao'] = $data_atualizacao ? substr($data_atualizacao, 0,2) . '/' . substr($data_atualizacao,2,2) . '/' . substr($data_atualizacao,4,4) : '-';
                $info_lattes['resumo'] = Lattes::getResumoCV($docente['codpes'], 'pt', null);
                $info_lattes['livros'] = Lattes::getLivrosPublicados($docente['codpes'], null, 'anual', -1, null);
                $info_lattes['linhas_pesquisa'] = Lattes::getLinhasPesquisa($docente['codpes'], null);
                $info_lattes['artigos'] = Lattes::getArtigos($docente['codpes'], null, 'anual', -1, null);
                $info_lattes['capitulos'] = Lattes::getCapitulosLivros($docente['codpes'], null, 'anual', -1, null);
                $info_lattes['jornal_revista'] = Lattes::getTextosJornaisRevistas($docente['codpes'], null, 'anual', -1, null);
                $info_lattes['outras_producoes_bibliograficas'] = Lattes::getOutrasProducoesBibliograficas($docente['codpes'], null, 'anual', -1, null);
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
