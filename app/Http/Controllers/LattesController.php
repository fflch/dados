<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LattesMetricsService;
use Uspdev\Replicado\Pessoa;
use Uspdev\Replicado\Lattes;
use App\Services\Replicado\Lattes as LattesService;
use Illuminate\Support\Facades\Cache;

use App\Exports\DocenteExport;
use App\Exports\DocenteDetalhadoExport;
use App\Exports\ArraySheetExport;
use Maatwebsite\Excel\Facades\Excel;

class LattesController extends Controller
{
    protected $metricsService;

    public function __construct(LattesMetricsService $metricsService)
    {
        $this->metricsService = $metricsService;
    }

    public function index()
    {
        return view('lattes.index');
    }

    public function dashboard(Request $request)
    {
        $limit = 5; // Or your desired limit
        $busca = $request->input('busca');
        $departamento_filtro = $request->input('departamento');
        $page = $request->input('page', 1, FILTER_VALIDATE_INT);

        // 1. Get the full list of active professors, pre-filtered by department if applicable.
        // This is much more efficient than filtering in PHP.
        $codDepto = $this->getCodDeptoPorNome($departamento_filtro);
        $todosDocentes = Pessoa::listarDocentes($codDepto, 'A');

        // 2. Filter the list by name using the search term.
        $docentesFiltrados = $this->filtrarDocentesPorNome($todosDocentes, $busca);

        // 3. Paginate the filtered list and fetch detailed metrics ONLY for the current page.
        $docentesComMetricas = $this->obterMetricasParaPagina($docentesFiltrados, $limit, $page);

        // 4. Create a manual paginator instance.
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $docentesComMetricas,
            count($docentesFiltrados),
            $limit,
            $page,
            ['path' => url()->current(), 'query' => $request->query()]
        );

