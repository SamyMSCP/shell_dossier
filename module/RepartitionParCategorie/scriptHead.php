$(document).ready(
function() {
var ctx = $("#categ_scpi").get(0).getContext("2d");
var data = [
<?php
$temoin = 0;
$i = 0;
$autre = 0.0;
foreach ($this->data as $key => $value) {
	if ($this->total == 0)
		continue;
	if ($temoin === 1)
		echo ",";
	if ($i > 3) {
		$autre += 100 * $value / $this->total;
		continue;
	}
	?>
	{
	value: <?php if ($value > 0) echo number_format(100 * $value / $this->total, 2, '.', ''); else echo 0; ?>,
	color: "<?= $this->color[$i] ?>",
	highlight: "<?= $this->color[$i] ?>",
	label: "<?= $key ?>"
	}
	<?php
	$temoin = 1;
	$i++;
}
if ($autre != 0.0) {
	?>
	{
	value: <?php echo number_format($autre, 2, '.', ''); ?>,
	color: "<?= $this->color[4] ?>",
	highlight: "<?= $this->color[4] ?>",
	label: "Autre"
	}
	<?php
}
?>
];
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
}
);
