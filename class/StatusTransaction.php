<?php
require_once("core/Database.php");
require_once("core/Table.php");
require_once("Transaction.php");

class StatusTransaction extends		Table
{
	protected static				$_name			= "StatusTransaction";
	protected static				$_primary_key	= "id";

	private							$id				= null;
	private							$_transaction	= null;
	private							$_dateCreation	= null;
	private							$_dateStatus	= null;
	public 							$id_transaction	= null;
	private							$status_sup		= null;
	private							$status_sub		= null;
	private							$date_status	= null;
	private							$date_creation	= null;

/*	private static 					$_lstStatus     = array(
		1 => array(
			0 => array(
				"title" => "Transaction enregistrée"
			)
		),
		2 => array(
			0 => array(
				"title" => "Transaction vérifiée"
			)
		)
	);*/
	private static					$_lstStatusMSC	= array(
		0 => array(
			0 => array(
				"title" => "Transaction potentielle"
			)
		),
		1 => array(
			0 => array(
				"title" => "Dossier réceptionné en attente avant envoi société de gestion"
			),
			1 => array(
				"title" => "Dossier envoyé pour contrepartie"
			),
			2 => array(
				"title" => "Document manquant"
			)
		),
		2 => array(
			0 => array(
				"title" => "Dossier réceptionné par MeilleureSCPI.com, envoyé à Société de Gestion"
			),
			1 => array(
				"title" => "Dossier envoyé directement par le client à la société de gestion."
			),
			2 => array(
				"title" => "Réceptionné par partenaire, envoyé à la Société de Gestion"
			)
		),
		3 => array(
			0 => array(
				"title" => "Réceptionné par la Société de Gestion et en attente de pièces complémentaires"
			)
		),
		4 => array(
			0 => array(
				"title" => "Réceptionné par le SG en cours d’etude du dossier"
			),
			1 => array(
				"title" => "Transaction en cours d’enregistrement, attente de confrontation"
			),
			2 => array(
				"title" => "Transaction en cours d’enregistrement, attente des fonds"
			),
			3 => array(
				"title" => "Transaction en cours d’enregistrement, attente contrepartie"
			)
		),
		5 => array(
			0 => array(
				"title" => "Transaction enregistrée : en attente du CNP pour vérification"
			)
		),
		6 => array(
			0 => array(
				"title" => "Transaction OK"
			)
		),
		7 => array(
			0 => array(
				"title" => "Transaction Annulée"
			)
		)
	);

	public function					__construct() {

	}

	public function					insertIt() {
		if ($this->id != null)
			return (false);
		if (
			empty($this->getTransaction()) ||
			!isset(self::$_lstStatusMSC[$this->status_sup][$this->status_sub])
		)
			return (false);
		$date = null;
		if ($this->date_status != null)
			$date = $this->date_status;
		else
			$date = 0;
		$req = "INSERT IGNORE `StatusTransaction`
			(id_transaction, status_sup, status_sub, date_status, date_creation) VALUES
			(?, ?, ?, ?, ?)";
		$data = array(
			$this->id_transaction,
			$this->status_sup,
			$this->status_sub,
			$date,
			time()
		);
		if (Database::prepareInsert(static::$_db, $req, $data))
			return (true);
		else
			return (false);
	}

	public function					update() {
		if ($this->id == null)
			return (false);
		$req = "UPDATE `StatusTransaction` SET `status_sup` = ?, `status_sub` = ?";
		if (Database::prepareNoClass(static::$_db, $req, ['status_sup' => $this->status_sup, 'status_sub' => $this->status_sub]))
			return true;
		else
			return false;
	}

	public function					getTransaction()
	{
		if ($this->_transaction == null)
		{
			if ($this->id_transaction == null)
				return (false);
			$this->_transaction = Transaction::getFromId($this->id_transaction);
			if (empty($this->_transaction))
				return (null);
		}
		return ($this->_transaction);
	}

	public function					setTransaction($objTransaction) {
		if (!($objTransaction instanceof Transaction))
			return (false);
		$this->id_transaction = $objTransaction->id;
		$this->_transaction = $objTransaction;
		return (true);
	}

	public function getStatusSup()
	{
		return $this->status_sup;
	}
	public function getStatusSub()
	{
		return $this->status_sub;
	}
	public function					getDateStatus()
	{
		$rt = null;
		if (!empty($this->date_status))
		{
			$rt = new DateTime;
			$rt->setTimestamp($this->date_status); 
		}
		return ($rt);
	}
	public function					getDateCreation()
	{
		$rt = null;
		if (!empty($this->date_creation))
		{
			$rt = new DateTime;
			$rt->setTimestamp($this->date_creation);
		}
		return ($rt);
	}
	public function					setDateStatus($objDateTime)
	{
		if (!($objDateTime instanceof DateTime))
			return (false);
		//$this->date = $objDateTime;
		$this->date_status = $objDateTime->getTimestamp();
		return (true);
	}


	public function					setDateStatusTimeStamp($date)
	{
		$this->date_status = $date;
		return (true);
	}

	public function					setDateCreationTimeStamp($date)
	{
		$this->date_creation = $date;
		return (true);
	}

	public function					getStatus()
	{
		return (array($this->status_sup, $this->status_sub));
	}

	public function					getStatusTitle()
	{
		return ($this->status_sup . " - " . self::$_lstStatusMSC[$this->status_sup][$this->status_sub]["title"]);
	}

	public function					setStatus($sup, $sub)
	{
		if (!isset(self::$_lstStatusMSC[$sup]) || !isset(self::$_lstStatusMSC[$sup][$sub]))
			return (false);
		$this->status_sup = $sup;
		$this->status_sub = $sub;
		return (true);
	}
	public function					setStatusFromStr($str) {
		foreach (self::$_lstStatusMSC as $key1 => $elm1)
		{
			foreach ($elm1 as $key2 => $elm2)
			{
				$name = $key1 . " - " . $elm2['title'];
				if ($str == $name)
				{
					$rt = $this->setStatus($key1, $key2);
					return ($rt);
				}
			}
		}
		return (false);
	}
	public function					setStatusFromTransactionOldColumn() {
		if ($this->_transaction == null)
			return (false);
		return $this->setStatusFromStr($this->getTransaction()->getStatusTransactionColumn());
	}
	public static function			getAllForTransaction($id_transaction) {
		return (parent::getFromKeyValue('id_transaction', $id_transaction));
	}
	public static function			getLastForTransaction($id_transaction) {
		$req = "SELECT * FROM `StatusTransaction` WHERE id_transaction = ? ORDER BY date_creation DESC LIMIT 1";
		$data = [
			$id_transaction
		];
		$rt = Database::prepare(static::$_db, $req, $data, 'StatusTransaction');
		if (count($rt))
			return ($rt[0]);
		return (null);
	}
	public static function			getLst() {
		return (self::$_lstStatusMSC);
	}
	public function					getKeyForStore() {
		return ($this->status_sup . "-" . $this->status_sub);
	}
	public static function			getLstForStore() {
		$rt = [];
		foreach(self::getLst() as $key => $elm)
		{
			foreach($elm as $key2 => $elm2)
			{
				$rt["$key-$key2"] = "$key - " . $elm2['title'];
			}
		}
		return ($rt);
	}
	public static function 			getForStore($id_transaction)
	{
		$retour = ['0' => '0'];
		$req = "SELECT * FROM `StatusTransaction` WHERE `id_transaction` = ? ORDER BY `status_sup` DESC";
		$max = false;
		if (($res = Database::getNoClass(static::$_db, $req, [$id_transaction])))
		{
			foreach ($res as $t)
			{
				if (!$max)
					$max = $t['status_sup'];
				$retour[$t['status_sup']]['id_executant'] = $t['id_executant'];
				$retour[$t['status_sup']]['date_creation'] = $t['date_creation'];
				$retour[$t['status_sup']]['date_status'] = $t['date_status'];
				$retour[$t['status_sup']]['status_sub'] = $t['status_sub'];
			}
		}
		$done = ($max == 6)? true : false;
		$canceled = ($max == 7)? true : false;

		while ($max)
		{
			if (!isset($retour[$max]['id_executant']))
				$retour[$max]['id_executant'] = null;
			if (!isset($retour[$max]['date_creation']))
				$retour[$max]['date_creation'] = null;
			if (!isset($retour[$max]['date_status']))
				$retour[$max]['date_status'] = null;
			if (!isset($retour[$max]['status_sub']))
				$retour[$max]['status_sub'] = null;
			--$max;
		}
		return ['list' => $retour,'done' => $done, 'canceled' => $canceled];
	}
	public static function			getForFrontStore($id_transaction)
	{
		/*$retour = ['0' => '0'];
		$req = "SELECT * FROM `StatusTransaction` WHERE `id_transaction` = ? ORDER BY `status_sup` DESC";
		$max = false;
		if (($res = Database::getNoClass(static::$_db, $req, [$id_transaction])))
		{
			foreach ($res as $t)
			{
				if (!$max)
					$max = $t['status_sup'];
				$retour[$t['status_sup']]['date_creation'] = $t['date_creation'];
				$retour[$t['status_sup']]['date_status'] = $t['date_status'];
				$retour[$t['status_sup']]['status_sub'] = $t['status_sub'];
			}
		}
		$done = ($max == 6)? true : false;
		$canceled = ($max == 7)? true : false;

		while ($max)
		{
			if (!isset($retour[$max]['date_creation']))
				$retour[$max]['date_creation'] = null;
			if (!isset($retour[$max]['date_status']))
				$retour[$max]['date_status'] = null;
			if (!isset($retour[$max]['status_sub']))
				$retour[$max]['status_sub'] = null;
			--$max;
		}
		*/
		$done = false;
		$canceled = false;
		$retour = self::getLastForTransaction($id_transaction);
		if ($retour)
		{
			if ($retour->getStatusSup() == '6')
				$done = true;
			else if ($retour->getStatusSup() == '7')
				$canceled = true;
		}
		return ['list' => $retour->getKeyForStore(),'done' => $done, 'canceled' => $canceled];
	}
}
