</script> <script>

var vm = new Vue({
	el: ".vueApp",
	store: store,

	data: {
		d_json: JSON.parse(`<?=json_encode(OrderHistoric::getAllDataScpi())?>`),
		d_csv: JSON.parse(`<?=trim(json_encode(OrderHistoric::getAllCSV()))?>`)
	},
	computed: {
		getCsv: function () {
			let t = this.d_csv;
			var array = typeof t != 'object' ? JSON.parse(t) : t;

			var str = '';
			for (var i = 0; i < array.length; i++) {
				var line = '';
				for (var index in array[i]) {
					if (line != '') line += ',';
					line += array[i][index];
				}
				str += line + '\r\n';
			}
			return str;
		}
	}
});



var format = "DD-MM-YYYY";

var d = vm.$store.getters.getMaxDate();
d.subtract(6, "days");
var all = {achat: [], vente: []};
for (var i = 1; i <= 7; i++){
	var tmp = vm.$store.getters.getVolByDay(d.format(format));
	d.add(1, "days");

	all.achat.push(tmp.buy);
	all.vente.push(tmp.sell);
}

//console.log(d.format(format));
//console.log(vm.$store.getters.getMaxDate().format(format));
//var chartAchat = new Chart(document.getElementById('chartVolAchat').getContext('2d'), {

    var dow = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
	var r = d.format('d');
    var index = r;
    while (index >= 0)
    {
        dow.push(dow.shift());
        index--;
    }
    var chartdata = {
        labels: dow,
        datasets: [
            {
                label: "Vente",
                fillColor: "rgba(23,234,7,0.5)",
                strokeColor: "#17ea07",
                pointColor: "rgba(23,234,7,0.5)",
                pointStrokeColor: "#17ea07",
                pointHighLightFill: "#fff",
                pointHighLightStroke: "rgba(23,234,7,0.5)",
                data: all.vente
            },
            {
                label: "Achat",
                fillColor: "rgba(7,75,234,0.5)",
                strokeColor: "#074bea",
                pointColor: "rgba(7,75,234,0.5)",
                pointStrokeColor: "#074bea",
                pointHighLightFill: "#fff",
                pointHighLightStroke: "rgba(7,75,234,0.5)",
                data: all.achat
            }
        ]
    };
    var chart = new Chart(document.getElementById('chartVolAchat').getContext('2d')).Line(chartdata , {
        responsive: true,
        animation: {
            duration: 0,
        },
        hover: {
            animationDuration: 0,
        },
        responsiveAnimationDuration: 0,
        multiTooltipTemplate: '<%= datasetLabel %>: <%= Number(value).toLocaleString("fr", {style: "currency", currency: "EUR"}) %>',
        scaleLabel: '<%= Number(value).toLocaleString("fr", {style: "currency", currency: "EUR"}) %>'
    });


	var rat = [];
	var i = 0;
	var tot = 0;
	while (i < all.achat.length && i < all.vente.length) {
		if (all.vente[i] !== 0 && all.achat[i] !== 0)
		{
			rat.push((all.vente[i] / all.achat[i]) * 1.0);
			tot += (all.vente[i] / all.achat[i]) * 1.0;
		}
		else
			rat.push(0.0);
		i++;
	}

	tot /= i;
	var av = [];
	while (i-- > 0){
		av.push(tot);
	}


	chartdata = {
	labels: dow,
	datasets: [
		{
			label: "Ratio",
			fillColor: "#EA7200",
			strokeColor: "#EA7200",
			pointColor: "#a95500",
			pointStrokeColor: "#a95500",
			pointHighLightFill: "#fff",
			pointHighLightStroke: "#a95500",
			data: rat
		},
		{
			label: "moyenne",
			fillColor: "rgba(80, 80, 80, 0.0",
			strokeColor: "rgba(80, 80, 80, 0.5)",
			pointColor: "rgba(80, 80, 80, 0.0)",
			pointStrokeColor: "rgba(80, 80, 80, 0.0)",
			pointHighLightFill: "rgba(80, 80, 80, 0.5",
			pointHighLightStroke: "rgba(7,75,234,0.5)",
			data: av
		}
	]
};
var chart2 = new Chart(document.getElementById('chartVolDiff').getContext('2d')).Line(chartdata , {
	responsive: true,
	animation: {
		duration: 0,
	},
	hover: {
		animationDuration: 0,
	},

	responsiveAnimationDuration: 0,
	multiTooltipTemplate: '<%= datasetLabel %>: <%= Number(value).toLocaleString("fr", {maximumFractionDigits: 3}) %> x',
	scaleLabel: '<%= Number(value).toLocaleString("fr", {maximumFractionDigits: 3}) %> x'
});
