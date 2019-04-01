const data = [
  { name: 'PIBIC CNPq', id: 1, quantity: 28, percentage: 28 },
  { name: 'Ensinar com Pesquisa', id: 2, quantity: 30, percentage: 30 },
  { name: 'Bolsa interna FFLCH', id: 30, quantity: 27, percentage: 27 },
  { name: 'Sem Bolsa', id: 0, quantity: 40, percentage: 40 }
];

function createHorizontalBarChart() {
    let barChart = new britecharts.bar(),
        margin = {
                left: 200,
                right: 20,
                top: 20,
                bottom: 30
        },
        barContainer = d3.select('.js-bar-container'),
        containerWidth = barContainer.node() ? barContainer.node().getBoundingClientRect().width : false;

    barChart
       .horizontal(true)
       .margin(margin)
       .width(containerWidth)
       .colorSchema(britecharts.colors.colorSchemas.britechartsColorSchema)
       .valueLabel('percentage')
       .height(300);

    barContainer.datum(data).call(barChart);
}

function createDonutChart() {
  let donutChart = britecharts.donut();

  donutChart
    .width(400)
    .height(300);

  d3.select('.js-donut-container').datum(data).call(donutChart);

}

createHorizontalBarChart();
createDonutChart();
