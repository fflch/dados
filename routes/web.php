<?php

use Illuminate\Support\Facades\Route;


# Index
use App\Http\Controllers\IndexController;
Route::get('/', [IndexController::class, 'index']);

#Pedidos
use App\Http\Controllers\PedidoController;
Route::get('/pedidos/meuspedidos',  [PedidoController::class, 'meus_pedidos']);
Route::resource('pedidos',           PedidoController::class);

use App\Http\Controllers\AlunoGradController;
Route::get('/contagem-alunosgr', [AlunoGradController::class, 'show']);
Route::get('/contagem-alunosgr-planilha', [AlunoGradController::class, 'planilha'])->name('contagem-alunosGrad-planilha');

use App\Http\Controllers\VinculosController;
Route::get('/contagem-vinculos', [VinculosController::class, 'show']);
Route::get('/contagem-vinculos-planilha', [VinculosController::class, 'planilha'])->name('contagem-vinculos-planilha');

# Restrito
use App\Http\Controllers\RestritoController;
Route::get('/restrito', [RestritoController::class, 'restrito']);

# Colegiados
use App\Http\Controllers\Publico\ColegiadoController;
Route::get('/colegiados', [ColegiadoController::class, 'index']);
Route::get('/colegiados/{codclg}/{sglclg}', [ColegiadoController::class, 'show']);

use App\Http\Controllers\Restrito;
Route::get('restrito/graduacao', [Restrito\GraduacaoController::class,'index']);

Route::get('restrito/posgraduacao', [Restrito\PosGraduacaoController::class,'index']);
Route::get('restrito/posgraduacao/eleicao', [Restrito\PosGraduacaoController::class,'listarEleicao'])->name('pos-eleicao');

Route::get('restrito/estagios', [Restrito\EstagiosController::class,'index']);
Route::get('restrito/estagios/estagiarios', [Restrito\EstagiosController::class,'listarEstagiarios'])->name('estagiarios');

Route::get('restrito/extensao', [Restrito\ExtensaoController::class,'index']);

Route::get('restrito/pesquisa', [Restrito\PesquisaController::class,'index']);
Route::get('restrito/pesquisa/pd', [Restrito\PesquisaController::class,'planilhaPd'])->name('planilha-pd');

Route::get('restrito/internacional', [Restrito\InternacionalController::class,'index']);
Route::get('restrito/internacional/intercambistas', [Restrito\InternacionalController::class,'listarIntercambistasRecebidos'])->name('intercambistas');

Route::get('restrito/administrativo', [Restrito\administrativoController::class,'index']);

Route::get('restrito/docentes',[Restrito\DocentesController::class,'index']);
Route::get('restrito/docentes/planilha',[Restrito\DocentesController::class,'planilhaDocentes']);
Route::get('restrito/docentes/lista',[Restrito\DocentesController::class,'listar'])->name('docentes-lista');
Route::get('restrito/docentes/disciplinas',[Restrito\DocentesController::class,'disciplinas'])->name('docentes-disciplinas');
Route::get('restrito/docentes/disciplinas/planilha',[Restrito\DocentesController::class,'planilhaDisciplinas'])->name('docentes-disciplinas-planilha');

use App\Http\Controllers\DisciplinaController;
Route::get('/turmas', [DisciplinaController::class, 'turmas']);
Route::get('/turmas/{prefix}', [DisciplinaController::class, 'prefix']);
Route::get('/turmas/{prefix}/concatenate', [DisciplinaController::class, 'concatenate']);


use App\Http\Controllers\LattesController;
Route::prefix('lattes')->group(function () {
    Route::get('dashboard', [LattesController::class, 'dashboard'])->name('lattes.dashboard');
    //exports
    Route::get('docente/{codpes}/export', [LattesController::class, 'exportarDocente'])->name('lattes.exportar');
    Route::get('docente/{codpes}/export-detalhado', [LattesController::class, 'exportarDetalhado'])->name('lattes.exportar_detalhado');
    Route::get('api/metricas', [LattesController::class, 'apiMetricas'])->name('lattes.api.metricas');
});

// settings
use App\Http\Controllers\GeneralSettingsController;
Route::get('/settings', [GeneralSettingsController::class, 'show']);
Route::post('/settings', [GeneralSettingsController::class, 'update']);

