<?php
	$this->StatusTransaction = StatusTransaction::getLst();

	$stList = [];
	foreach ($this->StatusTransaction as $index => $group) {
		foreach ($group as $i => $el) {
//			dbg($el);
//			die();
			$stList[$index . "-" . $i] = $index . "-" . $i . ' ' . $el['title'];
		}
	}
	$this->lstStValueText = $stList;
	$this->loadModuleAdmin("TransactionsComponent", "TransactionsComponent", []);
	$this->loadModuleAdmin("ConseillerStore", "ConseillerStore", []);
	unset($stList);

	$group = [];
