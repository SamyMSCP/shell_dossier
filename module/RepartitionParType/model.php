<?php
	$this->fixe = 0;
	$this->variable = 0;
	$this->sum = 0;
	//foreach (Dh::getCurrent()->getDistinctTransaction() as $elm) {
	foreach ($this->table as $key => $elm) {
		if ($key == "precalcul")
			continue;
		if ($elm["precalcul"]['scpi']->TypeCapital == "fixe") {
			$this->fixe += $elm["precalcul"]['ventePotentielle'];
		}
		else if ($elm["precalcul"]['scpi']->TypeCapital == "variable") {
			$this->variable += $elm["precalcul"]['ventePotentielle'];
		}
		$this->sum += $elm["precalcul"]['ventePotentielle'];
	}
	if ($this->sum) {
		$this->fixe /= $this->sum;
		$this->fixe *= 100;
		$this->variable /= $this->sum;
		$this->variable *= 100;
	}
	else
	{
		$this->fixe = 0;
		$this->variable = 100;
	}
?>