        return view('lattes.docentes.dashboard', [
            'docentes' => $paginator,
            'limit' => $limit,
            'busca' => $busca,
            'departamento_filtro' => $departamento_filtro,
        ]);
    }

    /**
     * Filters a list of professors by name.
     */
    private function filtrarDocentesPorNome(array $docentes, ?string $busca): array
    {
        if (empty($busca)) {
            return $docentes;
        }

        return array_values(array_filter($docentes, function ($docente) use ($busca) {
            return stripos(utf8_encode($docente['nompes'] ?? ''), $busca) !== false;
        }));
    }

    /**
     * Paginates an array of professors and fetches detailed metrics for the current page.
     */
    private function obterMetricasParaPagina(array $docentes, int $limit, int $page): array
    {
        $offset = ($page - 1) * $limit;
        $docentesPagina = array_slice($docentes, $offset, $limit);

        $docentesComMetricas = [];
        foreach ($docentesPagina as $docente) {
            $metricas = $this->metricsService->getMetricasDetalhadas($docente['codpes']);
            $docente['nompes'] = utf8_encode($docente['nompes'] ?? '');

            // Optimization: Fetch and cache departments only for the professors on the current page.
            $departamentos = $this->getDepartamentosDocente($docente['codpes']);

            $docentesComMetricas[] = array_merge($metricas, [
                'docente' => $docente,
                'departamentos' => $departamentos,
            ]);
        }

        return $docentesComMetricas;
    }

    /**
     * Fetches and caches the department names for a given professor.
     */
    private function getDepartamentosDocente(int $codpes): array
    {
        return Cache::remember("docente_vinculos_nomes_{$codpes}", now()->addHours(24), function () use ($codpes) {
            $vinculos = Pessoa::listarVinculosAtivos($codpes, false);
            if (!is_array($vinculos)) {
                return [];
            }
            $nomes = array_values(array_unique(array_filter(array_column($vinculos, 'nomset'))));
            return array_map('utf8_encode', $nomes);
        });
    }

    /**
     * Gets the department code from its name for optimized database filtering.
     */
    private function getCodDeptoPorNome(?string $nomeDepto): ?int
    {
        if (empty($nomeDepto)) {
            return null;
        }
        $departamentos = \App\Utils\Util::getDepartamentos();
        $depto = collect($departamentos)->firstWhere('1', $nomeDepto);
        return $depto[0] ?? null;
    }



    //exports
    public function exportarDocente($codpes)
    {
        $codpesParcial = substr((string)$codpes, 0, 2);
        $nomeDoc = Pessoa::obterNome($codpes);
        return Excel::download(new DocenteExport($codpes), "docente_{$nomeDoc}.xlsx");
    }
    public function exportarDetalhado($codpes)
    {
        $codpesParcial = substr((string)$codpes, 0, 2);
        $nomeDoc = Pessoa::obterNome($codpes);
        return Excel::download(new DocenteDetalhadoExport($codpes), "docente-detalhado_{$nomeDoc}.xlsx");
    }

    public function apiMetricas(Request $request)
    {
        $limit = $request->input('limit', 10);
        return response()->json($this->metricsService->getDocentesComMetricas($limit));
    }

    public function curriculo(Request $request)
    {
        $limit = $request->input('limit', 3);

        $todosDocentes = Pessoa::listarDocentes();
        $docentes = array_slice($todosDocentes, 0, $limit);

        $curriculo = [];

        foreach ($docentes as $docente) {
            $codpes = $docente['codpes'];
            $lattesArray = Lattes::obterArray($codpes);

            if ($lattesArray) {
                try {
                    $curriculo[$codpes] = Lattes::retornarResumoCV($codpes, $lattesArray);
                } catch (\TypeError $e) {
                    // Log do erro e continua com array vazio
                    \Log::error("Erro ao processar currículo do docente {$codpes}: " . $e->getMessage());
                    $curriculo[$codpes] = [];
                }
            } else {
                $curriculo[$codpes] = [];
            }
        }

        //dd($curriculo)[$codpes];

        return view('lattes.docentes.curriculo_docentes', [
            'docentes' => $docentes,
            'curriculo' => $curriculo,
            'limit' => $limit
        ]);
    }

    public function artigos(Request $request)
    {
        $callback = function ($codpes, $lattesArray) {
            return Lattes::listarArtigos($codpes, $lattesArray, 'registros', -1);
        };

        return $this->processarPaginaLattes(
            $request,
            'lattes.docentes.artigos_docentes',
            'artigos',
            $callback
        );
    }

    public function livrosPublicados(Request $request)
    {
        $callback = function ($codpes, $lattesArray) {
            return Lattes::listarLivrosPublicados($codpes, $lattesArray, 'registros', -1);
        };

        return $this->processarPaginaLattes(
            $request,
            'lattes.docentes.livros_publicados_docentes',
            'livrosPublicados',
            $callback
        );
    }

    public function projetosPesquisa(Request $request)
    {
        $callback = function ($codpes, $lattesArray) {
            try {
                $lista = Lattes::listarProjetosPesquisa($codpes, $lattesArray);
                return is_array($lista) ? $lista : [];
            } catch (\Throwable $e) {
                \Log::warning("Erro ao listar projetos para {$codpes}: " . $e->getMessage());
                return [];
            }
        };

        return $this->processarPaginaLattes(
            $request,
            'lattes.docentes.projetos_pesquisa_docentes',
            'projetosPesquisa',
            $callback
        );
    }

    private function processarPaginaLattes(Request $request, string $view, string $dataKey, callable $fetchDataCallback)
    {
        $limit = $request->input('limit', 5);
        $busca = $request->input('busca');
        $page = $request->input('page', 1);

        // Lista todos os docentes (apenas ativos para consistência com o dashboard)
        $todosDocentes = Pessoa::listarDocentes(null, 'A');

        // Filtra por nome, se houver busca (com correção de encoding)
        if (!empty($busca)) {
            $todosDocentes = array_filter($todosDocentes, function ($docente) use ($busca) {
                return stripos(utf8_encode($docente['nompes']), $busca) !== false;
            });
            $todosDocentes = array_values($todosDocentes); // reindexa
        }

        // Pagina docentes
        $offset = ($page - 1) * $limit;
        $docentesPagina = array_slice($todosDocentes, $offset, $limit);

        // Busca os dados específicos (artigos, livros, etc.) para cada docente da página
        $dados = [];
        foreach ($docentesPagina as &$docente) {
            $docente['nompes'] = utf8_encode($docente['nompes']); // Garante encoding do nome
            $codpes = $docente['codpes'];
            $lattesArray = Lattes::obterArray($codpes);
            $dados[$codpes] = $lattesArray ? $fetchDataCallback($codpes, $lattesArray) : [];
        }

        // Cria paginator manual
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $docentesPagina,
            count($todosDocentes),
            $limit,
            $page,
            ['path' => url()->current(), 'query' => $request->query()]
        );

        return view($view, ['docentes' => $paginator, $dataKey => $dados, 'busca' => $busca, 'limit' => $limit]);
    }


}
