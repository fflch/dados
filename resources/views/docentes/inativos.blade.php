<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Docentes Inativos</title>
</head>
<body>
    <h1>Lista de Docentes Inativos</h1>

    @if(!empty($doc_inativos))
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
                @foreach($doc_inativos as $docdoc_inativo)
                    <tr>
                        <td>{{ $docdoc_inativo['codpes'] }}</td>
                        <td>{{ $docdoc_inativo['nompes'] }}</td>
                        <td>{{ $docdoc_inativo['nomset'] }}</td>
                        <td>{{ $doc_inativo['nomfnc']}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Nenhum docente Inativo encontrado.</p>
    @endif
</body>
</html>
