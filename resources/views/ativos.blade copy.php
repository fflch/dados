@extends('chart')

@section('content_top')


<div>
    <form action="/ativos" method="get" id="filtroAtivos">
    
    
        <label for="curso" class="form-label">Filtrar por:</label>
        <select id="curso" class="form-select" onchange="location = this.value;">     
                <option 
                    @if(request()->get('tipo') == 'curgr')
                        selected="selected"
                    @endif    
                    value="/ativos?tipo=curgr">
                    Curso de Graduação
                </option>
                <option 
                    @if(request()->get('tipo') == 'area')
                        selected="selected"
                    @endif    
                    value="/ativos?tipo=area">
                    Área/Departamento
                </option>
                <option 
                    @if(request()->get('tipo') == 'setor')
                        selected="selected"
                    @endif    
                    value="/ativos?tipo=setor">
                    Setor
                </option>
        
        </select>

    </form>

    
    <a href="/ativos/export/excel" class="float-right">
        <i class="fas fa-file-excel"></i> Download Excel</a>

    

</div>

@endsection

@section('content_footer')
<center>Quantidade de pessoas com vínculos ativos na unidade.</center>

Teste Teste Teste Teste Teste Teste Teste

<div id="chart-div"></div>
<br>
<div id="chart-col-div"></div>

{!! $lava->render('BarChart', 'Ativos', 'chart-div') !!}


@endsection
