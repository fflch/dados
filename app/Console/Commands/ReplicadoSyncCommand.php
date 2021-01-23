<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Uspdev\Replicado\Lattes;
use Uspdev\Replicado\Pessoa;
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
       
        foreach(ReplicadoTemp::credenciados() as $docente) {
            $lattes = LattesModel::where('codpes',$docente['codpes'])->first();
            if(!$lattes) {
                $lattes = new LattesModel;
            }
            $lattes->codpes = $docente['codpes'];
            $lattes->json = Lattes::getJson($docente['codpes']);
            $lattes->save();
        }
        return 0;
    }
}
