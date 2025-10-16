<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Uspdev\Replicado\DB;
use App\Utils\ReplicadoTemp;

class DisciplinaController extends Controller
{
    public function turmas(){
        return view('disciplinas.turmas');
    }
    private function formataTurmas($turmas){
        //comparar os horários para ordenar
        $compdia = function (string $data1, string $data2){
            $diasSemana = [
                'seg' => 1,  // Segunda-feira
                'ter' => 2,  // Terça-feira
                'qua' => 3,  // Quarta-feira
                'qui' => 4,  // Quinta-feira
                'sex' => 5,  // Sexta-feira
                'sab' => 6,  // Sábado
                'dom' => 7   // Domingo
            ];

            // Extrai as 3 primeiras letras do dia da semana de cada data
            $dia1 = substr($data1, 0, 3);
            $dia2 = substr($data2, 0, 3);

            // Obtém os números dos dias da semana
            $numeroDia1 = $diasSemana[$dia1] ?? null;
            $numeroDia2 = $diasSemana[$dia2] ?? null;

            // Verifica se os dias são válidos
            if ($numeroDia1 === null || $numeroDia2 === null) {
                return 0; // Se não forem válidos, assume como iguais
            }

            // Compara os números dos dias da semana
            if ($numeroDia1 == $numeroDia2) {
                return 0;
            }
            return ($numeroDia1 < $numeroDia2) ? -1 : 1;
        };

        foreach ($turmas as &$turma) {
            //ordena os docentes e coloca em uma unica string
            sort($turma['nompes']);
            $turma['nompes'] = implode(', ', $turma['nompes']);

            //ordena os horarios e coloca em uma unica string
            if (count($turma['horario'])==1 && substr($turma['horario'][0],0,2) == "- ") {
                $turma['horario'] = [];
            }
            usort($turma['horario'],$compdia);
            $turma['horario'] = implode(', ', $turma['horario']);
        }
        return $turmas;
    }
    public function prefix($prefix){
        $turmas = ReplicadoTemp::turmasCompleto($prefix);
        
        return view('disciplinas.turma',[
            'prefix' => $prefix,
            'turmas' => $this->formataTurmas($turmas),
        ]);
    }

    public function concatenate($prefix){
        $turmas = ReplicadoTemp::turmasCompleto($prefix);

        return view('disciplinas.concatenate',[
            'prefix' => $prefix,
            'turmas' => $this->formataTurmas($turmas),
        ]);
    }
}