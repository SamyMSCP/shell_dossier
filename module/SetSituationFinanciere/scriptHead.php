</script>
<script type="text/javascript" charset="utf-8">

var ctxChartPatrimoine = null;
var dataPatrimoine = null;
var pieOptionsPatrimoine = null;
var pieChartPatrimoine = null;

var colorSet = [
	'#1781E0',
	'#147BD5',
	'#1175CA',
	'#0E6FBF',
	'#0C69B5',
	'#0963AA',
	'#065D9F',
	'#035794'
];

function showChart1() {
	ctxChartPatrimoine = $("#repartition_revenu").get(0).getContext("2d");
	dataPatrimoine = [
		];
	pieOptionsPatrimoine = {
		responsive: true,
		maintainAspectRatio: false,
		tooltipFillColor: "rgba(255,255,255,1)",
		tooltipFontColor: "#000",
		animation : true,
		tooltipFontSize: 12,
		//tooltipTemplate:"<%if (label){%><%=label%>: <%}%><%= value %> %"
		tooltipTemplate:"<%=label%>"
	}
	pieChartPatrimoine = new Chart(ctxChartPatrimoine).Pie(dataPatrimoine, pieOptionsPatrimoine);
	var total = 0;
	$('.forRepRevenu').each(function (key, value) {
		total += Number($($(value).children()[1]).find('input').val());
	});

	$('.forRepRevenu').each(function (key, value) {
		var nbr;
		if (total == 0)
		{
			nbr = 1;
			total = 1;
		}
		else
		{
			nbr = Number($($(value).children()[1]).find('input').val());
		}
		var data = {
			value:  nbr,
			label: $($(value).children()[0]).text() + " : " + ((nbr / total) * 100).toFixed(2) + " %",
			color: colorSet[key],
			highlightColor: "#8ec3f3"
		};
		pieChartPatrimoine.addData(data);

		$(value).on('mouseover', function () {
			pieChartPatrimoine.segments[key].fillColor = "#8ec3f3";
			pieChartPatrimoine.update();
		});
		$(value).on('mouseout', function () {
			pieChartPatrimoine.segments[key].fillColor = colorSet[key];
			pieChartPatrimoine.update();
		});
	});
	$("#repartition_revenu").on('click', function (evt) {
		var activePoints = pieChartPatrimoine.getSegmentsAtEvent(evt.originalEvent);
	});
}

function updateChart1() {
	var total = 0;
	$('.forRepRevenu').each(function (key, value) {
		total += Number($($(value).children()[1]).find('input').val());
	});

	$('.forRepRevenu').each(function (key, value) {
		var nbr;
		if (total == 0)
		{
			nbr = 1;
			total = 1;
		}
		else
		{
			nbr = Number($($(value).children()[1]).find('input').val());
		}
		//var data = Number($($(value).children()[1]).find('input').val()) + 0.001;
		//if (key == 0 && data.value == 0)
			//data = 1;
		pieChartPatrimoine.segments[key].value = nbr;
		pieChartPatrimoine.segments[key].label = $($(value).children()[0]).text() + " : " + ((nbr  / total) * 100).toFixed(2)  + " %";
	});
	pieChartPatrimoine.update();
}

function showChart2() {
	ctxChartPatrimoine = $("#repartition_charges").get(0).getContext("2d");
	dataPatrimoine = [
		];
	pieOptionsPatrimoine = {
		responsive: true,
		maintainAspectRatio: false,
		tooltipFillColor: "rgba(255,255,255,1)",
		tooltipFontColor: "#000",
		animation : true,
		tooltipFontSize: 12,
		//tooltipTemplate:"<%if (label){%><%=label%>: <%}%><%= value %> %"
		tooltipTemplate:"<%=label%>"
	}
	pieChartPatrimoine = new Chart(ctxChartPatrimoine).Pie(dataPatrimoine, pieOptionsPatrimoine);
	var total = 0;
	$('.forRepCharges').each(function (key, value) {
		total += Number($($(value).children()[1]).find('input').val());
	});

	$('.forRepCharges').each(function (key, value) {
		var nbr;
		if (total == 0)
		{
			nbr = 1;
			total = 1;
		}
		else
		{
			nbr = Number($($(value).children()[1]).find('input').val());
		}
		var data = {
			value:  nbr,
			label: $($(value).children()[0]).text() + " : " + ((nbr / total) * 100).toFixed(2) + " %",
			color: colorSet[key],
			highlightColor: "#8ec3f3"
		};
		pieChartPatrimoine.addData(data);

		$(value).on('mouseover', function () {
			pieChartPatrimoine.segments[key].fillColor = "#8ec3f3";
			pieChartPatrimoine.update();
		});
		$(value).on('mouseout', function () {
			pieChartPatrimoine.segments[key].fillColor = colorSet[key];
			pieChartPatrimoine.update();
		});
	});
	$("#repartition_charges").on('click', function (evt) {
		var activePoints = pieChartPatrimoine.getSegmentsAtEvent(evt.originalEvent);
	});
}

function updateChart2() {
	console.log("Je suis appelé");
	var total = 0;
	$('.forRepCharges').each(function (key, value) {
		total += Number($($(value).children()[1]).find('input').val());
	});

	$('.forRepCharges').each(function (key, value) {
		var nbr;
		if (total == 0)
		{
			nbr = 1;
			total = 1;
		}
		else
		{
			nbr = Number($($(value).children()[1]).find('input').val());
		}
		//var data = Number($($(value).children()[1]).find('input').val()) + 0.001;
		//if (key == 0 && data.value == 0)
			//data = 1;
		pieChartPatrimoine.segments[key].value = nbr;
		pieChartPatrimoine.segments[key].label = $($(value).children()[0]).text() + " : " + ((nbr  / total) * 100).toFixed(2)  + " %";
	});
	pieChartPatrimoine.update();
}
