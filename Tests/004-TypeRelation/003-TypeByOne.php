<?php
if (!test("Importation de la classe", class_exists("TypeByOne"), "La classe TypeByOne ne semble pas exister"))
	return (false);


if (!test("Vérification de la validité de la classe methode verify()", TypeByOne::verify() === true, "Le type de donnée TypeByOne ne semble pas être valide"))
	return (false);

if (!test("Vérification de l'inexistance de la classe B", !class_exists("ClassByOneRelationB"), "ClassByOneRelationB ne devrait pas encore être définit"))
	return (false);

if (!test("Vérification de l'inexistance de la classe A", !class_exists("ClassByOneRelationA"), "ClassByOneRelationA ne devrait pas encore être définit"))
	return (false);

if (!class_exists("ClassByOneRelationA"))
{
	class ClassByOneRelationA extends Table2 {

		protected static		$_name = "tableTestByA";
		protected static		$_primary_key = "id";
		protected static		$_access = [ ACCESS_SERVER ];

		protected static		$_dataAccess = [
			"id_ClassByOneRelationB" => [
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
					"class" => "ClassByOneRelationB",
					"column" => "id_ClassByOneRelationB",
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

if (!class_exists("ClassByOneRelationB"))
{
	class ClassByOneRelationB extends Table2 {
		protected static		$_name = "tableTestByB";
		protected static		$_primary_key = "id";
		protected static		$_access = [ ACCESS_SERVER ];

		public  static		$_dataTypes = [
			[
				"type" => "TypeByOne",
				"config" => [
					"class" => "ClassByOneRelationA",
					"link" => "id_ClassByOneRelationB",
					"canEmpty" => false
				],
				"getAccess" => [ ACCESS_SERVER],
				"getter" => "getA",
				"setter" => "setA"
			]
		];
	}
}

if (ClassByOneRelationA::tableExist())
	ClassByOneRelationA::dropTable();
if (ClassByOneRelationB::tableExist())
	ClassByOneRelationB::dropTable();

$tableA = new ClassByOneRelationA();

$config = [
	"class" => "ClassByOneRelationA"
];

$type = new TypeByOne($tableA, $config);

if (!test("Instanciation de la classe", $type instanceof TypeRelation, "Instanciation de la class"))
	return (false);

if (!test("Vérification de l'existance de la classe B", class_exists("ClassByOneRelationB"), "Les test ne peuvent se poursuivre sans la class  ClassByOneRelationB"))
	return (false);

if (!test("Vérification de l'existance de la classe A", class_exists("ClassByOneRelationA"), "Les test ne peuvent se poursuivre sans la class  ClassByOneRelationA"))
	return (false);

if (!test("Vérification de l'inexistance de la table B", !ClassByOneRelationB::verifyTable(), "La table de ClassByOneRelationB ne devrait encore être existante"))
	return (false);

if (!test("Vérification de l'inexistance de la table A", !ClassByOneRelationA::verifyTable(), "La table de ClassByOneRelationA ne devrait encore être existante"))
	return (false);

if (!test("test de création de la table B", ClassByOneRelationB::createTable(), "La création de le table de la classe ClassByOneRelationB ne semble pas fonctionner"))
	return (false);

if (!test("test de création de la table A", ClassByOneRelationA::createTable(), "La création de le table de la classe ClassByOneRelationA ne semble pas fonctionner"))
		return (false);

if (!test("Vérification de l'existance de la table B", ClassByOneRelationB::verifyTable(), "La table de ClassByOneRelationB devrait être existante"))
	return (false);

if (!test("Vérification de l'existance de la table A", ClassByOneRelationA::verifyTable(), "La table de ClassByOneRelationA devrait être existante"))
	return (false);

$bList = [];
for ($i = 0; $i < 10; $i ++)
{
	$tmpB = new ClassByOneRelationB();
	$tmpB->commit();
	$bList[] = $tmpB;
}
if (!test("Insertion de plusieurs élements dans B", count($bList) == 10, "Il doit y avoir un problème avec cette classe"))
	return (false);

$aList = [];
for ($i = 9;$i >= 0; $i--)
{
	$tmpA = new ClassByOneRelationA();
	$tmpA->getB()->set($bList[5]);
	$tmpA->commit();
	$aList[] = $tmpA;
}

$recup = ClassByOneRelationB::getAll();

$rt = true;
foreach($recup as $k => $b)
{
	if ($k == 5 && count($b->getA()->get()) != 10)
		$rt = false;
	if ($k != 5 && count($b->getA()->get()) != 0)
		$rt = false;
}

if (!test("Test de récupération des élements pointant", $k, "Les liens ne semblent pas être bon"))
	return (false);

// Récupération des données pointant vers cette table.

//ClassByOneRelationA::dropTable();
//ClassByOneRelationB::dropTable();

return (true);
