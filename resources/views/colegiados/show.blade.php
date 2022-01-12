@extends('main')

@section('content')
  
  <p>
    <h6 class="text-center"><b>{{$nome_colegiado}}</b></h6>
  </p>

  <table class="table table-responsive">
      <thead>
        <!--<tr> <th class="text-center border-0" colspan="7">{{$nome_colegiado}}</th> </tr>-->          <th scope="col">Titular</th>
          <th scope="col">Vínculo</th>
          <th scope="col">Email</th>
          <th scope="col">Suplente</th>
          <th scope="col">Vínculo</th>
          <th scope="col">Email</th>
          <th scope="col">Vigência</th>
        </tr>
      </thead>
      <tbody>
        @foreach($membros as $membro)
          <tr>
            <td style="color: #213d72"><b codpes="{{$membro['titular']}}"> {{ $membro['nome_titular'] }} 
            @if($membro['tipfncclg'] != 'Titular') ({{ $membro['tipfncclg'] }}) @endif </b></td>
            <td>{{$membro['vinculo_titular']}}</td>
            <td>{{ $membro['email_titular'] }} </td>
            @if($membro['suplente'] != 0) 
              <td><b>{{ $membro['nome_suplente'] }}</b> </td>
              <td>{{$membro['vinculo_suplente']}}</td>
              <td>{{ $membro['email_suplente'] }} </td>
            @else
              <td>-</td>
              <td>-</td>
              <td>-</td>
            @endif 
            <td class="text-center">{{ date('d/m/Y', strtotime($membro['dtainimdt'] ))  }} <br> até <br> {{ date('d/m/Y', strtotime($membro['dtafimmdt']))}} </td>
            
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>


@endsection

