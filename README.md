# Portal de Dados FFLCH


## Instruções para instalação e contribuição para o projeto:

Instalação da biblioteca ***Cache***: [Instalação e configuração](https://github.com/uspdev/cache).

É necessário o ***composer*** instalado para prosseguir:

- `composer install`
- `cp .env.example .env`
- `php artisan key:generate`
- `php artisan vendor:publish --provider="Uspdev\UspTheme\ServiceProvider" --tag=assets --force`
- `php artisan vendor:publish --tag=scribe-themes`
- `php artisan vendor:publish --tag=scribe-config`
- `php artisan serve`

## Sincronização local com dados do replicado:

    php artisan replicadodailysync
    php artisan replicadolattessync
    php artisan replicadoweeklysync


## Procedimentos para entregar uma consulta nova:

 - Criar um controller, exemplo: AtivosController
 - Colocar três métodos neste Controller: __construct, grafico e export
 - Criar duas rotas: uma para o gráfico e outra para o csv, apontando para o Controller em questão
 - Criar as queries necessárias na pasta Queries
 - No método __construct usar as queries criadas e gerar os dados necessários
 - No método grafico() gerar o gráfico e enviar o objeto criado a partir da bibliteoca Lavacharts para o blade
 - Criar o arquivo blade, exemplo: ativos.blade.php e estender @extends('main')
 - Na seção content colocar o link para download e explicação que julgar importante
 - Ainda no blade: inserir uma div com um id que será passado na hora de renderizar o gráfico
 - Para renderizar: passar o objeto do gráfico, apontar para o component render() e passar como parâmetro o tipo de gráfico, o nome do gráfico e o id da div acima
 - Em index.blade.php inserir a url do novo dado disponível

## Procedimentos para consultar uma API:

- A documentaçao da api é feita através da biblioteca scribe, acesse o endereço https://dados.fflch.usp.br/docs para consultar a documentação da api e ver todos os endpoints disponíveis

- Para documentar um novo endpoint ou alterá-lo tem que adicionar um docblock no método do controller da api, veja mais em https://scribe.knuckles.wtf/laravel/documenting/metadata. Ao finalizar rode o comando para que as alterações sejam publicadas.
```
    php artisan scribe:generate
``` 
