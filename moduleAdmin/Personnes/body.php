<?php
if (isset($GLOBALS['GET']['typePersonne']) && $GLOBALS['GET']['typePersonne'] === "Physique")
	include("formPersonnePhysique.php");
else if (isset($GLOBALS['GET']['typePersonne']) && $GLOBALS['GET']['typePersonne'] === "Morale")
	include("formPersonneMorale.php");
