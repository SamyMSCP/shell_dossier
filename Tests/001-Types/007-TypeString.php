<?php

if (!test("Importation de la classe", class_exists("TypeString"), "La classe type ne semble pas exister"))
	return (false);

if (!test("Vérification de la validité de la classe methode verify()", TypeString::verify() === true, "Le type de donnée TypeString ne semble pas être valide"))
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

$type = new TypeString($table, ["column" => "dataTest"]);
if (!test("Instanciation de la clasee", $type instanceof Type, "Instanciation de la class"))
	return (false);

if (!test("Simple assignation : 'Mathieu'", $type->set('Mathieu') === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : 'Mathieu'", $type->get() === 'Mathieu', "Simple récupération"))
	return (false);

if (!test("Test d'erreur : 42", $type->set(42) === false, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : 'Mathieu'", $type->get() === 'Mathieu', "Simple récupération"))
	return (false);


return (true);
