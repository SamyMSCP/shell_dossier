<?php

if (!test("Importation de la classe", class_exists("TypeDate"), "La classe type ne semble pas exister"))
	return (false);

if (!test("Vérification de la validité de la classe methode verify()", TypeDate::verify() === true, "Le type de donnée TypeDate ne semble pas être valide"))
	return (false);

if (!class_exists("Toto"))
{
	class Toto extends Table2 {

		protected static		$_dataAccess = [
			"dataTest" => [ 
				"get" => [ ACCESS_SERVER, ACCESS_OWNER ],
				"set" => [ ACCESS_SERVER, ACCESS_OWNER ]
			]
		];
		public $dataTest = 7850;
	}
}

$table = new Toto();

$type = new TypeDate($table, ["column" => "dataTest"]);
if (!test("Instanciation de la clasee", $type instanceof Type, "Instanciation de la class"))
	return (false);

if (!test("Simple assignation : 0", $type->set(0) === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Récupération 01/01/1970", $type->get()->format("d/m/Y") === "01/01/1970", "Set ne fonctionne pas"))
	return (false);

$date = new DateTime("NOW");
if (!test("Simple assignation : Datetime NOW", $type->set($date) === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Récupération " . $date->format("d/m/Y"), $type->get()->getTimestamp() === $date->getTimestamp(), "Set ne fonctionne pas"))
	return (false);

if (!test("Simple assignation : '26/05/1987'", $type->set("26/05/1987") === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Récupération 26/05/1987", $type->get()->format("d/m/Y") === "26/05/1987", "Set ne fonctionne pas"))
	return (false);

return (true);
