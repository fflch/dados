@extends('main')


@section('content')
<a href="/orientadoresPosGR/export/excel">
    <i class="fas fa-file-excel"></i> Download Excel</a>
    
<center>
Quantidade de orientadores credenciados na área de concentração do programa de pós graduação correspondente da Faculdade de Filosofia, Letras e Ciências Humanas.
</center>

<div id="chart-div"></div>
{!! $lava->render('ColumnChart', 'Orientadores', 'chart-div') !!}


<center>
<b>AS:</b> Antropologia Social, <b>CP:</b> Ciência Política, <b>ECLLP:</b> Estudos Comparados de Literaturas de Língua Portuguesa,<br>
<b>EJ:</b> Estudos Judaicos, <b>ELLI:</b> Estudos Lingüísticos e Literários em Inglês, <b>ET:</b> Estudos da Tradução,<br>
<b>FLP:</b> Filologia e Língua Portuguesa, <b>DF:</b> Filosofia, <b>GF:</b> Geografia Física, <b>GH:</b> Geografia Humana,<br> 
<b>HE:</b> História Econômica, <b>HS:</b> História Social, <b>HDOL:</b> Humanidades, Direitos e Outras Legitimidades,<br> 
<b>LC:</b> Letras Clássicas, <b>DL:</b> Lingüística: Semiótica e Lingüística Geral, <b>LB:</b> Literatura Brasileira,<br> 
<b>LP:</b> Literatura Portuguesa, <b>LELEH:</b> Língua Espanhola e Literaturas Espanhola e HispanoAmericana,<br>
<b>LLA:</b> Língua e Literatura Alemão, <b>LLF:</b> Língua e Literatura Francesa, <b>LLCI:</b> Língua, Literatura e Cultura Italianas,<br> 
<b>DS:</b> Sociologia, <b>TLLC:</b> Teoria Literária e Literatura Comparada.
</center> 

@endsection 