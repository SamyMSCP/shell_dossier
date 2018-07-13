<?php

if (!test("Importation de la classe", class_exists("TypePhone"), "La classe type ne semble pas exister"))
	return (false);

if (!test("Vérification de la validité de la classe methode verify()", TypePhone::verify() === true, "Le type de donnée TypePhone ne semble pas être valide"))
	return (false);

if (!class_exists("TotoPhone"))
{
	class TotoPhone extends Table2 {

		protected static		$_dataAccess = [
			"num" => [
				"get" => [ ACCESS_SERVER, ACCESS_OWNER ],
				"set" => [ ACCESS_SERVER, ACCESS_OWNER ]
			],
			"indicatif" => [
				"get" => [ ACCESS_SERVER, ACCESS_OWNER ],
				"set" => [ ACCESS_SERVER, ACCESS_OWNER ]
			]
		];
		public $num  = null;
		public $indicatif  = null;
	}
}

$table = new TotoPhone();

$type = new TypePhone($table, [
	"column" => [
		"num" => "num",
		"indicatif" => "indicatif"
	]
]);

if (!test("Instanciation de la clasee", $type instanceof TypeMulti, "Instanciation de la class"))
	return (false);

if (!test("Simple assignation du numéro [\"num\"=> \"0672546690\", \"indicatif\" => \"FR\"]", $type->set(["num"=> "0672546690", "indicatif" => "FR"]) === true, "Set ne fonctionne pas"))
	return (false);

if (!test("Simple récupération [\"num\"=> \"0672546690\", \"indicatif\" => \"FR\"]", $type->get() == ["num"=> "0672546690", "indicatif" => "FR"], "Simple récupération"))
	return (false);

if (!test("insertion d'une valeur fausse ['num' => 'toto']", $type->set(['num' => "toto"]) === false, "Set ne fonctionne pas"))
	return (false);

if (!test("insertion d'une valeur okay ['num' => '0672546893']", $type->set(['num' => "0672546893"]) === true, "Set ne fonctionne pas"))
	return (false);

if (!test("insertion d'une valeur okay ['indicatif' => 'BE']", $type->set(['indicatif' => "BE"]) === false, "Set ne fonctionne pas"))
	return (false);

if (!test("insertion d'une valeur format international un peu bizzare ['num' => '  + 336 72 54 68   93 ']", $type->set(['num' => "  + 336 72 54 68   93 "]) === true, "Set ne fonctionne pas"))
	return (false);

if (!test("insertion d'un numéro presque juste mais faux", $type->set(['num' => "078879906"]) === false, "Set ne fonctionne pas"))
	return (false);

if (!test("insertion d'une clef qui n'existe pas", $type->set(['nm' => "8   93 "]) === true, "Set ne fonctionne pas"))
	return (false);

return (true);
