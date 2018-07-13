<?php
require_once("core/Database.php");
require_once("core/Table.php");

class Logger extends Table
{
	/**
		id_executant > 0 => donneur d'ordre
		id_executant == 0 => systeme.
	**/
	protected static		$_name = "logger";
	protected static		$_primary_key = "id";
	public static			$_noSecure = ["params"];

	public function __construct() {}
	public static function		setNew($type, $id_executant, $id_client, $params = [])
	{
		$type = TypeLogger::getByName($type);
		/// Il faut checker que tout les parametres requis pour ce type de logs est bien present !
		if (!$type)
			return (false);
		$p = [];
		foreach ($params as $k => $v) { $p[$k] = htmlspecialchars($v); }

		$req = "INSERT INTO `logger` (type, id_executant, id_client, params, date) VALUES (:type, :id_executant, :id_client, :params, :date)";
		$data = [
			"type" => $type->id,
			"id_executant" => $id_executant,
			"id_client" => $id_client,
			"params" => serialize($p),
			"date" => time()
		];
		
		$rt = Database::prepareInsertCheckSecurity(static::$_db, $req, $data, "Logger");
		LoggerSubscription::dispatch(self::getFromId($rt)[0]);
		return ($rt);
	}
	public static function		setNewByTypeId($type, $id_executant, $id_client, $params = [])
	{
		$type = TypeLogger::getById($type);
		/// Il faut checker que tout les parametres requis pour ce type de logs est bien present !
		if (!$type)
			return (false);
		$req = "INSERT INTO `logger` (type, id_executant, id_client, params, date) VALUES (:type, :id_executant, :id_client, :params, :date)";
		$data = [
			"type" => $type->id,
			"id_executant" => $id_executant,
			"id_client" => $id_client,
			"params" => serialize($params),
			"date" => time()
		];
		$rt = Database::prepareInsertCheckSecurity(static::$_db, $req, $data, "Logger");
		LoggerSubscription::dispatch(self::getFromId($rt)[0]);
		return ($rt);
	}
	public function getAllForModule() {
		$req = "SELECT * FROM `logger` ORDER BY date DESC LIMIT 50";
		return (Database::prepare(static::$_db, $req, [], get_called_class()));
	}
	public function getByTypeIdForModule($typeId) {
		$req = "SELECT * FROM `logger` WHERE type = ? ORDER BY date DESC LIMIT 50";
		return (Database::prepare(static::$_db, $req, [$typeId], get_called_class()));
	}
	public function getByTypeId($typeId) {
		return (self::getFromKeyValue('type', $typeId));
	}
	public function getTypeId(){
		return ($this->type);
	}
	public function getType() {
		return (TypeLogger::getNameById($this->type));
	}
	public function getExecutant() {
		return (Dh::getById($this->id_executant));
	}
	public function getExecutantName() {
		$rt = $this->getExecutant();
		if (!empty($rt))
			return ($rt->getShortName());
		else
			return ("Système");

	}
	public function getClient() {
		return (Dh::getById($this->id_client));
	}
	public static function getByExecutant($id_executant) {
		return (parent::getFromKeyValue("id_executant", $id_executant));
	}
	public function getLastActionForDh($id_dh) {
		$req = "SELECT * FROM `logger` WHERE id_executant = ? ORDER BY date DESC LIMIT 1";
		$rt = Database::prepare(static::$_db, $req, [$id_dh], "Logger");
		if (empty($rt))
			return (null);
		return ($rt[0]);
	}
	public static function getByClient($id_client) {
		return (parent::getFromKeyValue("id_client", $id_client));
	}
	public function __toString() {
		return ("<ul><li>Log : " . $this->getType() . "</li><li>executant : " . $this->getExecutant()->getShortName() . "</li><li>client : " . $this->getClient()->getShortName() . "</li></ul>");
	}
	public function render($rt) {
		$client = Dh::getById($this->id_client);
		$search = [
			"##CLIENT_SHORT_NAME##"
		];
		$replace = [
			$client->getShortName()
		];
		$rt = str_replace($search, $replace, $rt);
		return ($rt);
	}
	public function getDate() {
		$rt = new DateTime();
		$rt->setTimestamp($this->date);
		return ($rt);
	}
	public function getDateFormat() {
		$rt = new DateTime();
		$rt->setTimestamp($this->date);
		return ($rt);
	}
	public function getParams() {
		//try {
		if (empty($this->params) || $this->params === "a:0:{}")
			return null;
			error_reporting(0);
			$rt = mb_unserialize($this->params);
			if ($rt == null)
				$rt = ["Erreur" => "unserialize a bugué"];
			error_reporting(1);
				/*
		} catch (Exception $e) {
			$rt = ["Erreur" => $e->getMessage()];
		}
		*/
		return ($rt);
	}

