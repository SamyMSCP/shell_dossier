<?php
require_once("core/Database.php");
require_once("core/Table.php");
require_once("Scpi.php");

class absorption extends Table
{
	protected static		$_name = "absorption";
	protected static		$_primary_key = "id";
	private static			$_needComplete = null;
	private					$_dateAbsorption = null;

	//public function getCompletionForTransaction($trans) {
		//return (($this->after_nbr_part * $trans->getNbrPart()) % $this->before_nbr_part);
	//}
	public static function updateFromServer() {
		$scpi = Scpi::getAll();
		$absorption = self::getAll();
		foreach ($scpi as $key => $elm)
		{
			if (empty($elm->absorbed_at) || empty($elm->parent_id))
				continue ;
			$haveIt = false;
			$date = DateTime::createFromFormat("Y-m-d H:i:s", $elm->absorbed_at)->getTimestamp();
			foreach($absorption as $key2 => $elm2)
			{
				if ($date == $elm2->date_absorption)
				{
					$haveIt = true;
					break ;
				}
			}
			if (!$haveIt)
			{
				$req = "INSERT INTO `absorption` 
					(id_scpi_parent, id_scpi_absorbed, date_absorption, before_nbr_part, after_nbr_part)
					VALUES(?, ?, ?, 1, 1)";
				$data = array(
					$elm->parent_id,
					$elm->id,
					DateTime::createFromFormat("Y-m-d H:i:s", $elm->absorbed_at)->getTimestamp()
				);
				Database::prepareInsert(static::$_db, $req, $data);
			}
		}
	}
	public static function getFromScpiId($id_scpi) {
		$rt = parent::getFromKeyValue("id_scpi_absorbed", $id_scpi);
		if (count($rt))
			return ($rt[0]);
		else
			return (null);
	}
	public static function updateData($id, $before, $after, $isActivate) {
		$req = "UPDATE `absorption` SET before_nbr_part = ?, after_nbr_part = ?, isActivate = ? WHERE id = ?";
		$data = array(
			$before,
			$after,
			$isActivate,
			$id
		);
		Database::prepareNoClass(static::$_db, $req, $data);
		Notif::set("msgAbsorbUpdate", "L'absorption a bien ete mise a jour");
		if ($isActivate)
			Transaction::setTransactionAbsorbedByScpi($id, self::getFromId($id)->parent_id);
		return (true);
	}
	public function setTransactionIsAbsorbed() {
		Transaction::setTransactionAbsorbedByScpi($this->id_scpi_absorbed, $this->id_scpi_parent);
	}
	public static function getNeedComplete() {
		if (self::$_needComplete === null)
		{
			$req = "SELECT * FROM `absorption` WHERE isActivate = 0 OR isActivate IS NULL";
			self::$_needComplete = Database::prepare(static::$_db, $req, array(), "absorption");
		}
		return (self::$_needComplete);
	}
	public function getDateAbsorption() {
		if (empty($this->date_absorption))
			$this->_dateAbsorption = "";
		if ($this->_dateAbsorption == NULL) {
			$this->_dateAbsorption = new DateTime;
			$this->_dateAbsorption->setTimestamp($this->date_absorption); 
		}
		return ($this->_dateAbsorption);
	}
	public function getBeforeNbrPart() {
		return (intval($this->before_nbr_part));
	}
	public function getAfterNbrPart() {
		return (intval($this->after_nbr_part));
	}
	public function isActivate() {
		if (empty($this->isActivate))
			return (false);
		return (true);
	}
}
