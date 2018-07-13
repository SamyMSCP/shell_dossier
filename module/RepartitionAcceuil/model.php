<?php
$this->color = array(
	"#eff8fe",
	"#bee2fc",
	"#8dcbfa",
	"#5db5f8",
	"#2c9ff5",
	"#0b87e4",
	"#086ab3"
);

$this->color = array_reverse($this->color);
/*
	$this->data = array(
		"Paris" => 0,
		"Regions" => 0,
		"IDF" => 0,
		"Etranger" => 0
	);
	$this->color = array(
		"Paris" => "#0073B1",
		"Regions" => "#01528A",
		"IDF" => "#0085A9",
		"Etranger" => "#009491"
	);
	$this->color = a
	$this->total = 0;
	foreach ($this->table as $key => $elm) {
		if ($key === 'precalcul')
			continue ;
		$current = (array)$elm['precalcul']['scpi'];
		if (isset($current["Paris"])) {
			$this->data["Paris"] += $elm['precalcul']['nbr_part'] * $current['Paris'];
			$this->total += $elm['precalcul']['nbr_part'] * $current['Paris'];
		}
		if (isset($current["Régions"])) {
			$this->data["Regions"] += $elm['precalcul']['nbr_part'] * $current['Régions'];
			$this->total += $elm['precalcul']['nbr_part'] * $current['Régions'];
		}
		if (isset($current["Ile-de-France"])) {
			$this->data["IDF"] += $elm['precalcul']['nbr_part'] * $current['Ile-de-France'];
			$this->total += $elm['precalcul']['nbr_part'] * $current['Ile-de-France'];
		}
		if (isset($current["Etranger"])) {
			$this->data["Etranger"] += $elm['precalcul']['nbr_part'] * $current['Etranger'];
			$this->total += $elm['precalcul']['nbr_part'] * $current['Etranger'];
		}
	}
*/
?>

