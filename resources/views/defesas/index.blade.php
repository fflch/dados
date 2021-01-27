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
  <li>Mestrado: {{ $defesas->where('nivpgm','ME')->count()}} </li>
  <li>Doutorado: {{ $defesas->where('nivpgm','DO')->count()}}</li>
  <li>Doutorado Direto: {{ $defesas->where('nivpgm','DD')->count()}}</li>
  </ul>

  <form>

    <div class="form-group">
      <label for="ano"><b>Selecionar ano da defesa</b></label>
      <select class="form-control" name="ano">
        @foreach($anos as $ano)
          <option value="{{$ano}}" @if(request()->ano == $ano) selected @endif>{{$ano}}</option>
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
            <td><a href="#">{{$defesa['nompes']}} </a></td>
            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $defesa['dtadfapgm'])->format('d/m/Y') }} </td>
            <td>{{ $defesa['nivpgm'] }} </td>
            <td>{{ $defesa['nomcur'] }} </td>
            <td>{!! $defesa['tittrb'] !!} </td>
          </tr>
        @endforeach
      </tbody>
    </table>

  </div>
</div>

@endsection('content')

