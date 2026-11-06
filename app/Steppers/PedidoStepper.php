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
            //se o pedido for rejeitado o stepper só terá esse estado
            if($this->pedido->status == "Rejeitado" )
            {
              $this->addStep("Rejeitado");
              break;   
            }

            //caso o pedido não seja rejeitado serão mostrados todos os estado menos "Rejeitado".
            if($key != "Rejeitado")$this->addStep($key);

        }

        $this->setCurrentStepName($this->pedido->status);
    }
}
