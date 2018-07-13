<?php

if (!test("Importation de la classe", class_exists("TypeEncryptedCivilite"), "La classe type ne semble pas exister"))
	return (false);

if (!test("Vérification de la validité de la classe methode verify()", TypeEncryptedCivilite::verify() === true, "Le type de donnée TypeEncryptedCivilite ne semble pas être valide"))
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

$type = new TypeEncryptedCivilite($table, ["column" => "dataTest"]);
if (!test("Instanciation de la clasee", $type instanceof Type, "Instanciation de la class"))
	return (false);


if (!test("Simple assignation : 'Monsieur'", $type->set("Monsieur") === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : 'Monsieur'", $type->get() === "Monsieur\n", "Get ne fonctionne pas"))
	return (false);

if (!test("Simple assignation : 'Madame'", $type->set("Madame") === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : 'Madame'", $type->get() === "Madame\n", "Get ne fonctionne pas"))
	return (false);

if (!test("Simple assignation : 'mOnSiEuR'", $type->set("mOnSiEuR") === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : 'Monsieur'", $type->get() === "Monsieur\n", "Get ne fonctionne pas"))
	return (false);

if (!test("Simple assignation : 'mmE'", $type->set("mmE") === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : 'Madame'", $type->get() === "Madame\n", "Get ne fonctionne pas"))
	return (false);

if (!test("Simple assignation : 'MR'", $type->set("MR") === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : 'Monsieur'", $type->get() === "Monsieur\n", "Get ne fonctionne pas"))
	return (false);

if (!test("Simple assignation : ' \\n \\t Madame \\t \\n '", $type->set(" \n \t Madame \t \n ") === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : 'Madame'", $type->get() === "Madame\n", "Get ne fonctionne pas"))
	return (false);

if (!test("Test d'erreur : 'Mon'", $type->set("Mon") === false, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : 'Madame'", $type->get() === "Madame\n", "Get ne fonctionne pas"))
	return (false);

if (!test("Simple récupération : Vérification cryptage", $type->getRawValue() === ft_crypt_information("Madame\n"), "Get ne fonctionne pas"))
	return (false);

return (true);
