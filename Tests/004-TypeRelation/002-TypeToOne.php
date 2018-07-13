<?php
if (!test("Importation de la classe", class_exists("TypeToOne"), "La classe TypeToOne ne semble pas exister"))
	return (false);


if (!test("Vérification de la validité de la classe methode verify()", TypeToOne::verify() === true, "Le type de donnée TypeToOne ne semble pas être valide"))
	return (false);

if (!class_exists("ClassToOneRelationA"))
{
	class ClassToOneRelationA extends Table2 {

		protected static		$_name = "tableTestA";
		protected static		$_primary_key = "id";
		protected static		$_access = [ ACCESS_SERVER ];

		protected static		$_dataAccess = [
			"id_ClassToOneRelationB" => [
				"get" => [ ACCESS_SERVER ],
				"set" => [ ACCESS_SERVER ]
			]
			,
			"simpleString" => [
				"get" => [ ACCESS_SERVER ],
				"set" => [ ACCESS_SERVER ]
			]
		];
		public  static		$_dataTypes = [
			[
				"type" => "TypeToOne",
				"config" => [
					"class" => "ClassToOneRelationB",
					"column" => "id_ClassToOneRelationB",
					"canEmpty" => false
				],
				"getAccess" => [ ACCESS_SERVER],
				"getter" => "getB",
				"setter" => "setB"
			]
			,
			[
				"type" => "TypeString",
				"config" => [
					"column" => "simpleString",
					"canEmpty" => true
				],
				"getAccess" => [ ACCESS_SERVER],
				"getter" => "getString",
				"setter" => "setString"
			]
		];
	}
}

if (!class_exists("ClassToOneRelationB"))
{
	class ClassToOneRelationB extends Table2 {
		protected static		$_name = "tableTestB";
		protected static		$_primary_key = "id";
		protected static		$_access = [ ACCESS_SERVER ];
	}
}

if (ClassToOneRelationA::tableExist())
	ClassToOneRelationA::dropTable();
if (ClassToOneRelationB::tableExist())
	ClassToOneRelationB::dropTable();

$tableA = new ClassToOneRelationA();

$config = [
	"class" => "ClassToOneRelationB",
	"column" => "id_ClassToOneRelationB"
];

$type = new TypeToOne($tableA, $config);

if (!test("Instanciation de la classe", $type instanceof TypeRelation, "Instanciation de la class"))
	return (false);

if (!test("checkDb error A", !$type->checkDb("mscpi_db", "tableTestA", $config), "Instanciation de la class"))
	return (false);

if (!test("Préparation de la table B", ClassToOneRelationB::createTable(), "La table de test B n'a pas pu être crée"))
	;//return (false);

if (!test("checkDb error A", !$type->checkDb("mscpi_db", "tableTestA", $config), "Instanciation de la class"))
	return (false);

if (!test("Préparation de la table A", ClassToOneRelationA::createTable(), "La table de test A n'a pas pu être crée"))
	return (false);

if (!test("checkDb de la class A", $type->checkDb("mscpi_db", "tableTestA", $config), "Instanciation de la class"))
	return (false);

$bList = [];
for ($i = 0; $i < 10; $i ++)
{
	$tmpB = new ClassToOneRelationB();
	$tmpB->commit();
	$bList[] = $tmpB;
}
if (!test("Insertion de plusieurs élements dans B", count($bList) == 10, "Il doit y avoir un problème avec cette classe"))
	return (false);

$recup = ClassToOneRelationB::getAll();

if (!test("Récupération de tous les élements dans B", count($recup) == 10, "Il doit y avoir un problème avec l'insertion ou le commit de cette class"))
	return (false);

if (!test("Instanciation d'un Table2 qui contient une relation ", ($tmp = new ClassToOneRelationA()) instanceof ClassToOneRelationA, "Ca ne marche pas"))
	return (false);

if (!test("tentative de commit KO", $tmp->commit() == false, "Ca ne marche pas"))
	return (false);

ClassToOneRelationA::$_dataTypes[0]['config']['canEmpty'] = true;
$tmp->getB()->forceConfig(ClassToOneRelationA::$_dataTypes[0]['config']);

if (!test("tentative de commit OK avec canEmpty", $tmp->commit() == true, "Ca ne marche pas"))
	return (false);

ClassToOneRelationA::$_dataTypes[0]['config']['canEmpty'] = false;
$tmp->getB()->forceConfig(ClassToOneRelationA::$_dataTypes[0]['config']);

if (!test("Linking d'un liaison vers B", $tmp->getB()->set($recup[2]), "Ca ne marche pas"))
	return (false);

if (!test("Test du getter", $tmp->getB()->get()->getId() == $recup[2]->getId(), "Ca ne marche pas"))
	return (false);

ClassToOneRelationA::dropTable();
ClassToOneRelationB::dropTable();

return (true);
