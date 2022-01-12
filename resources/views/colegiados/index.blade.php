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
                {{ $colegiado['tipclg'] }} - {{ $colegiado['nomclg'] }}  ({{ $colegiado['sglclg']}})
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection

