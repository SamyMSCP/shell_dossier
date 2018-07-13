<?php

if (!test("Importation de la classe", class_exists("TypeMulti"), "La classe TypeMulti ne semble pas exister"))
	return (false);

if (!class_exists("TotoMulti"))
{
	class TotoMulti extends Table2 {
		protected static		$_dataAccess = [
			"nom" => [ 
				"get" => [ ACCESS_SERVER, ACCESS_OWNER ],
				"set" => [ ACCESS_SERVER, ACCESS_OWNER ]
			],
			"prenom" => [ 
				"get" => [ ACCESS_SERVER, ACCESS_OWNER ],
				"set" => [ ACCESS_SERVER, ACCESS_OWNER ]
			],
			"id_phs" => [ 
				"get" => [ ACCESS_SERVER, ACCESS_OWNER ],
				"set" => [ ACCESS_SERVER, ACCESS_OWNER ]
			]
		];
		public $dataTest = 7850;
	}
}

$table = new TotoMulti();

$config = [
	"column" => [
		"testInt" => "data1",
		"testString" => "data2",
		"testString2" => "data3"
	]
];

$type = new TypeMulti($table, $config);


if (!test("Instanciation de la clasee", $type instanceof TypeMulti, "Instanciation de la class"))
	return (false);

if (!isProd())
{
	if (!test("test de checkDb avant que la Db ne soit pretes", !$type->checkDb('mscpi_db', 'PERSONNE PHYSIQUE', $config), "Les colonnes ne devraient pas encore exister"))
		return (false);

	if (!test("test de setToDb", $type->setToDb('mscpi_db', 'PERSONNE PHYSIQUE', $config), "Ajout des colonnes à la table de test"))
		return (false);

	if (!test("test de checkDb", $type->checkDb('mscpi_db', 'PERSONNE PHYSIQUE', $config), "Methode pour checker que les colonnes en db sont bien existantes"))
		return (false);

	$type->removeColumns('mscpi_db', 'PERSONNE PHYSIQUE', $config);
}

return (true);
