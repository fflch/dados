@extends('main')

@section('content')

  <table class="table">
      <thead>
        <tr>
          <th scope="col">Colegiados</th>
        </tr>
      </thead>
      <tbody>
        @foreach($colegiados as $colegiado)
          <tr>
            <td>
              <a href="/colegiados/{{ $colegiado['codclg'] }}/{{ $colegiado['sglclg'] }}">
                <?php $descricao = \App\Utils\Util::obterDescricaoColegiadoPorSigla($colegiado['sglclg']); ?>
                {{ $colegiado['tipclg'] }} - 
                @if($colegiado['codclg'] == 8 && !empty($descricao))
                  {{$descricao}} 
                @else
                  {{ $colegiado['nomclg'] }}
                @endif
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection

