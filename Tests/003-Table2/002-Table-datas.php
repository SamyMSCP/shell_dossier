<?php
/*      __  __        _  _  _                          */
/*     |  \/  |  ___ (_)| || |  ___  _   _  _ __  ___  */
/*     | |\/| | / _ \| || || | / _ \| | | || '__|/ _ \ */
/*     | |  | ||  __/| || || ||  __/| |_| || |  |  __/ */
/*     |_|  |_| \___||_||_||_| \___| \__,_||_|   \___| */
/*                        _                            */
/*      ___   ___  _ __  (_)    ___  ___   _ __ ___    */
/*     / __| / __|| '_ \ | |   / __|/ _ \ | '_ ` _ \   */
/*     \__ \| (__ | |_) || | _| (__| (_) || | | | | |  */
/*     |___/ \___|| .__/ |_|(_)\___|\___/ |_| |_| |_|  */
/*                |_|                                  */

class TestTableData Extends Table2 {
	protected static		$_name = "tableTest";
	protected static		$_primary_key = "id";
	protected static		$_access = [ ACCESS_SERVER ];
	protected static		$_dataAccess = [
		"simpleInt" => [
			"get" => [ ACCESS_SERVER ],
			"set" => [ ACCESS_SERVER ],
			"defaultValue" => 64 // Les défault values doivent être au format de la db
		],
		"simpleString" => [
			"get" => [ ACCESS_SERVER ],
			"set" => [ ACCESS_SERVER ],
			"defaultValue" => "SimpleString"
		],
		"encryptedString" => [
			"get" => [ ACCESS_SERVER ],
			"set" => [ ACCESS_SERVER ],
			"defaultValue" => "EncryptedString"
		],
		"simpleFloat" => [
			"get" => [ ACCESS_SERVER ],
			"set" => [ ACCESS_SERVER ],
			"defaultValue" => 42.42
		],
		"simpleMail" => [
			"get" => [ ACCESS_SERVER ],
			"set" => [ ACCESS_SERVER ]
		],
		"encryptedMail" => [
			"get" => [ ACCESS_SERVER ],
			"set" => [ ACCESS_SERVER ]
		],
		"phone" => [
			"get" => [ ACCESS_SERVER ],
			"set" => [ ACCESS_SERVER ]
		],
		"indicatif_test" => [
			"get" => [ ACCESS_SERVER ],
			"set" => [ ACCESS_SERVER ]
		],
	];
	protected static		$_dataTypes = [
		[
			"type" => "TypeInt",
			"config" => [
				"column" => "simpleInt"
			],
			"getAccess" => [ ACCESS_SERVER],
			"getter" => "getInt",
			"setter" => "setInt"
		],
		[
			"type" => "TypeString",
			"config" => [
				"column" => "simpleString"
			],
			"getAccess" => [ ACCESS_SERVER],
			"getter" => "getString",
			"setter" => "setString"
		],
		[
			"type" => "TypeEncryptedString",
			"config" => [
				"column" => "encryptedString"
			],
			"getAccess" => [ ACCESS_SERVER],
			"getter" => "getEncryptedString",
			"setter" => "setEncryptedString"
		],
		[
			"type" => "TypeFloat",
			"config" => [
				"column" => "simpleFloat"
			],
			"getAccess" => [ ACCESS_SERVER],
			"getter" => "getSimpleFloat",
			"setter" => "setSimpleFloat"
		],
		[
			"type" => "TypeMail",
			"config" => [
				"column" => "simpleMail"
			],
			"getAccess" => [ ACCESS_SERVER],
			"getter" => "getSimpleMail",
			"setter" => "setSimpleMail"
		],
		[
			"type" => "TypeEncryptedMail",
			"config" => [
				"column" => "encryptedMail"
			],
			"getAccess" => [ ACCESS_SERVER],
			"getter" => "getEncryptedMail",
			"setter" => "setEncryptedMail"
		],
		[
			"type" => "TypePhone",
			"config" => [
				"column" => [
					"num" => "phone",
					"indicatif" => "indicatif_test"
				]
			],
			"getAccess" => [ ACCESS_SERVER],
			"getter" => "getPhone",
			"setter" => "setPhone"
		],
	];
	public function __construct() {
		parent::__construct();
	}
};

$inst = new TestTableData();

function cryptMethods($val) {
	return (ft_crypt_information($val));
}

TestTableData::dropTable();
if (!test("Préparation de la db", TestTableData::createTable(), "La table n'a pas pu être crée"))
	return (false);

