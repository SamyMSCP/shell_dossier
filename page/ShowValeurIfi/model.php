<?php
$dh = Dh::getCurrent();
$expatrie = (isset($GLOBALS['GET']['expatrie']) && intval($GLOBALS['GET']['expatrie']) === 1);

$this->loadModule("ValeurIfi", "ValeurIfi", [
	"dh" => $dh,
	"expatrie" => $expatrie
]);