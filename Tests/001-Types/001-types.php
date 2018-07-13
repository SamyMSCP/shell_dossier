<?php

if (!test("Importation de la classe", class_exists("Type"), "La classe Type ne semble pas exister"))
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

$type = new Type($table, ["column" => "dataTest"]);
if (!test("Instanciation de la clasee", $type instanceof Type, "Instanciation de la class"))
	return (false);

$type->set(42);
if (!test("Simple assignation et récupération", $type->get() === 42, "Simple assignation/récupération"))
	return (false);

if (!test("Vérification si la méthodes readComponent existe", method_exists($type, "readComponent"), "La méthode showComponent n'existe pas"))
	return (false);

if (!test("Vérification si la méthodes editComponent existe", method_exists($type, "editComponent"), "La méthode editComponent n'existe pas"))
	return (false);

return (true);