if (!test("Récupération instance TypeInt", $inst->getInt() instanceof TypeInt, "La récupération de l'instance TypeInt ne semble pas fonctionner"))
	return (false);

if (!test("Récupération de la donnée par default TypeInt", $inst->getInt()->get() === 64, "La valeur par default n'a pas été utilisée"))
	return (false);

if (!test("Affectation de valeur TypeInt", $inst->getInt()->set(42) === true, "L'affectation de valeur TypeInt ne semble pas fonctionner"))
	return (false);

if (!test("Récupération de valeur TypeInt", $inst->getInt()->get() === 42, "La récupération de valeur de TypeInt ne semble pas fonctionner"))
	return (false);

if (!test("Récupération instance TypeString", $inst->getString() instanceof TypeString, "La récupération de l'instance TypeString ne semble pas fonctionner"))
	return (false);

if (!test("Affectation de valeur TypeString", $inst->getString()->set("Mathieu") === true, "L'affectation de valeur TypeString ne semble pas fonctionner"))
	return (false);

if (!test("Récupération de valeur TypeString", $inst->getString()->get() === "Mathieu", "La récupération de valeur de TypeString ne semble pas fonctionner"))
	return (false);

if (!test("Récupération instance TypeEncryptedString", $inst->getEncryptedString() instanceof TypeEncryptedString, "La récupération de l'instance TypeEncryptedString ne semble pas fonctionner"))
	return (false);

if (!test("Affectation de valeur TypeEncryptedString", $inst->getEncryptedString()->set("Toto") === true, "L'affectation de valeur TypeEncryptedString ne semble pas fonctionner"))
	return (false);

if (!test("Récupération de valeur TypeEncryptedString", $inst->getEncryptedString()->get() === "Toto", "La récupération de valeur de TypeEncryptedString ne semble pas fonctionner"))
	return (false);

if (!test("Récupération instance TypeFloat", $inst->getSimpleFloat() instanceof TypeFloat, "La récupération de l'instance TypeFloat ne semble pas fonctionner"))
	return (false);

if (!test("Affectation de valeur TypeFloat 54", $inst->getSimpleFloat()->set(54) === true, "L'affectation de valeur TypeFloat ne semble pas fonctionner"))
	return (false);

if (!test("Récupération de valeur TypeFloat 54", $inst->getSimpleFloat()->get() === 54, "La récupération de valeur de TypeFloat ne semble pas fonctionner"))
	return (false);

if (!test("Affectation de valeur TypeFloat 54", $inst->getSimpleFloat()->set(54.42) === true, "L'affectation de valeur TypeFloat ne semble pas fonctionner"))
	return (false);

if (!test("Récupération de valeur TypeFloat 54.42", $inst->getSimpleFloat()->get() === 54.42, "La récupération de valeur de TypeFloat ne semble pas fonctionner"))
	return (false);

if (!test("Récupération instance TypePhone", $inst->getPhone() instanceof TypePhone, "La récupération de l'instance TypePhone ne semble pas fonctionner"))
	return (false);

if (!test("Test d'affectation de valeur TypePhone ['num' => '0672546690', 'indicatif' => 'FR']", $inst->getPhone()->set(['num' => "0672546690", "indicatif" => "FR"]) === true, "L'affectation de valeur TypePhone ne semble pas fonctionner"))
	return (false);

if (!test("Test de récupération de valeur", $inst->getPhone()->get() == ['num' => "0672546690", "indicatif" => "FR"], "La valeur récupérée devrait être ok"))
	return (false);

if (!test("Test d'erreur TypePhone ['num' => '02546690']", $inst->getPhone()->set(['num' => "02546690"]) === false, "L'affectation de valeur ne devrait pas fonctionner"))
	return (false);

if (!test("Test de récupération de valeur", $inst->getPhone()->get() == ['num' => "0672546690", "indicatif" => "FR"], "La valeur récupérée devrait être ok"))
	return (false);

if (!test("Test d'erreur TypePhone ['num' => '02546690', 'indicatif' => '']", $inst->getPhone()->set(['num' => "02546690", 'indicatif' => '']) === true, "Sans indicatif téléphonique, il ne devrait pas y avoir de controle"))
	return (false);

if (!test("Test d'erreur TypePhone ['num' => '0672546690', 'indicatif' => 'FR']", $inst->getPhone()->set(['num' => "0672546690", 'indicatif' => 'FR']) === true, "Sans indicatif téléphonique, il ne devrait pas y avoir de controles sur le numéro de téléphone"))
	return (false);


