<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Portal de Dados')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <!-- Adicione aqui seus links de CSS ou outros recursos -->
</head>
<body>
@include('layouts.navbars.sidebar')

    <div class="content">
        <header>
        </header>

        <main>
            @yield('content')
        </main>
    </div>

</body>
</html>

<style>
        body {
            display: flex;
        }
        

        .content {
            margin-left: 300px; /* Move o conteúdo para a direita, considerando a largura da sidebar */
            padding: 15px;
            flex-grow: 1;
            position: relative; /* Para que o conteúdo não sobreponha a sidebar */
        }

        header, footer {
            padding: 15px;
        }
    </style>