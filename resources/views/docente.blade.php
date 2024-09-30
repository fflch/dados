<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Docentes</title>
</head>
<body>
    <h1>Lista de Docentes</h1>

    @if(!empty($docentes))
        <table border="1">
            <thead>
                <tr>
                    <th>Código USP</th>
                    <th>Nome</th>
                    <th>Departamento</th>
                    <th>Função</th>
                </tr>
            </thead>
            <tbody>
                @foreach($docentes as $docente)
                    <tr>
                        <td>{{ $docente['codpes'] }}</td>
                        <td>{{ $docente['nompes'] }}</td>
                        <td>{{ $docente['nomset'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Nenhum docente encontrado.</p>
    @endif
</body>
</html>
