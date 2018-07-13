<?php

if (!test("Importation de la classe", class_exists("TypeAdresse"), "La classe type ne semble pas exister"))
	return (false);

if (!test("Vérification de la validité de la classe methode verify()", TypeAdresse::verify() === true, "Le type de donnée TypeAdresse ne semble pas être valide"))
	return (false);

if (!class_exists("TotoAdresse"))
{
	class TotoAdresse extends Table2 {

		protected static		$_dataAccess = [
			"numeroRue" => [
				"get" => [ ACCESS_SERVER, ACCESS_OWNER ],
				"set" => [ ACCESS_SERVER, ACCESS_OWNER ]
			],
			"extension" => [
				"get" => [ ACCESS_SERVER, ACCESS_OWNER ],
				"set" => [ ACCESS_SERVER, ACCESS_OWNER ]
			],
			"type_voie" => [
				"get" => [ ACCESS_SERVER, ACCESS_OWNER ],
				"set" => [ ACCESS_SERVER, ACCESS_OWNER ]
			],
			"voie" => [
				"get" => [ ACCESS_SERVER, ACCESS_OWNER ],
				"set" => [ ACCESS_SERVER, ACCESS_OWNER ],
			],
			"complementAdresse" => [
				"get" => [ ACCESS_SERVER, ACCESS_OWNER ],
				"set" => [ ACCESS_SERVER, ACCESS_OWNER ]
			],
			"codePostal" => [
				"get" => [ ACCESS_SERVER, ACCESS_OWNER ],
				"set" => [ ACCESS_SERVER, ACCESS_OWNER ]
			],
			"ville" => [
				"get" => [ ACCESS_SERVER, ACCESS_OWNER ],
				"set" => [ ACCESS_SERVER, ACCESS_OWNER ]
			],
			"pays" => [
				"get" => [ ACCESS_SERVER, ACCESS_OWNER ],
				"set" => [ ACCESS_SERVER, ACCESS_OWNER ]
			],
		];
		public $num  = null;
		public $indicatif  = null;
	}
}

$table = new TotoAdresse();

$type = new TypeAdresse($table, [
	"column" => [
		"numeroRue" => "numeroRue",
		"extension" => "extension",
		"type_voie" => "type_voie",
		"voie" => "voie",
		"complementAdresse" => "complementAdresse",
		"codePostal" => "codePostal",
		"ville" => "ville",
		"pays" => "pays"
	]
]);

$adresseValide1 = [
	"numeroRue"=> 12,
	"type_voie" => "rue",
	"voie" => "isabelle eberhardt",
	"extension" => "",
	"complementAdresse" => "",
	"codePostal" => "67117",
	"ville" => "ittenheim",
	"pays" => "France"
];

if (!test("Instanciation de la clasee", $type instanceof TypeMulti, "Instanciation de la class"))
	return (false);


// Test d'une adresse valide
if (!test("Simple assignation de l'adresse ", $type->set($adresseValide1) === true, "Set ne fonctionne pas" . json_encode($adresseValide1)))
	return (false);

$adresseValide1['pays'] = "france";
if (!test("Test de la casse pour le pays ", $type->set($adresseValide1) === true, "Set du pays ne devrait pas être sensible à la casse !" . json_encode($adresseValide1)))
	return (false);

$adresseValide1['pays'] = "FRANCE";
if (!test("Test de la casse pour le pays ", $type->set($adresseValide1) === true, "Set du pays ne devrait pas être sensible à la casse !" . json_encode($adresseValide1)))
	return (false);

$adresseValide1['pays'] = "FRAN";
if (!test("Test d'un pays inexistant ", $type->set($adresseValide1) === false, "Le pays FRA n'existe pas !!!" . json_encode($adresseValide1)))
	return (false);

if (!test("Test de récupération du pays 'France' ", $type->get()['pays'] === "France", "Le pays FRA n'existe pas !!!" . json_encode($adresseValide1)))
	return (false);

$adresseValide1['pays'] = "Chine";
if (!test("Test d'un pay étranger 'Chine'", $type->set($adresseValide1) === true, "Set du pays ne devrait pas être sensible à la casse !" . json_encode($adresseValide1)))
	return (false);

if (!test("Test de récupération du pays 'Chine' ", $type->get()['pays'] === "Chine", "Le pays devrait être Chine" . json_encode($adresseValide1)))
	return (false);

$adresseValide1['pays'] = "France";
if (!test("Remettre pays France 'France'", $type->set($adresseValide1) === true, "Set du pays ne devrait pas être sensible à la casse !" . json_encode($adresseValide1)))
	return (false);

$adresseValide1['ville'] = "strasbourg";
if (!test("Ville & code postal incohérent", $type->set($adresseValide1) === false, "L'ensemble Ville code postal devraient être invalides" . json_encode($adresseValide1)))
	return (false);

$adresseValide1['codePostal'] = "67200";
if (!test("Ville & code postal okay", $type->set($adresseValide1) === true, "L'ensemble Ville code postal devraient être valides" . json_encode($adresseValide1)))
	return (false);

$adresseValide1['type_voie'] = "entaille";
if (!test("Type de voie iexistant", $type->set($adresseValide1) === false, "Ce type de voie n'existe pas" . json_encode($adresseValide1)))
	return (false);

$adresseValide1['type_voie'] = "allée";
if (!test("Type de voie okay 'allée'", $type->set($adresseValide1) === true, "le type de voie 'allée' est valide" . json_encode($adresseValide1)))
	return (false);

$adresseValide1['pays'] = "chine";
if (!test("Test d'un pay étranger 'Chine'", $type->set($adresseValide1) === true, "Set de pays etrangers BUG !" . json_encode($adresseValide1)))
	return (false);

if (!test("Test de récupération du pays 'Chine' ", $type->get()['pays'] === "Chine", "Le pays devrait être Chine" . json_encode($adresseValide1)))
	return (false);

$adresseValide1['ville'] = "nimp";
if (!test("Ville & code postal incohérent", $type->set($adresseValide1) === true, "L'ensemble Ville code postal ne devraient pas être controlé hors france" . json_encode($adresseValide1)))
	return (false);

$adresseValide1['codePostal'] = "3209";
if (!test("Ville & code postal okay", $type->set($adresseValide1) === true, "L'ensemble Ville code postal ne devraient pas être controlé hors france" . json_encode($adresseValide1)))
	return (false);

return (true);
