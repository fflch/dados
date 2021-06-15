@extends('main')

@section('content')

<div>
    <label for="curso" class="form-label">Filtrar por:</label>
    <select id="curso" class="form-select" onchange="location = this.value;">
        <option @if($codfnc == 0) selected="selected" @endif value="/ativosDepartamento/Servidor/0">
            Funcionários
        </option>
        <option @if($codfnc == 1) selected="selected" @endif value="/ativosDepartamento/Docente/1">
            Professores Associados
        </option>
        <option @if($codfnc == 2) selected="selected" @endif value="/ativosDepartamento/Docente/2">
            Professores Doutores
        </option>
        <option @if($codfnc == 3) selected="selected" @endif value="/ativosDepartamento/Docente/3">
            Professores Titulares
        </option>
     
    </select> 
    

    <a href="/ativosDepartamento/export/excel" class="float-right">
        <i class="fas fa-file-excel"></i> Download Excel
    </a>

</div>


<div id="chart-div"></div>


{!! $lava->render('PieChart', 'Ativos', 'chart-div') !!}

<center>
    <b>FLA:</b> Antropologia, <b>FLP:</b> Ciência Política, <b>FLF:</b> Filosofia, <b>FLH:</b> História, <b>FLC:</b> Letras Clássicas e Vernáculas, 
    <b>FLM:</b> Letras Modernas,<br> <b>FLO:</b> Letras Orientais, <b>FLL:</b> Linguística, <b>FSL:</b> Sociologia, <b>FLT:</b> Teoria Literária e Literatura Comparada,
    <b>FLG:</b> Geografia.
    </center>


@endsection

