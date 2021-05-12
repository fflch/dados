# Portal de Dados FFLCH


## Instruções para instalação e contribuição para o projeto:

Instalação da biblioteca ***Cache***: [Instalação e configuração](https://github.com/uspdev/cache).

É necessário o ***composer*** instalado para prosseguir:

- `composer install`
- `cp .env.example .env`
- `php artisan key:generate`
- `php artisan vendor:publish --provider="Uspdev\UspTheme\ServiceProvider" --tag=assets --force`
- `php artisan serve`


## Procedimentos para entregar uma consulta nova:

 - Criar um controller, exemplo: AtivosController
 - Colocar três métodos neste controller: __construct, grafico e csv
 - Criar duas rotas: uma para o gráfico e outra para o csv, apontando para o controller em questão
 - Criar as queries necessárias na pasta Queries
 - No método __construct usar as queries criada e gerar os dados necessários
 - No método grafico() gerar o gráfico e enviar o objeto $chart para blade
 - Criar o arquivo blade, exemplo: ativos.blade.php e estender @extends('chart')
 - Na região content_top colocar link para download e explicação que jugar importante
 - Região content_footer serve para conteúdos extras
 - Em index.blade.php listar o novo dado disponível

## Procedimentos para consultar uma API:

- Acessar o arquivo api.php dentro da pasta routes para consultar o endereço de cada API
- Adicionar na URL do portal de Dados (https://dados.fflch.usp.br), o prefixo /api/{ENDEREÇO DA API A SER CONSULTADA}
```
- Para consultar a API com as informações de um programa, é necessário passar o último pârametro {codare}, com o código da área de pós graduação:
```sh
https://dados.fflch.usp.br/api/programas/discentes/codare
```
- Para consultar a API com as informações de um egresso, docente ou discente, é necessário passar o último pârametro {codpes}, com o número USP da pessoa:
```sh
https://dados.fflch.usp.br/api/programas/docente/{codpes}
```