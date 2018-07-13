<?php

if (!test("Importation de la classe", class_exists("TypeUInt"), "La classe type ne semble pas exister"))
	return (false);

if (!test("Vérification de la validité de la classe methode verify()", TypeUInt::verify() === true, "Le type de donnée TypeUInt ne semble pas être valide"))
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

$type = new TypeUint($table, ["column" => "dataTest"]);
if (!test("Instanciation de la clasee", $type instanceof Type, "Instanciation de la class"))
	return (false);


if (!test("Simple assignation : 0", $type->set(0) === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : 0", $type->get() === 0, "Simple récupération"))
	return (false);

if (!test("Test d'erreur : -42", $type->set(-42) === false, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : 0", $type->get() === 0, "Simple récupération"))
	return (false);

if (!test("Test d'erreur : 0.5", $type->set(0.5) === false, "0.5 semble fonctionner alors qu'il ne devriat pas"))
	return (false);

if (!test("Simple assignation : 42", $type->set(42) === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : 42", $type->get() === 42, "Simple récupération"))
	return (false);

if (!test("Test d'erreur : 0.5", $type->set(0.5) === false, "0.5 semble fonctionner alors qu'il ne devriat pas"))
	return (false);

if (!test("Vérification valeur inchangée : 42", $type->get() === 42, "La donnée ne devrait pas avoir été changée"))
	return (false);

return (true);
