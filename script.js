// Called at the very end

createLinesChart();

function createLinesChart() {

  const lineChart = new britecharts.line();
  const chartTooltip = new britecharts.tooltip();

  // Tooltip options
  chartTooltip.title('Iniciação Científica');
  

  const chartContainer = d3.select('.bolsas');
  const containerWidth = chartContainer.node() ? chartContainer.node().getBoundingClientRect().width : false;

  // Line chart options
  lineChart
    .isAnimated(true)
    .aspectRatio(0.5)
    .width(containerWidth)
    .height(350)
    .grid('full')
    .forcedXFormat('%Y')
.forceAxisFormat('custom')
.forcedXTicks(2)
    .on('customMouseOver', chartTooltip.show)
    .on('customMouseMove', chartTooltip.update)
    .on('customMouseOut', chartTooltip.hide);
  
  // Display line chart 
var data;
d3.json("http://127.0.0.1:8000/d3/iniciacao-cientifica/bolsas")
    .get(function(error, data){
        data = data;
        console.log(data);
    });
   // chartContainer.datum(data).call(lineChart);

  // Display tooltip
  const tooltipContainer = chartContainer.select('.metadata-group .hover-marker'); // Do this only after chart is display, `.hover-marker` is a part of the chart's generated SVG
  tooltipContainer.datum([]).call(chartTooltip);
  
}







