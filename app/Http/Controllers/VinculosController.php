<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use App\Utils\Util;

class VinculosController extends Controller
{
    public function show(Request $request){
        $data = Util::query('contagem_vinculos');
        unset($data[array_find_key($data, fn($reg)=>$reg['tipvinext']=='Servidor Designado')]);
        
        Cache::put($request->session()->getId().'contagem_vinculos',$data,600);
        return view('vinculos',['data' => $data]);
    }

    public function planilha(Request $request, Excel $excel){
        
        $data = Cache::get($request->session()->getId().'contagem_vinculos');
        
        if(!isset($data)){
            $data = Util::query('contagem_vinculos');
            unset($data[array_find_key($data, fn($reg)=>$reg['tipvinext']=='Servidor Designado')]);
        }
    
        $export = new DadosExport([$data],
        ['Vínculo','Quantidade']);

        return $excel->download($export,'vínculos ativos.xlsx');
    
    }
}