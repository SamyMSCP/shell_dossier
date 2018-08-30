</script>
<script>


//$(document).ready(
//	function () {
//		var ctx = $("#repartition_geographique").get(0).getContext("2d");
//		var data = [
//			<?php
//			$temoin = 0;
//			foreach ($this->data as $key => $value) {
//			if ($this->total == 0)
//				continue;
//			if ($temoin === 1)
//				echo ",";
//			?>
//			{
//				value: <?php //if ($value > 0) echo number_format(100 * $value / $this->total, 2, '.', ''); else echo 0; ?>//,
//				color: "<?//= $this->color[$key] ?>//",
//				highlight: "<?//= $this->color[$key] ?>//",
//				label: "<?//=$key?>//"
//			}
//			<?php
//			$temoin = 1;
//			}
//			?>
//		];
//		var pieOptions = {
//			maintainAspectRatio: false,
//			tooltipFillColor: "rgba(255,255,255,1)",
//			tooltipFontColor: "#000",
//			<?php //if (!isset($this->pdf)): ?>
//			animation: true,
//			responsive: true,
//			<?php //else: ?>
//			animation: false,
//			responsive: false,
//			<?php //endif; ?>
//			tooltipFontSize: 12,
//			tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %> %"
//		}
//		var piechart = new Chart(ctx).Pie(data, pieOptions);
//	}
//);


$(document).ready(
	function () {
		var ctx = (!!$("#repartition_geographique")) ? $("#repartition_geographique").get(0).getContext("2d") : null;
		var data = [
			<?php
			$temoin = 0;
			foreach ($this->data as $key => $value) {
			if ($this->total == 0)
				continue;
			if ($temoin === 1)
				echo ",";
			?>
			{
				value: <?php if ($value > 0) echo number_format(100 * $value / $this->total, 2, '.', ''); else echo 0; ?>,
				color: "<?= $this->color[$key] ?>",
				highlight: "<?= $this->color[$key] ?>",
				label: "<?=$key?>"
			}
			<?php
			$temoin = 1;
			}
			?>
		];
		var pieOptions = {
			maintainAspectRatio: false,
			tooltipFillColor: "rgba(255,255,255,1)",
			tooltipFontColor: "#000",
			<?php if (!isset($this->pdf)): ?>
			animation: true,
			responsive: true,
			<?php else: ?>
			animation: false,
			responsive: false,
			<?php endif; ?>
			tooltipFontSize: 12,
			tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %> %"
		}
		var piechart = new Chart(ctx).Pie(data, pieOptions);
		dataTmp = piechart;
	}
);