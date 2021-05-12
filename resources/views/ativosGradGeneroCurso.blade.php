@extends('chart')


@section('content_top')

    <div>
        <label for="curso" class="form-label">Curso:</label>
        <select id="curso" class="form-select" onchange="location = this.value;">
            @foreach($cursos as $key => $nomcur)
                <option 
                    @if($key == $cod_curso)
                        selected="selected"
                    @endif    
                    value="/ativosGradCurso/{{$key}}">
                    {{ $nomcur }}
                </option>
            @endforeach
        </select>
    
        
        <a href="/ativosGradCurso/export/excel/{{$cod_curso}}" class="float-right">
            <i class="fas fa-file-excel"></i> Download Excel
        </a>

    </div>

@endsection



@section('content_top')

@endsection

@section('content_footer')
<center>Quantidade de alunos da Graduação em {{$nome_curso}} contabilizados por gênero e curso.</center>
@endsection