	public static function getByTypeSince($nom_type_logger, $date)
	{
		$req = "SELECT * FROM `logger` INNER JOIN `type_logger` ON `type_logger`.`id` = `logger`.`type` WHERE `type_logger`.`name` = ? AND `date` >= ? ORDER BY `date` DESC";
		return Database::prepare(static::$_db, $req, [$nom_type_logger, $date], get_called_class());
	}

	public static function getByTypeExecutantSince($nom_type_logger, $id_executant, $date)
	{
		$req = "SELECT * FROM `logger` INNER JOIN `type_logger` ON `type_logger`.`id` = `logger`.`type` WHERE `type_logger`.`name` = ? AND `id_executant` = ? AND `date` >= ? ORDER BY `date` DESC";
		return Database::getNoClass(static::$_db, $req, [$nom_type_logger, $id_executant, $date]);
	}

	public static function getLastByTypeExecutant($nom_type_logger, $id_executant)
	{
		$req = "SELECT * FROM `logger` INNER JOIN `type_logger` ON `type_logger`.`id` = `logger`.`type` WHERE `type_logger`.`name` = ? AND `id_executant` = ? ORDER BY `date` DESC LIMIT 1";
		return Database::prepare(static::$_db, $req, [$nom_type_logger, $id_executant], get_called_class());
	}

	public static function getNbrCompteCreeFront() {
		$rt = 0;
		$all = self::getByTypeId(1);
		foreach ($all as $key => $elm)
		{
			$params = $elm->getParams();
			if ($params['biais'] == "Création standard sur le front")
			{
				$rt++;
			}
		}
		return ($rt);
	}

    public static function getNbrCompteCreeApi() {
        $rt = 0;
        $all = self::getByTypeId(1);
        foreach ($all as $key => $elm)
        {
            $params = $elm->getParams();
            if ($params['biais'] == "Api")
            {
                $rt++;
            }
        }
        return ($rt);
    }

    public static function getNbrCompteCreeFacebook() {
        $rt = 0;
        $all = self::getByTypeId(1);
        foreach ($all as $key => $elm)
        {
            $params = $elm->getParams();
            if (($params['biais'] == "Création Landing Page") && stristr($params['origine'], "facebook"))
            {
                $rt++;
            }
        }
        return ($rt);
    }


    public static function getNbrCompteCreeLinkedin() {
        $rt = 0;
        $all = self::getByTypeId(1);
        foreach ($all as $key => $elm)
        {
            $params = $elm->getParams();
            if (($params['biais'] == "Création Landing Page") && stristr($params['origine'], "linkedin"))
            {
                $rt++;
            }
        }
        return ($rt);
    }

    public static function getNbrCompteCreeLinxo() {
        $rt = 0;
        $all = self::getByTypeId(1);
        foreach ($all as $key => $elm)
        {
            $params = $elm->getParams();
            if (($params['biais'] == "Création Landing Page") && stristr($params['origine'], "linxo"))
            {
                $rt++;
            }
        }
        return ($rt);
    }

    public static function getNbrCompteCreeTwitter() {
        $rt = 0;
        $all = self::getByTypeId(1);
        foreach ($all as $key => $elm)
        {
            $params = $elm->getParams();
            if (($params['biais'] == "Création Landing Page") && stristr($params['origine'], "twitter"))
            {
                $rt++;
            }
        }
        return ($rt);
    }

    public static function getNbrCompteCreeMailChimp() {
        $rt = 0;
        $all = self::getByTypeId(1);
        foreach ($all as $key => $elm)
        {
            $params = $elm->getParams();
            if ($params['biais'] == "MailChimp")
            {
                $rt++;
            }
        }
        return ($rt);
    }

