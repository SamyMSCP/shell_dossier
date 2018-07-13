<?php

if (!test("Importation de la classe", class_exists("StoreGenerator"), "La classe TypeMulti ne semble pas exister"))
	return (false);

class TestStore extends Table2 {
	protected static		$_storeName = "test_store";
	protected static		$_name = "test_store";
	protected static		$_primary_key = "id";
	public static			$_access = [ ACCESS_SERVER, ACCESS_OWNER ];
	protected static		$_dataTypes = [
		[
			"type" => "TypeUint",
			"config" => [
				"column" => "revenu_professionnels",
			],
			"getter" => "getRevenuProfessionnels",
			"getAccess" => [ ACCESS_SERVER, ACCESS_OWNER ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_OWNER ]
		],
		[
			"type" => "TypeUint",
			"config" => [
				"column" => "revenu_immobilliers",
			],
			"getter" => "getRevenuImmobilliers",
			"getAccess" => [ ACCESS_SERVER, ACCESS_OWNER ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_OWNER ]
		]
	];

	protected static		$_dataAccess = [
		"revenu_professionnels" => [
			"get" => [ ACCESS_SERVER, ACCESS_OWNER ],
			"set" => [ ACCESS_SERVER, ACCESS_OWNER ],
			"defaultValue" => 0
		],
		"revenu_immobilliers" => [
			"get" => [ ACCESS_SERVER, ACCESS_OWNER ],
			"set" => [ ACCESS_SERVER, ACCESS_OWNER ],
			"defaultValue" => 0
		],
	];

	public function __construct() {
		parent::__construct();
	}

	public function __destruct() {
	
	}
};

TestStore::dropTable();

if (!test("Préparation pour les tests (Création de la table)", TestStore::createTable(), "La table test_store n'a pas pu être inséré, les tests ne peuvent se poursuivre"))
	return (false);

$rt = true;
for ($i = 1; $i < 11; $i++)
{
	$tmp = new TestStore();
	$tmp->getRevenuProfessionnels()->set($i);
	$tmp->getRevenuImmobilliers()->set($i * 10);
	if (!$tmp->commit())
	{
		$rt = false;
		break ;
	}
}
if (!test("Préparation pour les tests (Insertion de donnée de test)", $rt, "Les données de test n'ont pas pu etre insérées"))
	return (false);

$datas = TestStore::getAll();

if (!test("Préparation pour les tests (Vérification récupération des données)", count($datas) == 10, "Les données de test n'ont pas pu etre récupérées"))
	return (false);

$store = new StoreGenerator();

if (!test("Instanciation d'un nouveau store", $store instanceof StoreGenerator, "Ca marche pas"))
	return (false);

if (!test("addToState() avec un seul élement", $store->addToState($datas[0]), "Ca marche pas"))
	return (false);

if (!test("getState()", json_encode($store->getState()) == '{"global":{"user":[]},"datas":{"TestStore":{"1":{"id":1,"revenu_professionnels":{"value":1,"canGet":true,"canSet":true},"revenu_immobilliers":{"value":10,"canGet":true,"canSet":true}}}}}', "Ca marche pas"))
	return (false);

if (!test("addToState() avec un tous les élements", $store->addToState($datas), "Ca marche pas"))
	return (false);

if (!test("getState()", json_encode($store->getState()) == '{"global":{"user":[]},"datas":{"TestStore":{"1":{"id":1,"revenu_professionnels":{"value":1,"canGet":true,"canSet":true},"revenu_immobilliers":{"value":10,"canGet":true,"canSet":true}},"2":{"id":2,"revenu_professionnels":{"value":2,"canGet":true,"canSet":true},"revenu_immobilliers":{"value":20,"canGet":true,"canSet":true}},"3":{"id":3,"revenu_professionnels":{"value":3,"canGet":true,"canSet":true},"revenu_immobilliers":{"value":30,"canGet":true,"canSet":true}},"4":{"id":4,"revenu_professionnels":{"value":4,"canGet":true,"canSet":true},"revenu_immobilliers":{"value":40,"canGet":true,"canSet":true}},"5":{"id":5,"revenu_professionnels":{"value":5,"canGet":true,"canSet":true},"revenu_immobilliers":{"value":50,"canGet":true,"canSet":true}},"6":{"id":6,"revenu_professionnels":{"value":6,"canGet":true,"canSet":true},"revenu_immobilliers":{"value":60,"canGet":true,"canSet":true}},"7":{"id":7,"revenu_professionnels":{"value":7,"canGet":true,"canSet":true},"revenu_immobilliers":{"value":70,"canGet":true,"canSet":true}},"8":{"id":8,"revenu_professionnels":{"value":8,"canGet":true,"canSet":true},"revenu_immobilliers":{"value":80,"canGet":true,"canSet":true}},"9":{"id":9,"revenu_professionnels":{"value":9,"canGet":true,"canSet":true},"revenu_immobilliers":{"value":90,"canGet":true,"canSet":true}},"10":{"id":10,"revenu_professionnels":{"value":10,"canGet":true,"canSet":true},"revenu_immobilliers":{"value":100,"canGet":true,"canSet":true}}}}}', "Ca marche pas"))
	return (false);








return (true);
