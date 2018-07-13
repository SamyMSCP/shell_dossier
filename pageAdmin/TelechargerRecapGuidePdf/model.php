<?php

if (!isset($_GET['doc']))
	die("la requete est dans un mauvais format");
else if ($_GET['doc'] === 'guide')
	$this->printGuides();
else if ($_GET['doc'] === 'pdf')
	$this->printPdf();
die("la requete est dans un mauvais format");
