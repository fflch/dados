/*
 * endpoints necessários:
 * total de alunos matrículados graduação
 * total de alunos matrículados mestrado
 * total de alunos matrículados doutorado
 * total de servidores ativos
 * total de docentes ativos
 * /

d3.json("https://api.fflch.usp.br/pessoa/servidores/total/ativos")
    .get(function(error, data){
        console.log(data);
    });
