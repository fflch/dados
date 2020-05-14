@extends('chart')

@section('content_top')
<a href="/ativosBeneficiosConHist/export/excel">
    <i class="fas fa-file-excel"></i> Download Excel</a>
@endsection

@section('content_footer')
<center>
    <p>Série histórica de benefícios concedidos por ano na Faculdade de Filosofia, Letras e Ciências Humanas a partir de 2014.</p>
    <p>obs.: A consulta considera o número de benefícios concedidos, e não o número de alunos beneficiados.</p>
</center>
@endsection
