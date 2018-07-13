<?php
//$this->loadModule("ValeurIsf", "ValeurIsf", array("dh" => Dh::getCurrent()));
$m = new ValeurIsf(array("dh" => Dh::getCurrent()));
echo $m;
