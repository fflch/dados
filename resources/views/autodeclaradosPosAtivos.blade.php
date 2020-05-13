@extends('chart')

@section('content_top')
<a href="/autodeclaradosPosAtivos/export/excel">
    <i class="fas fa-file-excel"></i> Download Excel</a>
@endsection

@section('content_footer')
<center>Quantidade de alunos(as) da Pós-Graduação contabilizados por raça/cor.</center>
<b>Legenda: </b>
<ul style="list-style-type: none;">
    <li>* Amarela (de origem japonesa, chinesa, coreana, etc.).</li>
    <li>** Parda ou declarada como mulata, cabocla, cafuza, mameluca ou mestiça de negro com outra cor ou raça.</li>
    <li>*** Não declarou ou ausência de informações.</li>
</ul>
@endsection


