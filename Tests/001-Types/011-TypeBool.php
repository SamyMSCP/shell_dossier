<?php

if (!test("Importation de la classe", class_exists("TypeBool"), "La classe type ne semble pas exister"))
	return (false);

if (!test("Vérification de la validité de la classe methode verify()", TypeBool::verify() === true, "Le type de donnée TypeBool ne semble pas être valide"))
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

$type = new TypeBool($table, ["column" => "dataTest"]);
if (!test("Instanciation de la clasee", $type instanceof Type, "Instanciation de la class"))
	return (false);


if (!test("Simple assignation : 0", $type->set(0) === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : false", $type->get() === false, "Simple récupération"))
	return (false);

if (!test("Simple assignation : 1", $type->set(1) === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : true", $type->get() === true, "Simple récupération"))
	return (false);

if (!test("Simple assignation : false", $type->set(false) === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : false", $type->get() === false, "Simple récupération"))
	return (false);

if (!test("Simple assignation : true", $type->set(true) === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : true", $type->get() === true, "Simple récupération"))
	return (false);

if (!test("Simple erreur : -42", $type->set(-42) === false, "Devrais pas être okay"))
	return (false);

if (!test("Test d'erreur : 0.5", $type->set(0.5) === false, "0.5 semble fonctionner alors qu'il ne devriat pas"))
	return (false);

if (!test("Vérification valeur inchangée : true", $type->get() === true, "La donnée devrait être true"))
	return (false);

return (true);
