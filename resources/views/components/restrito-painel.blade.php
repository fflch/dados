<li class="list-group-item">
    <div class="panel panel-default panel-docente">
        <div class="panel-heading">
            <h5 role="button" data-toggle="collapse" href="#collapse{{ $nome }}"  aria-controls="collapse{{ $nome }}" 
                aria-expanded="false" class="collapsed">
                {{ $titulo }}
                <span class="controller-collapse">
                    <i class="fas fa-plus-square"></i>
                    <i class="fas fa-minus-square"></i>  
                </span>
            </h5>
        </div>
        <div class="panel-body collapse in @isset($ativo)show @endisset" id="collapse{{ $nome }}">
            <ul class="list-group">
                <li class="list-group-item">
                    {{ $form }}
                </li>
            </ul>
        </div>
    </div>
</li>