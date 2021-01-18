@extends('laravel-usp-theme::master')

@section('content')

<div class="card">
  <div class="card-header"><b>Professores credenciados ao programa: {{count($credenciados)}}</b></div>
  <div class="card-body">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Professor</th>
          <th scope="col" class="text-center">Produção</th>
          <th scope="col" class="text-center">Lattes</th>
          <th scope="col" class="text-center">Última Atualização Lattes</th>
        </tr>
      </thead>
      <tbody>
        @foreach($credenciados as $credenciado)
        <tr>
          <td>
            <a href="/programas/docente/{{$credenciado['codpes']}}">
              {{$credenciado['nompes']}}
            </a>
          </td>
          <td class="text-center"><i class="fas fa-university"></i></td>
          <td class="text-center">
            <a target="_blank" href="http://lattes.cnpq.br/{{$credenciado['id_lattes']}}">
              <img src="http://buscatextual.cnpq.br/buscatextual/images/titulo-sistema.png">
            </a>
          </td>
          <td class="text-center">{{$credenciado['data_atualizacao']}}</td>
        </tr>
        
        @endforeach
       
      </tbody>
    </table>  
    

  </div>
</div>



@endsection('content')

