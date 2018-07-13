<?php

if (!test("Importation de la classe", class_exists("TypeMail"), "La classe type ne semble pas exister"))
	return (false);

if (!test("Vérification de la validité de la classe methode verify()", TypeMail::verify() === true, "Le type de donnée TypeMail ne semble pas être valide"))
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

$type = new TypeMail($table, ["column" => "dataTest"]);
if (!test("Instanciation de la clasee", $type instanceof Type, "Instanciation de la class"))
	return (false);

if (!test("Simple assignation : froehly.mathieu@gmail.com", $type->set("froehly.mathieu@gmail.com") === true, "Un mail valide n'a pas été considéré comme valide"))
	return (false);

if (!test("Simple récupération : froehly.mathieu@gmail.com", $type->get() === "froehly.mathieu@gmail.com", "Simple récupération"))
	return (false);

if (!test("Test d'erreur : froehly.mathieu@@gmail.com", $type->set("froehly.mathieu@@gmail.com") === false, "Un mail invalide a été considéré comme valide"))
	return (false);

if (!test("Simple récupération : froehly.mathieu@gmail.com", $type->get() === "froehly.mathieu@gmail.com", "Simple récupération"))
	return (false);

if (!test("Test d'erreur : froehly.mathieu@gmail.", $type->set("froehly.mathieu@gmail.") === false, "Un mail invalide a été considéré comme valide"))
	return (false);

if (!test("Simple récupération : froehly.mathieu@gmail.com", $type->get() === "froehly.mathieu@gmail.com", "Simple récupération"))
	return (false);

return (true);
