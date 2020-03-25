// Called at the very end
function createLinesChart() {
  
  const lineChart = new britecharts.line();
  const chartTooltip = new britecharts.tooltip();

  // Tooltip options
  chartTooltip.title('Iniciação Científica');
  

  const chartContainer = d3.select('.bolsas_ic');
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
  chartContainer.datum(dataset).call(lineChart);

  // Display tooltip
  const tooltipContainer = chartContainer.select('.metadata-group .hover-marker'); // Do this only after chart is display, `.hover-marker` is a part of the chart's generated SVG
  tooltipContainer.datum([]).call(chartTooltip);
  
}

const dataset = {
  'dataByTopic': [
    {
      'topic': 0,
      'dates': [
        {
          'date': '2015-06-27T07:00:00.000Z',
          'value': 1,
          'fullDate': '2015-06-27T07:00:00.000Z'
        }, {
          'date': '2015-06-28T07:00:00.000Z',
          'value': 1,
          'fullDate': '2015-06-28T07:00:00.000Z'
        }, {
          'date': '2015-06-29T07:00:00.000Z',
          'value': 4,
          'fullDate': '2015-06-29T07:00:00.000Z'
        }, {
          'date': '2015-06-30T07:00:00.000Z',
          'value': 2,
          'fullDate': '2015-06-30T07:00:00.000Z'
        }
      ],
      'topicName': 'CnpQ'
    }, {
      'topic': 1,
      'dates': [
        {
          'date': '2015-06-27T07:00:00.000Z',
          'value': 52,
          'fullDate': '2015-06-27T07:00:00.000Z'
        }, {
          'date': '2015-06-28T07:00:00.000Z',
          'value': 21,
          'fullDate': '2015-06-28T07:00:00.000Z'
        }, {
          'date': '2015-06-29T07:00:00.000Z',
          'value': 23,
          'fullDate': '2015-06-29T07:00:00.000Z'
        }, {
          'date': '2015-06-30T07:00:00.000Z',
          'value': 87,
          'fullDate': '2015-06-30T07:00:00.000Z'
        }
      ],
      'topicName': 'Fapesp'
    }, {
      'topic': 2,
      'dates': [
        {
          'date': '2015-06-27T07:00:00.000Z',
          'value': 31,
          'fullDate': '2015-06-27T07:00:00.000Z'
        }, {
          'date': '2015-06-28T07:00:00.000Z',
          'value': 73,
          'fullDate': '2015-06-28T07:00:00.000Z'
        }, {
          'date': '2015-06-29T07:00:00.000Z',
          'value': 61,
          'fullDate': '2015-06-29T07:00:00.000Z'
        }, {
          'date': '2015-06-30T07:00:00.000Z',
          'value': 40,
          'fullDate': '2015-06-30T07:00:00.000Z'
        }
      ],
      'topicName': 'FFLCh'
    } 
  ]
};

createLinesChart();