if (!test("Récupération instance TypeMail", $inst->getSimpleMail() instanceof TypeMail, "La récupération de l'instance TypeMail ne semble pas fonctionner"))
	return (false);

if (!test("Test d'erreur TypeMail 'Mathieu'", $inst->getSimpleMail()->set("Mathieu") === false, "L'affectation de valeur TypeMail ne semble pas fonctionner"))
	return (false);




if (!test("Test d'erreur la methode checkData", $inst->checkData() === false, "Les données ne sont pas bonnes mais checkData dit que si !"))
	return (false);

if (!test("Affectation de valeur TypeMail 'Froehly.Mathieu@Gmail.Com'", $inst->getSimpleMail()->set(" Froehly.Mathieu@Gmail.Com ") === true, "L'affectation de valeur TypeMail ne semble pas fonctionner"))
	return (false);

if (!test("Récupération de valeur TypeMail 'froehly.mathieu@gmail.com'", $inst->getSimpleMail()->get() === "froehly.mathieu@gmail.com", "La récupération de valeur de TypeMail ne semble pas fonctionner"))
	return (false);

if (!test("Récupération instance TypeEncryptedMail", $inst->getEncryptedMail() instanceof TypeEncryptedMail, "La récupération de l'instance TypeEncryptedMail ne semble pas fonctionner"))
	return (false);

if (!test("Test d'erreur TypeEncryptedMail 'Mathieu'", $inst->getEncryptedMail()->set("Mathieu") === false, "L'affectation de valeur TypeEncryptedMail ne semble pas fonctionner"))
	return (false);

if (!test("Affectation de valeur TypeEncryptedMail 'heuk67@Gmail.Com'", $inst->getEncryptedMail()->set(" HeUk67@GmAil.com ") === true, "L'affectation de valeur TypeEncryptedMail ne semble pas fonctionner"))
	return (false);

if (!test("Récupération de valeur TypeEncryptedMail 'heuk67@gmail.com'", $inst->getEncryptedMail()->get() === "heuk67@gmail.com", "La récupération de valeur de TypeEncryptedMail ne semble pas fonctionner"))
	return (false);

if (!test("TestCryptage 'heuk67@gmail.com'", $inst->getEncryptedMail()->getRawValue() === cryptMethods("heuk67@gmail.com"), "L'encryption ne semble pas faire son travail"))
	return (false);


if (
		!test("Test des attributs de la classe"
	,
		$inst->simpleInt === 42 &&
		$inst->simpleString === "Mathieu" &&
		$inst->encryptedString === cryptMethods("Toto") &&
		$inst->simpleFloat === 54.42 &&
		$inst->simpleMail === "froehly.mathieu@gmail.com" &&
		$inst->encryptedMail === cryptMethods("heuk67@gmail.com") &&
		$inst->phone === "0672546690" &&
		$inst->indicatif_test === "FR"
	,
		"Les attributs de la class n'ont pas les valeurs attendues")
)
	return (false);

if (!test("Test de la methode checkData", $inst->checkData() === true, "La classe devrait être okay"))
	return (false);

echo "\t\t==>Force error Phone \n";
$inst->phone = "123";

if (!test("Test d'erreur la methode checkData", $inst->checkData() === false, "Les données ne sont pas bonnes mais checkData dit que si !"))
	return (false);

echo "\t\t==> Remise en etat\n";
$inst->phone = "0672546690";

if (!test("Test de la methode checkData", $inst->checkData() === true, "La classe devrait être okay"))
	return (false);

$inst->commit();
$recup = TestTableData::getById(1);

if (
		!test("Test des attributs de la classe Après la sauvegerde"
	,
		$recup->simpleInt === 42  &&
		$recup->simpleString === "Mathieu" &&
		$recup->encryptedString === cryptMethods("Toto") &&
		$recup->simpleFloat === 54.42  &&
		$recup->simpleMail === "froehly.mathieu@gmail.com" &&
		$recup->encryptedMail === cryptMethods("heuk67@gmail.com") &&
		$recup->phone === "0672546690" &&
		$recup->indicatif_test === "FR"
	,
		"Les attributs de la class n'ont pas les valeurs attendues")
)
	return (false);

if (!test("Nettoyage de la db", TestTableData::dropTable(), "La table n'a pas pu être supprimée"))
	return (false);

// Tester donnée type OneToOne
// Tester donnée type OneToMany
// Tester donnée type ManyToOne
// Tester donnée type ManyToMany
