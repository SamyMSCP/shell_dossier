<?php
class TypeAdresse extends TypeMulti {
	/*
		Liste des éléments attendu

		- numeroRue
		- extension
		- type_voie
		- voie (crypted)
		- complementAdresse
		- codePostal
		- commune
		- pays
	*/
	protected $_config = [];
	protected static $_sqlColumn = [
		"numeroRue" => "text", // -
		"extension" => "varchar(16)", // -
		"type_voie" => "text", // -
		"voie" => "text",
		"complementAdresse" => "text", //-
		"codePostal" => "text", // -
		"ville" => "text", // -
		"pays" => "text" // -
	];


	protected static function isValid($values, $getError = null) {
		$rt = [];
		if ( !isset($values['numeroRue']) || intval($values['numeroRue']) < 1)
			$rt['numeroRue'] = "Veuilez compléter le numéro de rue";

		if ( !isset($values['type_voie']) || !is_string($values['type_voie']) || strlen($values['type_voie'])  < 1)
			$rt['type_voie'] = "Veuilez compléter le type de voie";

		if (!isset($values['voie']) || !is_string($values['voie']) || strlen($values['voie'])  < 2 )
			$rt['voie'] = "Veuilez compléter le nom de la voie";

		if (isset($values['voie']) && strlen($values['voie'])  > 128)
			$rt['voie'] = "Le nom de la voie est limitée à 128 caractères";
			
		if (!isset($values['codePostal']) || !is_string($values['codePostal']) || strlen($values['codePostal'])  < 3)
			$rt['codePostal'] = "Veuilez compléter le code postal";

		if (!isset($values['ville']) || !is_string($values['ville']) || strlen($values['ville'])  < 3)
			$rt['ville'] = "Veuilez compléter la ville";
			
		if (!isset($values['pays']) || !is_string($values['pays']) || strlen($values['pays'])  < 3)
			$rt['pays'] = "Veuilez compléter le pays";

		if (!isset($values['extension']) || strlen($values['extension']) > 5)
			$rt['extension'] = "L'extension d'adresse n'est pas valide";
		
		if (!isset($values['complementAdresse']))
			$rt['complementAdresse'] = "Une erreur sur ce champs";

		if (isset($values['complementAdresse']) && strlen($values['complementAdresse']) > 128)
			$rt['complementAdresse'] = "Le complément d'adresse est limité à 128 caractères";

		if (!empty($rt) && $getError == null)
			return (false);
		else if (!empty($rt))
			return ($rt);




		$pays = Pays2::getFromKeyValue("nom_fr_fr", $values['pays']);

		//$db = Database::prepare("mscpi_db", "SELECT * FROM `pays` WHERE nom_fr_fr LIKE ? ", [$values['pays']], "Pays");
		if (empty($pays)) {
			$rt["pays"] = "Le pays inséré n'est pas valide";
		}
		$pays = $pays[0];
		if (!empty($rt) && $getError == null)
			return (false);
		else if (!empty($rt))
			return ($rt);

		if ($pays->getNomFrFr()->get() == "France")
		{
			$db = Database::prepare("mscpi_db", "SELECT * FROM `code_ville` WHERE Nom_commune LIKE ? AND Code_postal = ?;", [
				$values['ville'],
				$values["codePostal"]
			], "CodeVille");
			if (empty($db)) {
				$rt['ville'] = "La ville et le code postal ne correspondent pas ";
				$rt["codePostal"] = "La ville et le code postal ne correspondent pas ";
			}
		}

		if (!in_array($values['type_voie'], self::$_type_voie))
			$rt['type_voie'] = "le type de voie n'a pas valide";
		if (!empty($rt) && $getError == null)
			return (false);
		else if (!empty($rt))
			return ($rt);
		return (true);
	}

	protected static function beforeSet($name, $value) {
		if ($name == "pays")
		{
			$rt = Database::prepare("mscpi_db", "SELECT * FROM `pays` WHERE nom_fr_fr LIKE ? ", [$value], "Pays");
			if (empty($rt))
				return (null);
			return ($rt[0]->nom_fr_fr);
		}
		else if ($name == "type_voie")
			return (htmlspecialchars(strtolower($value)));
		return (htmlspecialchars($value));
	}
	protected static function prepareSet($name, $value) {
		if ($name == "voie")
		{
			if (!is_string($value) || strlen($value) < 1)
				return (null);
			return (ft_crypt_information($value));
		}
		return ($value);
	}
	protected static function prepareGet($name, $value) {
		if ($name == "voie")
		{
			if (!is_string($value) || strlen($value) < 1)
				return (null);
			return (ft_decrypt_crypt_information($value));
		}
		return ($value);
	}

	public static			$_type_voie = array(
		"allée",
		"avenue",
		"boulevard",
		"carrefour",
		"chemin",
		"chaussée",
		"cité",
		"corniche",
		"cours",
		"domaine",
		"descente",
		"ecart",
		"esplanade",
		"faubourg",
		"grande rue",
		"hameau",
		"halle",
		"impasse",
		"lieu-dit",
		"lotissement",
		"marché",
		"montée",
		"passage",
		"place",
		"plaine",
		"plateau",
		"promenade",
		"parvis",
		"quartier",
		"quai",
		"résidence",
		"ruelle",
		"rocade",
		"rond-point",
		"route",
		"rue",
		"sente - sentier",
		"square",
		"terre-plein",
		"traverse",
		"villa",
		"village"
	);

	public function getShowComponent($col, $config) {
		return ("ComponentTypeShow");
	}

	public function getEditComponent($col, $config) {
		$name = static::fromTableToName($col, $config['config']);
		if ($name === "pays") {
			return ('ComponentTypePaysEdit');
		}
		else if ($name === "type_voie") {
			return ('ComponentTypeTypeVoieEdit');
		}
		else if ($name === "ville") {
			return ('ComponentTypeVilleEdit');
		}
		else if ($name === "codePostal") {
			return ('ComponentTypeCodepostalEdit');
		}
		return ("ComponentTypeEdit");
	}
}
