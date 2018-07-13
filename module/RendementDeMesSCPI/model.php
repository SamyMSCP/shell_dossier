<?php
	$this->currentYear = Date("Y") - 1;
	$this->dividendes = $this->table['precalcul']['actualDividendes'];
	$this->details = "<ul style=\\'list-style-type: none;padding-left:0px;\\'>";

	foreach ($this->table as $key => $elm) {
		if ($key === 'precalcul')
			continue;
		$this->details .= "<li>" . addslashes(substr($key, 5)) . " " . number_format($elm['precalcul']['lastDividendes'], 2, ",", " "). " €</li>";
	}
	$this->details .= "</ul>";
	$this->details .= "<p style=\'font-size:10px; text-align: center; margin-top:20px;\'>Les dividendes sont issus des informations de bulletins trimestriels et peuvent ne pas correspondre à ce que vous avez perçu.</p>";
