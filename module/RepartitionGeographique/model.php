<?php
	$this->data = array(
		"Paris" => 0,
		"Regions" => 0,
		"IDF" => 0,
		"Etranger" => 0
	);
	$this->color = array(
		"Paris" => "#086ab3",
		"Regions" => "#0b87e4",
		"IDF" => "#2c9ff5",
		"Etranger" => "#5db5f8"
	);

	$this->colorTxt = array(
		"rgb(57, 128, 181)",
		 "rgb(103, 157, 198)",
		"rgb(149, 187, 215)",
		"rgb(176, 204, 225)"
	);
	$this->total = 0;
	foreach ($this->table as $key => $elm) {
		if ($key === 'precalcul')
			continue ;
		$current = (array)$elm['precalcul']['scpi'];
		//dbg($current);
		if (isset($current["Paris"])) {
			$this->data["Paris"] += $elm['precalcul']['ventePotentielle'] * $current['Paris'];
			$this->total += $elm['precalcul']['ventePotentielle'] * $current['Paris'];
		}
		if (isset($current["Régions"])) {
			$this->data["Regions"] += $elm['precalcul']['ventePotentielle'] * $current['Régions'];
			$this->total += $elm['precalcul']['ventePotentielle'] * $current['Régions'];
		}
		if (isset($current["Ile-de-France"])) {
			$this->data["IDF"] += $elm['precalcul']['ventePotentielle'] * $current['Ile-de-France'];
			$this->total += $elm['precalcul']['ventePotentielle'] * $current['Ile-de-France'];
		}
		if (isset($current["Etranger"])) {
			$this->data["Etranger"] += $elm['precalcul']['ventePotentielle'] * $current['Etranger'];
			$this->total += $elm['precalcul']['ventePotentielle'] * $current['Etranger'];
		}
	}
	//exit();
	function cmpGeo($a, $b)
	{
		return ($a < $b);
		//return (1);
	}
	uasort($this->data, "cmpGeo");
	//dbg($this->data);
	//exit();
?>
