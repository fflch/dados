<div class="position-relative">
<form id="formSearchProducaoPrograma" method="show" action="{{$form_action}}" class="d-flex mb-3">
    <div class="tipo-select-div">
      <label for="tipo">Filtrar por:</label>
      <select name="tipo" id="tipo" class="mr-2">
        <option value="">Selecione</option>
        <option value="anual" {{ $filtro['tipo'] == 'anual' ? 'selected=selected' : ''}}>Ano</option>
        <option value="periodo" {{ $filtro['tipo'] == 'periodo' ? 'selected=selected' : ''}}>Período</option>
        <option value="tudo" title="Traz todas as produções independente da data" {{ $filtro['tipo'] == 'tudo' ? 'selected=selected' : ''}}>Tudo</option>
      </select>
    </div>
    <div class="tipo-div-input anual mr-2 
        @if($filtro['tipo'] != 'anual')
         d-none
        @endif">
      <label for="ano">Ano:</label>
      <input type="number" name="ano" id="ano" value="{{ $filtro['limit_ini']}}">
    </div>
    <div class="tipo-div-input periodo mr-2 
        @if($filtro['tipo'] != 'periodo')
         d-none
        @endif" >
      <label for="ano_ini">Ano inicial:</label>
      <input type="number" name="ano_ini" id="ano_ini" value="{{ $filtro['limit_ini']}}">
      <label for="ano_fim">Ano final:</label>
      <input type="number" name="ano_fim" id="ano_fim" value="{{ $filtro['limit_fim']}}">
    </div>
    <input type="submit" value="Buscar" class="btn btn-dark btn-send">
  </form>
  
  <a href="{{ config('app.url') }}/api{{$form_action}}" class="export-json"><span data-toggle="tooltip" data-placement="left" title="Exportar em JSON" role="button"><img src="{{ asset('assets/img/json_icon.png') }}"></span></a>
  </div>