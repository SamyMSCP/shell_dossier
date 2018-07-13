<?php
$this->dh = Dh::getCurrent();

if ($this->dh->confirmation != 3)
{
	http_response_code(404);
	exit();
}

Logger::setNew("Visualisation PDF", $this->dh->id_dh, $this->dh->id_dh, ["Document" => "Situation patrimoine"]);
$m = new ValeurPatrimoine(array("dh" => $this->dh));
echo $m;
