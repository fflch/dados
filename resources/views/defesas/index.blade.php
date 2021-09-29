@extends('main')

@section('content')

<div class="card">
  <div class="card-header"><b> Defesas de 
  @if(request()->ano) 
    {{ request()->ano }} 
  @else
    {{ Date('Y') }}
  @endif  
  </b></div>
  <div class="card-body">

  <ul>
  <li>Mestrado: {{ $defesas->where('nivel','ME')->count()}} </li>
  <li>Doutorado: {{ $defesas->where('nivel','DO')->count()}}</li>
  <li>Doutorado Direto: {{ $defesas->where('nivel','DD')->count()}}</li>
  </ul>

  <form>

    <div class="form-group">
      <label for="ano"><b>Selecionar ano da defesa</b></label>
      <select class="form-control" name="ano">
        @foreach(App\Models\Defesa::anos() as $ano)
          <option value="{{$ano}}" @if(request()->ano == $ano) selected @endif>{{$ano}}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="ano"><b>Selecionar Programa</b></label>
      <select class="form-control" name="codcur">
        <option value="" selected>Selecionar</option>
        @foreach(App\Models\Defesa::programas() as $codcur=>$nomcur)
          <option value="{{$codcur}}" @if(request()->codcur == $codcur) selected @endif>{{$nomcur}}</option>
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
          <th scope="col">Aluno(a)</th>
          <th scope="col">Data da Defesa</th>
          <th scope="col">Nível</th>
          <th scope="col">Programa</th>
          <th scope="col">Título</th>
        </tr>
      </thead>
      <tbody>
        @foreach($defesas->sortBy('nomcur') as $defesa)
          <tr>
            <td style="color: #213d72"><b>{{ $defesa->nome }} </td>
            <td>{{ $defesa->data }} </td>
            <td>{{ $defesa->nivel }} </td>
            <td>{{ $defesa->nomcur }} </td>
            <td>{!! $defesa->titulo !!} </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    
  </div>
</div>


@endsection

