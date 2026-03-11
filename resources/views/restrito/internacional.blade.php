@extends('main')

@section('content')

<ul class="list-group">
    @component('components.restrito-painel')
        @slot('titulo')Planilha Intercambistas @endslot 
        @slot('nome')Intercambistas @endslot 
        @slot('form')
            <a href="{{ route("intercambistas") }}" class="btn btn-primary">Baixar</a>
            <br><br>
            <span>Lista com todos os intercambistas recebidos na fflch, tanto graduação quanto pós-graduação. Fonte: Mundus</span>
            <br><span>*O arquivo pode demorar a ser baixado.</span>
        @endslot 
    @endcomponent
</ul>

@endsection