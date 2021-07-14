<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Uspdev\Utils\Generic;

class Pessoa extends Model
{
    public static function vinculos(){
        return [
            'docentes'      => 'Docentes',
            'estagiarios'   => 'Estagiários(as)',
            'funcionarios'  => 'Funcionários(as)',
        ];
    }

    public static function listarDocentes(){
        // Falta fazer o filtro das columas - idem no defesas -  não expor todas colunas
        $docentes = Pessoa::where('tipo_vinculo', 'Docente')->whereIn('codset', [591,602,594,598,592,600,601,599,604,603,596,558])->get()->toArray();
        $retorno = [];
        foreach($docentes as $docente){
            $nomefnc = json_decode($docente['json'], true);
            $nomefnc = $nomefnc['nomfnc'] ?? '';

            $aux = [
                'docente_id' => Generic::crazyHash($docente['codpes']),
                'nompes'        => $docente['nompes'],
                'codset'      => $docente['codset'],
                'nomset'      => $docente['nomset'],
                'email'      => isset($docente['email']) && str_contains($docente['email'], 'usp.br') ? $docente['email'] : '',
                'sitatl'      => $docente['sitatl'],
                'id_lattes'      => $docente['id_lattes'],
                'nomefnc'      => $nomefnc
            ];
            
            array_push($retorno, $aux);
        }
    

        return $retorno;
    }

    public static function listarEstagiarios(){
        $estagiarios = Pessoa::where('tipo_vinculo', 'Estagiario')->get()->toArray();

        $retorno = [];
        foreach($estagiarios as $estagiario){
            $aux = [
                'estagiario_id' => Generic::crazyHash($estagiario['codpes']),
                'nompes'        => $estagiario['nompes'],
                'codset'      => $estagiario['codset'],
                'nomset'      => $estagiario['nomset'],
                'email'      => isset($estagiario['email']) && str_contains($estagiario['email'], 'usp.br') ? $estagiario['email'] : '',
            ];
            
            array_push($retorno, $aux);
        }
    

        return $retorno;
    }

    public static function listarServidores(){
        $servidores = Pessoa::where('tipo_vinculo', 'Funcionário')->get()->toArray();

        $retorno = [];
        foreach($servidores as $servidor){
            $aux = [
                'servidor_id' => Generic::crazyHash($servidor['codpes']),
                'nompes'        => $servidor['nompes'],
                'codset'      => $servidor['codset'],
                'nomset'      => $servidor['nomset'],
                'email'      => isset($servidor['email']) && str_contains($servidor['email'], 'usp.br') ? $servidor['email'] : '',
            ];
            
            array_push($retorno, $aux);
        }
    

        return $retorno;
    }
    
    public static function listarChefesAdministrativos(){
        $chefes = Pessoa::where('tipo_vinculo', 'Chefe Administrativo')->get()->toArray();

        $retorno = [];
        foreach($chefes as $chefe){
            $aux = [
                'chefe_id' => Generic::crazyHash($chefe['codpes']),
                'nompes'        => $chefe['nompes'],
                'codset'      => $chefe['codset'],
                'nomset'      => $chefe['nomset'],
                'email'      => isset($chefe['email']) && str_contains($chefe['email'], 'usp.br') ? $chefe['email'] : '',
            ];
            
            array_push($retorno, $aux);
        }
    

        return $retorno;
    }
    
    public static function listarMonitores(){
        $monitores = Pessoa::where('tipo_vinculo', 'Monitor')->get()->toArray();

        $retorno = [];
        foreach($monitores as $monitor){
            $bolsas = json_decode($monitor['json'], true);

            $aux = [
                'monitor_id' => Generic::crazyHash($monitor['codpes']),
                'nompes'        => $monitor['nompes'],
                'email'      => isset($monitor['email']) && str_contains($monitor['email'], 'usp.br') ? $monitor['email'] : '',
                'bolsa_ini'      => $bolsas['bolsa_ini'],
                'bolsa_fim'      => $bolsas['bolsa_fim'],
                
            ];
            
            array_push($retorno, $aux);
        }
    

        return $retorno;
    }
}
