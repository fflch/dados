d3.csv("data.csv").then(d => chart(d));

function chart(csv) {

	csv.forEach(function(d) {
		var dates = d.date.split("-");
		d.year = dates[0]; d.month = dates[1];
		d.value = +d.value;
		return d;
	})

	var months = [...new Set(csv.map(d => d.month))],
		years  = [...new Set(csv.map(d => d.year))];

	var options = d3.select("#year").selectAll("option")
		.data(years)
	.enter().append("option")
		.text(d => d)

	var svg = d3.select("#chart"),
		margin = {top: 25, bottom: 10, left: 25, right: 25},
		width = +svg.attr("width") - margin.left - margin.right,
		height = +svg.attr("height") - margin.top - margin.bottom;

	var x = d3.scaleBand()
		.range([margin.left, width - margin.right])
		.padding(0.1)
		.paddingOuter(0.2)
	
	var y = d3.scaleLinear()
		.range([height - margin.bottom, margin.top])

	var xAxis = g => g
		.attr("transform", "translate(0," + (height - margin.bottom) + ")")
		.call(d3.axisBottom(x).tickSizeOuter(0))

	var yAxis = g => g
		.attr("transform", "translate(" + margin.left + ",0)")
		.call(d3.axisLeft(y))

	svg.append("g")
		.attr("class", "x-axis")

	svg.append("g")
		.attr("class", "y-axis")

	update(d3.select("#year").property("value"), 0)

	function update(year, speed) {

		var data = csv.filter(f => f.year == year)
	
		y.domain([0, d3.max(data, d => d.value)]).nice()

		svg.selectAll(".y-axis").transition().duration(speed)
			.call(yAxis);

		data.sort(d3.select("#sort").property("checked")
			? (a, b) => b.value - a.value
			: (a, b) => months.indexOf(a.month) - months.indexOf(b.month))

		x.domain(data.map(d => d.month))

		svg.selectAll(".x-axis").transition().duration(speed)
			.call(xAxis)

		var bar = svg.selectAll(".bar")
			.data(data, d => d.month)

		bar.exit().remove();

		bar.enter().append("rect")
			.attr("class", "bar")
			.attr("fill", "steelblue")
			.attr("width", x.bandwidth())
			.merge(bar)
		.transition().duration(speed)
			.attr("x", d => x(d.month))
			.attr("y", d => y(d.value))
			.attr("height", d => y(0) - y(d.value))
	}

	chart.update = update;
}

var select = d3.select("#year")
	.style("border-radius", "5px")
	.on("change", function() {
		chart.update(this.value, 750)
	})

var checkbox = d3.select("#sort")
	.style("margin-left", "45%")
	.on("click", function() {
		chart.update(select.property("value"), 750)
	})

