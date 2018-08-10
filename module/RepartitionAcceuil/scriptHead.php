</script>
<script type="text/javascript">

<?php
$colorStart = array(
		"r" => 173,
		"g" => 190,
		"b" => 202
		);
$colorEnd = array(
		"r" => 1,
		"g" => 82,
		"b" =>138 
		);
function interpolation($colorStart, $colorEnd, $pourcent)
{
	$r = (($colorEnd['r'] - $colorStart['r']) * $pourcent) + $colorStart['r'];
	$g = (($colorEnd['g'] - $colorStart['g']) * $pourcent) + $colorStart['g'];
	$b = (($colorEnd['b'] - $colorStart['b']) * $pourcent) + $colorStart['b'];
	return ("rgba(" . intval($r) . ", " . intval($g) . ", " . intval($b) . ", 1)");
}
//echo interpolation($colorStart, $colorEnd, 1);
//exit();
?>
dataTmp = null;
$(document).ready(
	function() {
		var ctx = $("#repartition_scpi").get(0).getContext("2d");
		var data = [];
		total = 0.0;
		function getColor(i) {
			var color =[
				"#086ab3",
				"#0b87e4",
				"#2c9ff5",
				"#5db5f8",
				"#8dcbfa",
				"#bee2fc",
				"#eff8fe"
				];
			return color[i];
		}

		total = store.state.transactions.precalcul.precalcul.ventePotentielle;

		for (var key in store.state.transactions.precalcul) {
			var elm = store.state.transactions.precalcul[key];
			if (key == 'precalcul')
				continue ;
			data.push({ value: parseFloat((elm.precalcul.ventePotentielle / total * 100).toFixed(2)),
				label: key,
				color: getColor(i)
			});
		}
		data.sort((a,b) => {
			return b.value - a.value;
		});
		data.forEach((trans, i) => {
			trans.color = getColor(i)
		});
		
		if (data.length > 5) {
			var autre = data.slice(5);
			var res = 0;
			autre.forEach(el => {
				res += el.value;
			});
			data = data.splice(0, 5);
			data.push({
				value: parseFloat(res.toFixed(2)),
				label: "Autre",
				color: getColor(5)
			})
		}



		var pieOptions = {
maintainAspectRatio: false,
			 tooltipFillColor: "rgba(255,255,255,1)",
			 tooltipFontColor: "#000",
			 <?php if (!isset($this->pdf)): ?>
				 animation : true,
			 responsive: true,
			 <?php else: ?>
				 animation : false,
			 responsive: false,
			 <?php endif; ?>
				 tooltipFontSize: 12,
			 tooltipTemplate:"<%if (label){%><%=label%>: <%}%><%= value %> %"
		}
		var piechart = new Chart(ctx).Pie(data, pieOptions);
		dataTmp = piechart;
	}
);



</script>

<script type="text/x-template" id="repartitionScpiTemplate">
	<ul>
		<li v-for="(trans, key) in getDatas" v-if='key != "precalcul"' :style=' "color:" + trans.color'>
			<span class="pill-color"><i class="fa fa-circle"></i></span>
			<span class="name">{{ trans.label  }}</span>
			<span class="purcent-info">{{ trans.value | pourcent }}</span>
		</li>
	</ul>
</script>

<script>
	 Vue.component(
		'repartition-scpi',
		{
			data: function() {
				return ({ });
			},
			computed: {
				getDatas: function() {
					var data = [];
					total = 0.0;
					function getColor(i) {
						var color =[
							"#086ab3",
							"#0b87e4",
							"#2c9ff5",
							"#5db5f8",
							"#8dcbfa",
							"#bee2fc",
							"#eff8fe"
							];
						return color[i];
					}

					total = this.$store.state.transactions.precalcul.precalcul.ventePotentielle;
					for (var key in this.$store.state.transactions.precalcul) {
						var elm = this.$store.state.transactions.precalcul[key];
						if (key == 'precalcul')
							continue ;
						data.push({ value: parseFloat((elm.precalcul.ventePotentielle / total * 100).toFixed(2)),
							label: key,
							color: getColor(i)
						});
					}
					data.sort((a,b) => {
						return b.value - a.value;
					});
					data.forEach((trans, i) => {
						trans.color = getColor(i)
					});
					
					if (data.length > 5) {
						var autre = data.slice(5);
						var res = 0;
						autre.forEach(el => {
							res += el.value;
						});
						data = data.splice(0, 5);
						data.push({
							value: parseFloat(res.toFixed(2)),
							label: "Autre",
							color: getColor(5)
						})
					}
					return (data);
					//return (this.$store.state.transactions.precalcul);
				},
			},
			template: '#repartitionScpiTemplate'
		}
	);
