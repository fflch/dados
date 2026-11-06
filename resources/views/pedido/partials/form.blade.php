<div class="form-goup">
    <label for="assunto">Assunto</label>
    <input class="form-control" type="text" name="assunto" value="{{old('assunto', $pedido->assunto)}}">
</div>
<br>
<div class="form-group">
    <label for="descricao">Descrição</label>
    <textarea class="form-control" rows="12" name="descricao">{{ old('descricao', $pedido->descricao) }}</textarea>
</div>
<div class="text-center">
    <input class="btn btn-primary" type="submit" value="Enviar">
</div>