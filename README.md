# Portal de Dados FFLCH


## Instruções para instalação e contribuição para o projeto:

Instalação da biblioteca ***Cache***: [Instalação e configuração](https://github.com/uspdev/cache).

É necessário o ***composer*** instalado para prosseguir:

- `composer install`
- `cp .env.example .env`
- `php artisan key:generate`
- `php artisan vendor:publish --provider="Uspdev\UspTheme\ServiceProvider" --tag=assets --force`
- `php artisan vendor:publish --tag=scribe-themes`
- `php artisan serve`


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

- Acessar o arquivo api.php dentro da pasta routes para consultar o endereço de cada API
- Adicionar na URL do portal de Dados (https://dados.fflch.usp.br), o prefixo /api/{ENDEREÇO DA API A SER CONSULTADA}
```
- Para consultar a API com as informações de um programa, é necessário passar o último pârametro {codare}, com o código da área de pós graduação:
```
https://dados.fflch.usp.br/api/programas/discentes/codare
```
- Para consultar a API com as informações de um egresso, docente ou discente, é necessário passar o último pârametro {codpes}, com o número USP da pessoa:
```
https://dados.fflch.usp.br/api/programas/docente/{codpes}
```
