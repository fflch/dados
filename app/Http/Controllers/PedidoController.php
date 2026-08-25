<?php

namespace App\Http\Controllers;

use App\Http\Requests\PedidoRequest;
use App\Models\Pedido;
use Fflch\LaravelFflchStepper\Stepper;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Uspdev\Replicado\Pessoa;

class PedidoController extends Controller
{
    public function index(Request $request){
        Gate::authorize('admin');
        $pedidos = Pedido::all();
        return view('pedido.index', ['pedidos' => $pedidos]);
    }

    public function create(){
        $pedido = new Pedido;
        return view('pedido.create', ['pedido' => $pedido]);
    }

    public function store(PedidoRequest $request){
        if(Gate::allows('user')){
            $validated = $request->validated();
            $validated['user_codpes'] = auth()->user()->codpes;
            
            $pedido = Pedido::create($validated);
            $pedido->setStatus('Análise');
            return redirect("/pedidos/$pedido->id");
        }else{
            return redirect()->back()->withInput()->with('alert-warning', "Você precisa estar logado.");
        };
            
    }

    public function show(Pedido $pedido, Stepper $stepper){
        $stepper->setCurrentStepName($pedido->status);
        return view('pedido.show', ['pedido' => $pedido, 'stepper' => $stepper->render()]);
    }

    public function edit(Pedido $pedido){
        Gate::authorize('admin');
        return view('pedido.edit', [ 'pedido' => $pedido]);
    }

    public function update(PedidoRequest $request, Pedido $pedido){
        Gate::authorize('admin');
        $validated = $request->validated();

        $pedido->update($validated);
        $pedido->setStatus('Finalizado');
        $request->session()->flash('alert-success','Solicitação atualizada com sucesso.');

        return redirect("/pedidos/$pedido->id");
    }

    public function destroy(Pedido $pedido){
        Gate::authorize('admin');
        $pedido->delete();
        session()->flash('alert-info', 'Solicitação removida com sucesso.');
        return redirect('/pedidos');
    }

    public function meus_pedidos(){
        $pedidos = Pedido::where('user_codpes', auth()->user()->codpes)->get();
        return view('pedido.index', ['pedidos' => $pedidos]);
    }
}
