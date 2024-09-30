<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Docentes Ativos</title>
</head>
<body>
    <h1>Lista de Docentes Ativos</h1>

    @if(!empty($doc_ativos))
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
                @foreach($doc_ativos as $doc_ativo)
                    <tr>
                        <td>{{ $doc_ativo['codpes'] }}</td>
                        <td>{{ $doc_ativo['nompes'] }}</td>
                        <td>{{ $doc_ativo['nomset'] }}</td>
                        <td>{{ $doc_ativo['nomfnc']}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Nenhum docente encontrado.</p>
    @endif
</body>
</html>
