@extends('main')

@section('content')

<div class="card">
  <div class="card-header"><b>Pessoas</b></div>
  <div class="card-body">

  <form>

    <div class="form-group">
      <label for="ano"><b>Selecionar Vínculo</b></label>
      <select class="form-control" name="vinculo">
        @foreach(App\Models\Pessoa::vinculos() as $key=>$value)
          <option value="{{$key}}" @if(request()->vinculo == $key) selected @endif>{{$value}}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-success"> Filtrar </button>
    </div>
  </form>

  <table class="table">
      <thead>
        <tr>
          <th scope="col">Nome</th>
          <th scope="col">Setor</th>
          <th scope="col">x</th>
          <th scope="col">x</th>
          <th scope="col">x</th>
        </tr>
      </thead>
      <tbody>
        @foreach($pessoas->sortBy('nompes') as $pessoa)
          <tr>
            <td> {{$pessoa['nompes']}} </td>
            <td></td>
            <td> </td>
            <td> </td>
            <td> </td>
          </tr>
        @endforeach
      </tbody>
    </table>

  </div>
</div>

@endsection('content')

