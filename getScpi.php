<?php
include('app.php');
//file_put_contents("cache/coucou.txt", "yop");
if(isset($_SERVER['HTTP_HOST']))
	exit();
$societe  = CategoriesScpi::regenerateCacheApi();
$societe  = SocieteDeGestion::regenerateCacheAllSocieteDeGestion();
$scpi = Scpi::regenerateCacheAllScpi();
ScpiGestion::updateFromBdd();
