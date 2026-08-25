<?php

namespace App\Http\Controllers;

use App\Http\Requests\PedidoRequest;
use App\Models\Pedido;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index(Request $request){
        Gate::authorize('admin');
        if($request->has('search')){
            $pedidos = Pedido::where('assunto', 'like', '%'.$request->search.'%')->get();
        }else{
            $pedidos = Pedido::all();
        } 

        return view('pedido.index', ['pedidos' => $pedidos]);
    }

    public function create(){
        $pedido = new Pedido;
        return view('pedido.create', ['pedido' => $pedido]);
    }

    public function store(PedidoRequest $request){
        if(Gate::allows('user')){
            $validated = $request->validated();
            $validated['user_id'] = auth()->user()->id;
            
            $pedido = Pedido::create($validated);
            return redirect("/pedidos/$pedido->id");
        }else{
            return redirect()->back()->withInput()->with('alert-warning', "Você precisa estar logado.");
        };
            
    }

    public function show(Pedido $pedido){
        return view('pedido.show', ['pedido' => $pedido]);
    }

    public function edit(Pedido $pedido){
        Gate::authorize('admin');
        return view('pedido.edit', [ 'pedido' => $pedido]);
    }

    public function update(PedidoRequest $request, Pedido $pedido){
        Gate::authorize('admin');
        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->id;

        $pedido->update($validated);
        $request->session()->flash('alert-success','Livro atualizado com sucesso.');

        return redirect("/pedidos/$pedido->id");
    }

    public function destroy(Pedido $pedido){
        Gate::authorize('admin');
        $pedido->delete();
        session()->flash('alert-info', 'Solicitação removida com sucesso.');
        return redirect('/pedidos');
    }
}
