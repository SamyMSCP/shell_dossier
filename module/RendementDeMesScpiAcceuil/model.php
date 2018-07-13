<?php
	$this->currentYear = Date("Y");
	$this->dividendes = $this->table['precalcul']['actualDividendes'];
	$this->lastDividendes = $this->table['precalcul']['lastDividendes'];
	$this->details = "<ul style=\\'list-style-type: none;padding-left:0px;\\'>";

	//Tri
	$table = $this->table;
	uasort($table, function($a, $b){
		if (isset($a['precalcul']) && isset($b['precalcul']))
			return(strcmp($a['precalcul']['name'], $b['precalcul']['name']));
		else
			return (0);
	});
	$this->details .= "<li style=\\'font-weight:900;text-align:center;\\'>" . ($this->currentYear - 1) . "</li>";
	foreach ($table as $key => $elm) {
		if ($key === 'precalcul')
			continue;
		$this->details .= "<li>" . addslashes(substr($key, 5)) . " : " . number_format($elm['precalcul']['lastDividendes'], 2, ",", " "). " €</li>";
	}
	/*
	$this->details .= "<li style=\\'font-weight:900;text-align:center;margin-top:20px;\\'>" . $this->currentYear . "</li>";
	foreach ($table as $key => $elm) {
		if ($key === 'precalcul')
			continue;
		$this->details .= "<li>" . addslashes(substr($key, 5)) . " " . number_format($elm['precalcul']['actualDividendes'], 2, ",", " "). " €</li>";
	}
	*/
	$this->details .= "</ul>";
	$this->details .= "<p style=\'font-size:10px; text-align: center; margin-top:20px;\'>Les dividendes sont issus des informations de bulletins trimestriels et peuvent ne pas correspondre à ce que vous avez perçu.</p>";