	public static function getTodayByNameForExecutant($type, $id_dh) {
		$id = TypeLogger::getByName($type)->id;
		$dat = date("d/m/Y");
		$dat = Datetime::createFromFormat("d/m/Y H:i:s", $dat . " 00:00:00")->getTimestamp();
		$req = "SELECT * FROM `logger` WHERE type = ? AND date >= ? AND id_executant = ?;";
		return (Database::prepare(static::$_db, $req, [$id, $dat, $id_dh],get_called_class()));
	}
	public static function getNbrTodayByNameForExecutant($type, $id_dh) {
		$id = TypeLogger::getByName($type)->id;
		$dat = date("d/m/Y");
		$dat = Datetime::createFromFormat("d/m/Y H:i:s", $dat . " 00:00:00")->getTimestamp();
		$req = "SELECT count(*) FROM `logger` WHERE type = ? AND date >= ? AND id_executant = ?;";
		return (Database::getNoClass(static::$_db, $req, [$id, $dat, $id_dh])[0][0]);
	}
	public static function getNbrTodayByName($type) {
		$id = TypeLogger::getByName($type)->id;
		return (self::getNbrTodayById($id));
	}
	public static function getNbrTodayById($id) {
		$dat = date("d/m/Y");
		$dat = Datetime::createFromFormat("d/m/Y H:i:s", $dat . " 00:00:00")->getTimestamp();
		$req = "SELECT count(*) FROM `logger` WHERE type = ? AND date >= ?;";
		return (Database::getNoClass(static::$_db, $req, [$id, $dat])[0][0]);
	}

	public static function getNbrByIdForLastDays($id) {
		$i = 0;
		$rt = [];
		$dat = date("d/m/Y");
		$datUp = date("d/m/Y");
		$dat = Datetime::createFromFormat("d/m/Y H:i:s", $dat . " 00:00:00")->getTimestamp();
		$req = "SELECT count(*) FROM `logger` WHERE type = ? AND date >= ?;";
		$rt[] = Database::getNoClass(static::$_db, $req, [$id, $dat])[0][0];
		for ($i = 0; $i < 10;$i++)
		{
			$datUp = $dat;
			$dat -= 86400;
			$req = "SELECT count(*) FROM `logger` WHERE type = ? AND date >= ? AND date < ?;";
			$rt[] = Database::getNoClass(static::$_db, $req, [$id, $dat, $datUp])[0][0];
		}
		return ($rt);
	}

    public static function getNbrByIdForLastDaysFront($id) {
        $i = 0;
        $rt = [];
        $dat = date("d/m/Y");
        $datUp = date("d/m/Y");
        $dat = Datetime::createFromFormat("d/m/Y H:i:s", $dat . " 00:00:00")->getTimestamp();
        $req = "SELECT count(*) FROM `logger` WHERE type = ? AND date >= ? AND params Like 'Création standard sur le front';";
        $rt[] = Database::getNoClass(static::$_db, $req, [$id, $dat])[0][0];
        for ($i = 0; $i < 10;$i++)
        {
            $datUp = $dat;
            $dat -= 86400;
            $req = "SELECT count(*) FROM `logger` WHERE type = ? AND date >= ? AND date < ?And params Like '%Création standard sur le front%';";
            $rt[] = Database::getNoClass(static::$_db, $req, [$id, $dat, $datUp])[0][0];
        }
        return ($rt);
    }

    public static function getNbrByIdForLastDaysMailChimp($id) {
        $i = 0;
        $rt = [];
        $dat = date("d/m/Y");
        $datUp = date("d/m/Y");
        $dat = Datetime::createFromFormat("d/m/Y H:i:s", $dat . " 00:00:00")->getTimestamp();
        $req = "SELECT count(*) FROM `logger` WHERE type = ? AND date >= ? AND params Like '%MailChimp%';";
        $rt[] = Database::getNoClass(static::$_db, $req, [$id, $dat])[0][0];
        for ($i = 0; $i < 10;$i++)
        {
            $datUp = $dat;
            $dat -= 86400;
            $req = "SELECT count(*) FROM `logger` WHERE type = ? AND date >= ? AND date < ?And params Like '%MailChimp%';";
            $rt[] = Database::getNoClass(static::$_db, $req, [$id, $dat, $datUp])[0][0];
        }
        return ($rt);
    }
    public static function getNbrByIdForLastDaysTwitter($id) {
        $i = 0;
        $rt = [];
        $dat = date("d/m/Y");
        $datUp = date("d/m/Y");
        $dat = Datetime::createFromFormat("d/m/Y H:i:s", $dat . " 00:00:00")->getTimestamp();
        $req = "SELECT count(*) FROM `logger` WHERE type = ? AND date >= ? AND params Like '%twitter%';";
        $rt[] = Database::getNoClass(static::$_db, $req, [$id, $dat])[0][0];
        for ($i = 0; $i < 10;$i++)
        {
            $datUp = $dat;
            $dat -= 86400;
            $req = "SELECT count(*) FROM `logger` WHERE type = ? AND date >= ? AND date < ?And params Like '%twitter%';";
            $rt[] = Database::getNoClass(static::$_db, $req, [$id, $dat, $datUp])[0][0];
        }
        return ($rt);
    }
    public static function getNbrByIdForLastDaysFacebook($id) {
        $i = 0;
        $rt = [];
        $dat = date("d/m/Y");
        $datUp = date("d/m/Y");
        $dat = Datetime::createFromFormat("d/m/Y H:i:s", $dat . " 00:00:00")->getTimestamp();
        $req = "SELECT count(*) FROM `logger` WHERE type = ? AND date >= ? AND params Like '%facebook%';";
        $rt[] = Database::getNoClass(static::$_db, $req, [$id, $dat])[0][0];
        for ($i = 0; $i < 10;$i++)
        {
            $datUp = $dat;
            $dat -= 86400;
            $req = "SELECT count(*) FROM `logger` WHERE type = ? AND date >= ? AND date < ?And params Like '%facebook%';";
            $rt[] = Database::getNoClass(static::$_db, $req, [$id, $dat, $datUp])[0][0];
        }
        return ($rt);
    }
    public static function getNbrByIdForLastDaysLinkedin($id) {
        $i = 0;
        $rt = [];
        $dat = date("d/m/Y");
        $datUp = date("d/m/Y");
        $dat = Datetime::createFromFormat("d/m/Y H:i:s", $dat . " 00:00:00")->getTimestamp();
        $req = "SELECT count(*) FROM `logger` WHERE type = ? AND date >= ? AND params Like '%linkedin%';";
        $rt[] = Database::getNoClass(static::$_db, $req, [$id, $dat])[0][0];
        for ($i = 0; $i < 10;$i++)
        {
            $datUp = $dat;
            $dat -= 86400;
            $req = "SELECT count(*) FROM `logger` WHERE type = ? AND date >= ? AND date < ?And params Like '%linkedin%';";
            $rt[] = Database::getNoClass(static::$_db, $req, [$id, $dat, $datUp])[0][0];
        }
        return ($rt);
    }

