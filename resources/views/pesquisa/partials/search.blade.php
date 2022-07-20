
<div class="content-options position-relative">
<form id="formSearchProducaoPrograma" method="get" action="/pesquisa/{{$tipo}}" class="d-flex mb-3">
    <input type="hidden" name="departamento" value="{{ request()->get('departamento') }}">
    <input type="hidden" name="curso" value="{{ request()->get('curso') }}">
    <input type="hidden" name="bolsa" value="{{ request()->get('bolsa') }}">
    <input type="hidden" name="export" value="false">
    <div class="tipo-select-div">
      <label for="tipo">Filtrar por:</label>
      <select name="tipo" id="tipo" class="mr-2">
        <option value="">Selecione</option>
        <option value="anual" {{ request()->get('tipo') == 'anual' ? 'selected' : ''}}>Ano</option>
        <option value="periodo" {{ request()->get('tipo') == 'periodo' ? 'selected' : ''}}>Período</option>
        <option value="ativo" title="Traz todas as produções ativas" {{ request()->get('tipo') == 'ativo' ? 'selected' : ''}}>Ativo</option>
        <option value="tudo" title="Traz todas as produções independente da data" {{ (request()->get('tipo') == 'tudo' || request()->get('tipo') == null ) ? 'selected' : ''}}>Todos</option>
      </select>
    </div>
    <div class="tipo-div-input anual mr-2 
        @if(request()->get('tipo') != 'anual')
         d-none
        @endif">
      <label for="ano">Ano:</label>
      <input type="number" name="ano" id="ano" value="{{ request()->get('ano')}}">
    </div>
    <div class="tipo-div-input periodo mr-2 
        @if(request()->get('tipo') != 'periodo')
         d-none
        @endif" >
      <label for="ano_ini">de </label>
      <input type="number" name="ano_ini" id="ano_ini" value="{{ request()->get('ano_ini')}}">
      <label for="ano_fim">até </label>
      <input type="number" name="ano_fim" id="ano_fim" value="{{ request()->get('ano_fim')}}">
    </div>
    <input type="submit" value="Buscar" class="btn btn-dark bg-blue-default btn-send">
  </form>

</div>

