@extends('chart')

@section('content_top')
{{-- CSV ainda não funcionando
<a href="/ativosBeneficiosConHistCsv"><i class="fas fa-file-csv"></i></a> Download
 --}}
@endsection

@section('content_footer')
<center>
    <p>Série histórica de benefícios concedidos por ano na Faculdade de Filosofia, Letras e Ciências Humanas a partir de 2014.</p>
    <p>obs.: A consulta considera o número de benefícios concedidos, e não o número de alunos beneficiados.</p>
</center>
@endsection
