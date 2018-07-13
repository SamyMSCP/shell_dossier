<?php

if (!test("Importation de la classe", class_exists("TypeEncryptedName"), "La classe TypeEncryptedName ne semble pas exister"))
	return (false);

if (!test("Vérification de la validité de la classe methode verify()", TypeEncryptedName::verify() === true, "Le type de donnée TypeEncryptedName ne semble pas être valide"))
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

$type = new TypeEncryptedName($table, ["column" => "dataTest"]);
if (!test("Instanciation de la classe", $type instanceof Type, "Instanciation de la class"))
	return (false);

if (!test("Simple assignation : 'Mathieu'", $type->set('Mathieu') === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : 'mathieu'", $type->get() === 'mathieu', "Simple récupération"))
	return (false);

if (!test("Test d'erreur : 42", $type->set(42) == false, "L'assignation de donnée de type int ne devrait pas être accepté"))
	return (false);

if (!test("Simple récupération : 'Mathieu'", $type->get() === 'mathieu', "Simple récupération"))
	return (false);

if (!test("Test d'erreur : null", $type->set(null) === false, "Set ne fonctionne pas"))
	return (false);

if (!test("Test d'erreur : ''", $type->set('') === false, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : 'Mathieu'", $type->get() === 'mathieu', "Simple récupération"))
	return (false);

if (!test("Simple assignation : ' \\t\\nab\\t\\n  '", $type->set(" \t\nab\t\n  ") === false, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple assignation : 'ab'", $type->set('ab') === false, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple assignation : 'abc'", $type->set('abc') === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : 'abc'", $type->get() === 'abc', "Simple récupération"))
	return (false);

return (true);
