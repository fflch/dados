@extends('chart')

@section('content_top')
<a href="/beneficiosAtivosGraduacao2020/export/excel">
    <i class="fas fa-file-excel"></i> Download Excel</a>
@endsection

@section('content_footer')

<br>

<center>
    <p>Total de alunos de Graduação com benefícios (ativos) em 2020 na Faculdade de Filosofia, Letras e Ciências Humanas.</p>
</center>

<b>Legenda: </b>

<ul style="list-style-type: none;">
    <li>2 - Auxílio Alimentação</li>
    <li>5 - Auxílio Moradia</li>
    <li>52 - Bolsa PEEG - Programa de Estímulo de Graduação</li>
    <li>102 - SEI - Auxílio Financeiro</li>
</ul>

<p>* Essa lista poderá ser estendida, caso sejam cadastrados alunos em outros benefícios.</p>

@endsection
