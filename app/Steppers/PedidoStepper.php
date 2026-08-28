<?php

namespace App\Steppers;

use Axn\LaravelStepper\Stepper;
use App\Models\Pedido;

class PedidoStepper extends Stepper
{
    protected $view = 'laravel-fflch-stepper::main';

    public function __construct(
        protected Pedido $pedido
    ){
        parent::__construct();
    }

    public function register()
    {
        $steps = config('laravel-fflch-stepper.steps');

        foreach($steps as $key=>$value){
            if($this->pedido->status == 'Análise'){
                $this->addStep($key);
                break;
            }

            if($this->pedido->status == "Aprovado" && $key == 'Rejeitado'){
                continue;
            }

            if($this->pedido->status == "Rejeitado" && $key == 'Aprovado'){
                continue;
            }

            $this->addStep($key);
        }

        $this->setCurrentStepName($this->pedido->status);
    }
}
