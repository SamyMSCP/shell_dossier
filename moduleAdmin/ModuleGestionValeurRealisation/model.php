<?php
$this->lstScpi = Scpi::getAll();
$this->temoin = [];
foreach($this->lstScpi as $key => $elm)
{
	$this->temoin[] = [
		"value" => $elm->getValeurRealisationManuelle(),
		"value_base" => $elm->getValeurRealisationManuelle(),
		"changed" => false,
		"data" => $elm
	];
}
