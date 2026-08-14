@extends('main')

@section('content')
<div class="container-sm">
<h1>Contagem de Alunos da Graduação</h1>
    @include('partials.simple-table',[
                    'table_data' => $cursos,
                    'table_labels' => ['Curso','Alunos'],
                    'table_keys' => ['nomcur','qtd']
                ])
    <a href="{{ route('contagem-alunosGrad-planilha') }}">
        <button class="btn btn-primary">Download</button>
    </a>
</div>
@endsection