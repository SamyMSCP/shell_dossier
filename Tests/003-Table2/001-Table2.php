<?php

// Préparation pour le test

if (!test("Importation de la classe", class_exists("Table2"), "La classe Table2 ne semble pas exister"))
	return (false);

$table2 = new Table2([]);
if (!test("Instanciation de la clasee", $table2 instanceof Table2, "Instanciation de la class"))
	return (false);

class testTable1 Extends Table2 {
	protected static		$_primary_key = "id";
	protected static		$_dataTypes = [];
	public function __construct() {}
};

class testTable2 Extends Table2 {
	protected static		$_name = "tableTest";
	protected static		$_dataTypes = [];
	public function __construct() {}
};

class testTable3 Extends Table2 {
	protected static		$_name = "tableTest";
	protected static		$_primary_key = "id";
	protected static		$_dataTypes = "coucou";
	public function __construct() {}
};

class TestTable4 Extends Table2 {
	protected static		$_name = "tableTest";
	protected static		$_primary_key = "id";
	protected static		$_dataTypes = [
		[
			"type" => "TypeInt",
			"config" => [
				"column" => "simpleInt"
			]
		],
		[
			"type" => "TypeString",
			"config" => [
				"column" => "simpleString"
			]
		]
	];
	public function __construct() {}
};

$test1 = new TestTable1([]);


//	- Vérifier que la classe  est correcte
if (!test("Instanciation d'un enfant de Table2", $test1 instanceof TestTable1, "Instanciation de la class"))
	return (false);

if (!test("check methode test1->verifyClass() => false", TestTable1::verifyClass() === false, "La classe ne devrait pas être valide"))
	return (false);

if (!test("check methode test2->verifyClass() => false", TestTable2::verifyClass() === false, "La classe ne devrait pas être valide"))
	return (false);

if (!test("check methode test3->verifyClass() => false", TestTable3::verifyClass() === false, "La classe ne devrait pas être valide"))
	return (false);

if (!test("check methode test4->verifyClass() => true", TestTable4::verifyClass() === true, "La classe devrait être valide"))
	return (false);

// Au cas ou le test précédent à foiré
TestTable4::dropTable();

if (!test("check methode test4->verifyTable() => false (La table n'existe pas encore)", TestTable4::verifyTable() === false, "La table ne devrait pas exister"))
	return (false);

if (!test("check methode test4->createTable() => true", TestTable4::createTable() === true, "La creation de la table ne semble pas fonctionner"))
	return (false);

if (!test("check methode test4->createTable() => false", TestTable4::createTable() === false, "La table existe deja, la methode devrait retourner false"))
	return (false);

if (!test("check methode test4->verifyTable() => true", TestTable4::verifyTable() === true, "La table devrait éxister"))
	return (false);


//	La classe table2 doit permettre de :


//	- Insérer une donnée;
//	- Récupérer des données (par id, par liste de critères)
//	- Persister des données
//	- Supprimmer des données
//	- Gérer des types de données sur plusieures colonnes
//	- Gérer des jointures simples (OneToOne, OneToMany, ManyToMany).
//	- Gérer des jointures complèxes (Comme pour le système de documents ou bénéficiare).

//	- Vérifier les droits de lecture, d'insertion, de modification et de suppression














//$test4->desc();

if (!test("check methode test4->dropTable() => true", TestTable4::dropTable() === true, "La suppression ne semble pas fonctionner"))
	return (false);

if (!test("check methode test4->dropTable() => false", TestTable4::dropTable() === false, "La table n'existe plus, la methode devrait retourner false"))
	return (false);

if (!test("check methode test4->verifyTable() => false (Elle a été supprimée)", TestTable4::verifyTable() === false, "La table ne devrait pas exister"))
	return (false);



return (true);
