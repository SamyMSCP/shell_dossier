<?php
class TypeCategorieProfessionelle extends TypeMulti {
	/*
		Liste des éléments attendu

		- code_1
		- code_2
	*/
	protected $_config = [];
	protected static $_sqlColumn = [
		"code_1" => "int(11)", // -
		"code_2" => "int(11)" // -
	];


	protected static function isValid($values, $getError = null) {
	//error();
		$rt = [];
		if ( !isset($values['code_1']) || intval($values['code_1']) < 1)
			$rt['code_1'] = "Veuilez insérer une donnée valide";

		$tmp = CategorieProfessionelle::getFromKeyValue('code_1', intval($values['code_1']));
		if (empty($tmp))
			$rt['code_1'] = "Veuilez insérer une donnée valide";
		/*
			TODO 
			On vérifie si le code 1 est okay dans la table;
			On récupère la catégorie par code_1 et code 2 et on vérifie si il y a une donnée d'enregistrée.
		*/

		if (!empty($rt) && $getError == null)
			return (false);
		else if (!empty($rt))
			return ($rt);


		if ( !isset($values['code_2']) || intval($values['code_1']) < 1)
			$rt['code_2'] = "Veuilez insérer une donnée valide";

		$tmp = CategorieProfessionelle::getFromKeysValues( [
			'code_1' => intval($values['code_1']),
			'code_2' => intval($values['code_2'])
		]);
		if (empty($tmp))
			$rt['code_2'] = "Veuilez insérer une donnée valide";

		if (!empty($rt) && $getError == null)
			return (false);
		else if (!empty($rt))
			return ($rt);

		return (true);
	}

	public function getShowComponent($col, $config) {
		return ("ComponentTypeShow");
	}

	public function getEditComponent($col, $config) {
		$name = static::fromTableToName($col, $config['config']);


		if ($name === "code_1") {
			return ("ComponentTypeCategorieProfessionelleCode1");
		}
		else if ($name === "code_2") {
			return ("ComponentTypeCategorieProfessionelleCode2Pp");
			return ("ComponentTypeEdit");
		}
		return ("ComponentTypeEdit");
	}
}
