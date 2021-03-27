@foreach ($serie_historica as $key=>$value)
    <div class="card">
        <div class="card-header">
        <b>
            <a  data-toggle="collapse" href="#<?= str_replace(' ', '_',$key) ?>" role="button" aria-expanded="false" aria-controls="<?= str_replace(' ', '_',$key) ?>">
                {{$key}}
            </a>
            
        </b>
        </div>
        <div class="card-body collapse" id="<?= str_replace(' ', '_',$key) ?>">
        <table class="table docentes-programa-table">
            <thead>
            <tr>
                
                <th scope="col">Anos</th>
                
                <th scope="col" class="text-center">IC (com bolsa)</th>
                <th scope="col" class="text-center">IC (sem bolsa)</th>
                
                
                <th scope="col" class="text-center">Pós-Doutorandos ativos (com bolsa)</th>
                <th scope="col" class="text-center">Pós-Doutorandos ativos (sem bolsa)</th>
    
                <th scope="col" class="text-center">Pesquisadores Colaboradores Ativos</th>
                <th scope="col" class="text-center">Projetos de Pesquisas dos Docentes</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($value as $key=>$item)
                    <tr>
                    <td>
                        {{ $key }}
                    </td>
                    <td class="text-center">
                        @if($item['ic_com_bolsa'] > 0)
                            {{$item['ic_com_bolsa']}}
                            
                        @else
                            0
                        @endif
                    </td>
                    <td class="text-center">
                        @if($item['ic_sem_bolsa'] > 0)
                            {{$item['ic_sem_bolsa']}}
                        
                        @else
                        0
                        @endif
                    </td>
                    <td class="text-center">
                        @if($item['pesquisas_pos_doutorado_com_bolsa'] > 0)
                            {{$item['pesquisas_pos_doutorado_com_bolsa']}}
                        
                        @else
                        0
                        @endif
                    </td>
                    <td class="text-center">
                        @if($item['pesquisas_pos_doutorado_sem_bolsa'] > 0)
                            {{$item['pesquisas_pos_doutorado_sem_bolsa']}}
                        
                        @else
                        0
                    @endif
                    </td>
                    <td class="text-center">
                        
                        @if($item['pesquisadores_colab'] > 0)
                            {{$item['pesquisadores_colab']}}
                        
                        @else
                        0
                        @endif
                    </td>
                    <td class="text-center">
                        
                        @if($item['projetos_pesquisa'] > 0)
                            {{$item['projetos_pesquisa']}}
                        
                        @else
                        0
                        @endif
                    </td>
                    
                    </tr>
                @endforeach
            
            </tbody>
        </table>  
        
    
        </div>
    </div>
@endforeach