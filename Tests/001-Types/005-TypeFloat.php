<?php

if (!test("Importation de la classe", class_exists("TypeFloat"), "La classe type ne semble pas exister"))
	return (false);

if (!test("Vérification de la validité de la classe methode verify()", TypeFloat::verify() === true, "Le type de donnée TypeFloat ne semble pas être valide"))
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

$type = new TypeFloat($table, ["column" => "dataTest"]);
if (!test("Instanciation de la clasee", $type instanceof Type, "Instanciation de la class"))
	return (false);

if (!test("Simple assignation : 78", $type->set(78) === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : 78", $type->get() === 78, "Simple récupération"))
	return (false);

if (!test("Simple assignation : 0", $type->set(0) === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : 0", $type->get() === 0, "Simple récupération"))
	return (false);

if (!test("Simple assignation : -42", $type->set(-42) === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : -42", $type->get() === -42, "Simple récupération"))
	return (false);

if (!test("Simple assignation : 42", $type->set(42) === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : 42", $type->get() === 42, "Simple récupération"))
	return (false);

if (!test("Simple assignation : 0.5", $type->set(0.5) === true, "0.5 devrait être une valeur valide"))
	return (false);

if (!test("Simple récupération : 0.5", $type->get() === 0.5, "Simple récupération"))
	return (false);

if (!test("Simple assignation : -42-42", $type->set(-42.42) === true, "0.5 devrait être une valeur valide"))
	return (false);

if (!test("Simple récupération : -42.42", $type->get() === -42.42, "Simple récupération"))
	return (false);

return (true);