    public static function getNbrByIdForLastDaysApi($id) {
        $i = 0;
        $rt = [];
        $dat = date("d/m/Y");
        $datUp = date("d/m/Y");
        $dat = Datetime::createFromFormat("d/m/Y H:i:s", $dat . " 00:00:00")->getTimestamp();
        $req = "SELECT count(*) FROM `logger` WHERE type = ? AND date >= ? AND params Like '%api%';";
        $rt[] = Database::getNoClass(static::$_db, $req, [$id, $dat])[0][0];
        for ($i = 0; $i < 10;$i++)
        {
            $datUp = $dat;
            $dat -= 86400;
            $req = "SELECT count(*) FROM `logger` WHERE type = ? AND date >= ? AND date < ?And params Like '%api%';";
            $rt[] = Database::getNoClass(static::$_db, $req, [$id, $dat, $datUp])[0][0];
        }
        return ($rt);
    }

    public static function getNbrByIdForLastDaysLinxo($id) {
        $i = 0;
        $rt = [];
        $dat = date("d/m/Y");
        $datUp = date("d/m/Y");
        $dat = Datetime::createFromFormat("d/m/Y H:i:s", $dat . " 00:00:00")->getTimestamp();
        $req = "SELECT count(*) FROM `logger` WHERE type = ? AND date >= ? AND params Like '%linxo%';";
        $rt[] = Database::getNoClass(static::$_db, $req, [$id, $dat])[0][0];
        for ($i = 0; $i < 10;$i++)
        {
            $datUp = $dat;
            $dat -= 86400;
            $req = "SELECT count(*) FROM `logger` WHERE type = ? AND date >= ? AND date < ?And params Like '%linxo%';";
            $rt[] = Database::getNoClass(static::$_db, $req, [$id, $dat, $datUp])[0][0];
        }
        return ($rt);
    }

    public static function getNbrByIdForFirstTime($id)
	{
		$dat = new DateTime("NOW"); 
		$dat->setTime(0,0,0);
		$dat = $dat->getTimestamp();
		$datUp = new DateTime("NOW");
		$datUp->setTime(23,59,59);
		$datUp = $datUp->getTimestamp();
		$req = "SELECT COUNT(DISTINCT `id_client`) FROM `logger` WHERE `type` = ? GROUP BY `type`, `id_executant`, `id_client` HAVING MIN(`date`) >= ? AND MIN(`date`) < ? ORDER BY MIN(`date`)";
		for ($i = 0; $i <= 10; $i++)
		{
			$rt[] = Database::getNoClass(static::$_db, $req, [$id, $dat, $datUp])[0][0];
			/*
			$tmp = Database::getNoClass(static::$_db, $req, [$id, $dat, $datUp]);
			if (isset($tmp[0]))
				$rt[]  = $tmp[0][0];
				*/
			$datUp = $dat;
			$dat -= 86400;
		}
		return ($rt);
	}


}
