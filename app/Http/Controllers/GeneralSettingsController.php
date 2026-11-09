<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Settings\GeneralSettings;
use App\Http\Requests\SettingsRequest;


class GeneralSettingsController extends Controller
{
    public function show(GeneralSettings $settings)
    {
        Gate::authorize('admin');

        return view('settings.show', [
            'criacao_pedido_mail'   => $settings->criacao_pedido_mail,
            'alteracao_pedido_mail' => $settings->alteracao_pedido_mail   
        ]);
    }

    public function update(SettingsRequest $request, GeneralSettings $settings){
        Gate::authorize('admin');
        $validated = $request->validated();
        $settings->criacao_pedido_mail = $request->input('criacao_pedido_mail');


        $settings->save();
        return redirect()->back();
    }
}
