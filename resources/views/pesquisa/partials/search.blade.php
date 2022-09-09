
<div class="content-options position-relative mt-3 ">
<form id="formSearchProducaoPrograma" method="get" action="/pesquisa/{{$tipo}}" class="d-flex mb-3">
    <input type="hidden" name="departamento" value="{{ request()->get('departamento') }}">
    <input type="hidden" name="curso" value="{{ request()->get('curso') }}">
    <input type="hidden" name="bolsa" value="{{ request()->get('bolsa') }}">
    <input type="hidden" name="export" value="false">
    <div class="tipo-select-div">
      <label for="tipo">Filtrar por:</label>
      <select name="tipo" id="tipo" class="mr-2">
        <option value="ativos" title="Busca os projetos ativos " {{ request()->get('tipo') == 'ativos' ? 'selected' : ''}}>Ativos</option>
        <option value="anovigente" title="Busca os projetos vigentes em determinado ano" {{ request()->get('tipo') == 'anovigente' ? 'selected' : ''}}>Ano de vigência</option>
        <option value="anoinicial" title="Busca os projetos iniciados em determinado ano" {{ request()->get('tipo') == 'anoinicial' ? 'selected' : ''}}>Ano inicial</option>
        <option value="anofinal"  title="Busca os projetos encerrados em determinado ano" {{ request()->get('tipo') == 'anofinal' ? 'selected' : ''}}>Ano final</option>
        <option value="todos" title="Buscar todos os projetos (independente de data)" {{ (request()->get('tipo') == 'todos' || request()->get('tipo') == null ) ? 'selected' : ''}}>Todos</option>
      </select>
    </div>
    <div class="tipo-div-input anovigente anoinicial anofinal mr-2 
        @if(request()->get('tipo') == 'todos' || request()->get('tipo') == 'ativos')
         d-none
        @endif">
      <label for="ano">Ano:</label>
      <input type="number" name="ano" id="ano" min="1950" value="{{ request()->get('ano')}}">
    </div>
    <input type="submit" value="Buscar" class="btn btn-dark bg-blue-default btn-send">
    
  </form>

  <?php $mensagens = [
    'ativos' => 'Buscando os projetos em atividade',
    'todos' => 'Buscando todos os projetos',
    'anovigente' => 'Buscando os projetos vigentes em ',
    'anoinicial' => 'Buscando os projetos tiveram início em ',
    'anofinal' => 'Buscando os projetos que terminaram em '
  ];
  ?>

@if(str_starts_with(request()->get('tipo'), 'ano'))
  <p>{{ $mensagens[request()->get('tipo')] . request()->get('ano') . ':'}}</p>
@else
  <p>{{ $mensagens[request()->get('tipo')] . ':'}}</p>
@endif

</div>

