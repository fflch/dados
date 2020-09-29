@extends('chart')

@section('content_top')

<a href="/ativosAlunosAutodeclarados/export/excel">
    <i class="fas fa-file-excel"></i> Download Excel</a>
<center>Totais de Alunos de Gradução, Pós Graduação, Pós Doutorado e de Cultura e Extensão da FFLCH autodeclarados.</center>

@endsection

@section('content_footer')

<center><b>Obs:</b> Foram omitidos os dados de alunos que não dispõem da informação em seu cadastro.</center>

@endsection