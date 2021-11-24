@extends('main')

@section('content')

  <table class="table">
      <thead>
        <tr>
          <th scope="col">Titular</th>
          <th scope="col">Suplente</th>
          <th scope="col">Início</th>
          <th scope="col">Fim</th>
        </tr>
      </thead>
      <tbody>
        @foreach($membros as $membro)
          <tr>
            <td><b>{{ $membro['tipfncclg'] }} </td>
            <td style="color: #213d72"><b>{{ \Uspdev\Replicado\Pessoa::nomeCompleto($membro['titular']) }} </td>
            <td><b>{{ \Uspdev\Replicado\Pessoa::nomeCompleto($membro['suplente']) }} </td>
            <td>{{ date('d/m/Y', strtotime($membro['dtainimdt'] ))  }} </td>
            <td>{{ date('d/m/Y', strtotime($membro['dtafimmdt'] ))  }} </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>


@endsection

