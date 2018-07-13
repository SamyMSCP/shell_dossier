<?php
require_once("core/Database.php");
require_once("core/Table.php");
require_once("Scpi.php");

class ScpiGestion extends Table
{
	protected static						$_name = "ScpiGestion";
	protected static						$_primary_key = "id";
	private									$id_scpi = null;
	private									$show_list = 0;
	protected								$id = null;

	public static							$_showListStr = array(
		0 => "Auto",
		1 => "Show",
		2 => "Hide"
	);

	public static function					getFromIdScpi($id_scpi)
	{
		$rt = parent::getFromKeyValue("id_scpi", $id_scpi);
		if (empty($rt)) {
			$nelm = new ScpiGestion();
			$nelm->setIdScpi($id_scpi);
			$nelm->setShowList(0);
			$nelm->insertIt();
		}
		$rt = parent::getFromKeyValue("id_scpi", $id_scpi);
		if (empty($rt))
			return (false);
		return ($rt[0]);
	}

	public static function					updateFromBdd()
	{
		$lst = Scpi::getAll();
		foreach ($lst as $key => $elm) {
			if (empty(self::getFromKeyValue("id_scpi", $elm->id))) {
				$new = new ScpiGestion();
				if (!$new->setIdScpi($elm->id))
					return (false);
				if (!$new->insertIt())
					return (false);
			}
		}
		return (true);
	}

	public function							getShowList() {
		return ($this->show_list);
	}

	public function							__construct() { }

	public function							updateIt() {
		if ($this->id == null || $this->id_scpi == null)
			return (false);
		$req = "UPDATE `ScpiGestion` SET show_list = ? WHERE id_scpi = ?;";
		$data = array(
			$this->show_list,
			$this->id_scpi
		);
		return Database::prepareNoClass(static::$_db, $req, $data);
	}

	public function							insertIt() {
		if ($this->id != null || $this->id_scpi == null)
			return (false);
		$req = "INSERT INTO `ScpiGestion` (id_scpi, show_list)
								VALUES (?, ?);";
		$data = array(
			$this->id_scpi,
			$this->show_list
		);
		return Database::prepareInsert(static::$_db, $req, $data);
	}

	public function							getIdScpi() {
		return ($this->id_scpi);
	}

	public function							setShowList($show_list)
	{
		if ($show_list < 0 || $show_list> 2)
			return (false);
		$this->show_list = $show_list;
		return (true);
	}

	public function							setIdScpi($id_scpi)
	{
		// Check si la scpi existe en bdd;
		$lst = Scpi::getAll();
		if (empty($lst[$id_scpi]))
			return (false);
		$this->id_scpi = $id_scpi;
		return (true);
	}
	public function							getValeurIsf() {
		return (floatval($this->valeur_isf));
	}
	public function							getValeurIfi2018() {
		if ($this->valeur_ifi_01_01_2018 === null)
			return (null);
		return (floatval($this->valeur_ifi_01_01_2018));
	}
	public function							getValeurIfiExpatrie2018() {
		if ($this->valeur_ifi_expatrie_01_01_2018 === null)
			return (null);
		return (floatval($this->valeur_ifi_expatrie_01_01_2018));
	}
	public function							getConseilsMscpi() {
		return ($this->conseils_mscpi);
	}
	public function							getStrategie() {
		return ($this->strategie);
	}
	public function							getAdequation() {
		return ($this->adequation);
	}
	public function							getShowOpportunite() {
		return ($this->show_opportunite);
	}


}
