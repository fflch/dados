@extends('main')

@section('content')
<div class="container-sm">
<h1>Contagem de pessoas por vínculo ativo</h1>
    @include('partials.simple-table',[
                    'table_data' => $data,
                    'table_labels' => ['Vínculo','Quantidade'],
                    'table_keys' => ['tipvinext','qtd']
                ])
    <a href="{{ route('contagem-vinculos-planilha') }}">
        <button class="btn btn-primary">Download</button>
    </a>
</div>
@endsection