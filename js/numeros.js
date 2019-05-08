
var docentes;
var base = 'https://api.fflch.usp.br/pessoa/vinculo/total/ativos/';

window.onload = function() {
  docentes();
  servidores();


var dataset = [
    {
        value: 1,
        name: 'glittering'
    },
    {
        value: 1,
        name: 'luminous'
    }
];

const barChart = new britecharts.bar();
 const chartTooltip = new britecharts.tooltip();


barChart
  //    .width(containerWidth)
    .height(300)
  //    .hasPercentage(true)
    .enableLabels(true)
    .labelsNumberFormat('.0%')
    .isAnimated(true)
    .on('customMouseOver', tooltip.show)
    .on('customMouseMove', tooltip.update)
    .on('customMouseOut', tooltip.hide);

barContainer.datum(dataset).call(barChart);

tooltip
    .numberFormat('.2%');

tooltipContainer = d3.select('.bar-chart .metadata-group');
tooltipContainer.datum([]).call(tooltip);


}

function docentes(){
  fetch(base + 'Docente').then(function(response){
    response.text().then(function(saida){
      console.log(saida);
    });
  });
}

function servidores(){
  fetch(base + 'Servidor').then(function(response){
    response.text().then(function(saida){
      console.log(saida);
    });
  });
}



