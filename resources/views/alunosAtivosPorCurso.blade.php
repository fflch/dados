@extends('chart')

@section('content_top')

<div>
    <label for="curso" class="form-label">Filtrar por:</label>
    <select id="curso" class="form-select" onchange="location = this.value;">
        
            <option 
                @if($tipvin == 'ALUNOGR')
                    selected="selected"
                @endif    
                value="/alunosAtivosPorCurso/ALUNOGR">
                Alunos da Graduação
            </option>
            <option 
                @if($tipvin == 'ALUNOPD')
                    selected="selected"
                @endif    
                value="/alunosAtivosPorCurso/ALUNOPD">
                Alunos Pós-doutorando
            </option>
       
    </select>

    <a href="/alunosAtivosPorCurso/export/excel/{{$tipvin}}" class="float-right">
        <i class="fas fa-file-excel"></i> Download Excel</a> 

    

</div>



@endsection

@section('content_footer')
<center>{{$texto}}</center>
@endsection
