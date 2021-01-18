@extends('chart')

@section('content_top')

    <div>
        <label for="curso" class="form-label">Curso:</label>
        <select id="curso" class="form-select" onchange="location = this.value;">
            @foreach($cursos as $key => $cur)
                <option 
                    @if($key == $curso)
                        selected="selected"
                    @endif    
                value="/trancamentosCursoPorSemestre/{{$key}}">
                    {{ $cur['nome'] }}
                </option>
            @endforeach
        </select>
    
        <a href="/trancamentosCursoPorSemestre/export/excel/{{$curso}}" class="float-right" >
            <i class="fas fa-file-excel"></i> Download Excel
        </a>
    </div>

@endsection

@section('content_footer')
<center>
<p>Total de trancamentos de matrícula por semestre do curso de {{$cursos[$curso]['nome']}}. </p>
</center>
@endsection

