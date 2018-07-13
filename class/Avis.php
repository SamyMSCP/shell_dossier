<?php
require_once("core/Database.php");
require_once("core/Table.php");

class Avis extends Table
{
	protected static		$_name = "AVIS";
	protected static		$_primary_key = "id";
	private					$_avis = null;
	private					$_dateCreation = null;
	public static			$_lstPriorite = array(
		"0" =>"-",
		"1" =>"Prioritaire",
		"2" =>"Non Prioritaire",
		"3" =>"On ne fera probablement pas"
	);
	public static			$_status = array(
		"0" => "En attente",
		"1" => "En cours",
		"2" => "Fait"
	);

	public static function insertNew($id_dh, $content, $date_ajout = null)
	{
		$req = "SELECT COUNT(*) as `nb` FROM `logger` INNER JOIN `type_logger` ON `type_logger`.`id` = `logger`.`type` WHERE `type_logger`.`name` = ? AND `id_executant` = ? AND `date` >= ?";

		$res = Database::getNoClass(static::$_db, $req, ["Ajout d'un avis client", $id_dh, time() - ( 24 * 3600 )]);
		// Si le Dh à déjà laissé 10 avis dans les dernières 24H
		if (!empty($res) && !empty($res[0]['nb']) && $res[0]['nb'] >= 10)
			return null;
		if (!$date_ajout)
			$date_ajout = time();
		$req = "INSERT INTO AVIS (id_dh, content, date_ajout) VALUES (?, ?, ?)";
		return (Database::prepareInsert(static::$_db, $req, [$id_dh, $content, $date_ajout], get_called_class()));
	}

	public static function updateAvis($id, $priorite, $status, $date = null) {
		if ($date == null)
		{
			$req = "UPDATE `AVIS` SET priorite = ?, status = ? WHERE id = ?";
			$data = array(
				$priorite,
				$status,
				$id
			);
		}
		else
		{
			$req = "UPDATE `AVIS` SET priorite = ?, status = ?, date_ajout = ? WHERE id = ?";
			$data = array(
				$priorite,
				$status,
				$date,
				$id
			);
		}
		return Database::prepareNoClass(static::$_db, $req, $data);
	}
	public function getAvis() {
		if ($this->_avis == null)
		{
			$this->_avis = $this->content;
		}
		return ($this->_avis);
	}
	public function getDateAjout() {
		if ($this->_dateCreation == null && !empty($this->date_ajout))
		{
			$rt = new Datetime;
			$rt->setTimestamp($this->date_ajout); 
			return ($rt);
		}
		return ($this->_dateCreation);
	}
	public function getStatus() {
		return (intval($this->status));
	}
	public function getPriorite() {
		return (intval($this->priorite));
	}
}
