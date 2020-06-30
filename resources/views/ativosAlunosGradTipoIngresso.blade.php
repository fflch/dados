@extends('chart')

@section('content_top')

<a href="/ativosAlunosGradTipoIngresso/export/excel">
    <i class="fas fa-file-excel"></i> Download Excel</a>
<center>Totais de Alunos de Gradução por tipo de ingresso.</center>

@endsection

@section('content_footer')

<center>* Foram omitidos os dados de alunos que não dispõem da informação em seu cadastro.</center>

@endsection