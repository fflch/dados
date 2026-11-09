<?php

namespace App\Console\Commands;

use App\Imports\FapespImport;
use App\Models\ProjetoFapesp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SyncBvFapesp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-bv-fapesp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // baixando o csv com todos os projetos com bolsa na BV FAPESP
        $url = 'https://media.fapesp.br/bv/uploads/gera_csv_assincrono/csv/bolsas_no_brasil_em_andamento.csv';
        $path = storage_path('app/private/bv-bolsas.csv');

        $response = Http::withOptions([
            'sink' => $path,
            'timeout' => 0,
            'connect_timeout' => 30,
        ])->get($url);

        $response->throw();
        
        //inserindo os projetos da fflch no banco de dados
        ProjetoFapesp::query()->delete();
        Excel::import(new FapespImport, storage_path('app/private/bv-bolsas.csv'));
        unlink(storage_path('app/private/bv-bolsas.csv'));
        
        

    }
}
