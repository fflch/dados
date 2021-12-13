@extends('main')

@section('content')

  <table class="table">
      <thead>
        <tr>
          <th scope="col">Titular</th>
          <th scope="col">Email</th>
          <th scope="col">Suplente</th>
          <th scope="col">Email</th>
          <th scope="col">Início</th>
          <th scope="col">Fim</th>
        </tr>
      </thead>
      <tbody>
        @foreach($membros as $membro)
          <tr>
            <td style="color: #213d72"><b codpes="{{$membro['titular']}}">[{{$membro['vinculo_titular']}}] {{ $membro['nome_titular'] }} 
            @if($membro['tipfncclg'] != 'Titular') ({{ $membro['tipfncclg'] }}) @endif </td>
            <td><b>{{ $membro['email_titular'] }} </td>
            @if($membro['suplente'] != 0) 
              <td><b>[{{$membro['vinculo_suplente']}}] {{ $membro['nome_suplente'] }} </td>
              <td><b>{{ $membro['email_suplente'] }} </td>
            @else
              <td><b>-</td>
              <td><b>-</td>
            @endif 
            <td>{{ date('d/m/Y', strtotime($membro['dtainimdt'] ))  }} </td>
            <td>{{ date('d/m/Y', strtotime($membro['dtafimmdt'] ))  }} </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>


@endsection

