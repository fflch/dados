@extends('chart')

@section('content_top')
<a href="/ativosFuncionariosDepartamento/export/excel">
<i class="fas fa-file-excel"></i> Download Excel</a> <br>
<center>
<b>FLA:</b> Antropologia, <b>FLP:</b> Ciência Política, <b>FLF:</b> Filosofia, <b>FLH:</b> História, <b>FLC:</b> Letras Clássicas e Vernáculas, 
<b>FLM:</b> Letras Modernas,<br> <b>FLO:</b> Letras Orientais, <b>FLL:</b> Linguística, <b>FSL:</b> Sociologia, <b>FLT:</b> Teoria Literária e Literatura Comparada,
<b>FLG:</b> Geografia.
</center>
@endsection

@section('content_footer')
<center>Quantidade de funcionários ativos na ativos na Faculdade de Filosofia, Letras e Ciências Humanas contabilizados por departamento.</center>
@endsection
