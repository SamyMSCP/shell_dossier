<?php

if (!test("Importation de la classe", class_exists("TypeEncryptedString"), "La classe TypeEncryptedString ne semble pas exister"))
	return (false);

if (!test("Vérification de la validité de la classe methode verify()", TypeEncryptedString::verify() === true, "Le type de donnée TypeEncryptedString ne semble pas être valide"))
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

$type = new TypeEncryptedString($table, ["column" => "dataTest"]);
if (!test("Instanciation de la classe", $type instanceof Type, "Instanciation de la class"))
	return (false);

if (!test("Simple assignation : 'Mathieu'", $type->set('Mathieu') === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : 'Mathieu'", $type->get() === 'Mathieu', "Simple récupération"))
	return (false);

if (!test("Test d'erreur : 42", $type->set(42) === false, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : 'Mathieu'", $type->get() === 'Mathieu', "Simple récupération"))
	return (false);

if (!test("Test d'erreur : null", $type->set(null) === false, "Set ne fonctionne pas"))
	return (false);

if (!test("Test d'erreur : ''", $type->set('') === false, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : 'Mathieu'", $type->get() === 'Mathieu', "Simple récupération"))
	return (false);

if (!test("Simple assignation : ' '", $type->set(' ') === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : ' '", $type->get() === ' ', "Simple récupération"))
	return (false);

return (true);
