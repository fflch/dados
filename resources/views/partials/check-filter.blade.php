<div>
    @foreach ($filters as $cod => $nom)
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="check_{{ $cod }}" onchange="mostraFiltro(this,'{{ $cod }}')">
        <label class="form-check-label" for="check_{{ $cod }}">
            {{ $nom }}
        </label>
    </div>
    @endforeach
</div>