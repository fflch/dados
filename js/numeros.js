var base = 'https://api.fflch.usp.br/pessoa/vinculo/total/ativos/';

window.onload = function() {
    var dataChart = [];

    getNumero('Docente')
        .then((response) => dataChart.push(['Docentes', response[0].totalvinculo]))
        .then(() =>
            getNumero('Servidor')
                .then((response) => dataChart.push(['Servidores', response[0].totalvinculo]))
                .then(() => createBarChart(dataChart))
            )


}

function createBarChart(dataChart) {
    c3.generate({
        bindto: '#numeros',
        data: {
            columns: dataChart,
        	type: 'bar'
        }
    });
}

function getNumero(endpoint) {
    return new Promise(
        function(resolve, reject) {
            fetch(base + endpoint).then(function(response){
              response.json().then((saida) => resolve(saida));
            });
        }
    );
}
