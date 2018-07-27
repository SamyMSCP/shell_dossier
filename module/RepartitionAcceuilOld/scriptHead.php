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
		var data = [
		<?php
		$temoin = 0;
		$i = 0;
		foreach ($this->table as $key => $elm) {
		if ($key === "precalcul")
		continue ;
		if ($temoin == 1)
		echo " , ";
		if ($this->table['precalcul']['ventePotentielle'] == 0)
		echo " { value : " . number_format(1, 2, '.', '') . ", label : '" . $key  .  "', color:'#ffffff'} ";
		else
		echo " { value : " . number_format(100 * $elm['precalcul']['ventePotentielle'] / $this->table['precalcul']['ventePotentielle'], 2, '.', '') . ", label : \"" . $key  .  "\" , color:'" . $this->color[$i] . "'} ";
		$temoin = 1;
		$i++;
		if ($i === count($this->color))
		$i = 0;
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
		dataTmp = piechart;
		}
);
//#01528a
//#adbeca


