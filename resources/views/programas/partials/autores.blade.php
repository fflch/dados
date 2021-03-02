@foreach($value['AUTORES'] as $k=>$val)
                        
    @if(strpos($val["NOME-PARA-CITACAO"], ';') !== false)
        {!! explode(';', $val["NOME-PARA-CITACAO"])[0] !!}
    @else 
        {!! $val["NOME-PARA-CITACAO"] !!}  
    @endif

    @if( $k + 1 <  count($value['AUTORES']))
        ;
    @elseif (isset($val["NOME-PARA-CITACAO"]) && $val["NOME-PARA-CITACAO"] != null && $val["NOME-PARA-CITACAO"] != "")
        .

    @endif
@endforeach