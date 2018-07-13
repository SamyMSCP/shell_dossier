<?php
require_once("core/Database.php");
require_once("core/Table.php");

//TODO: Ajouter la verif du compte afin de savoir qui quoi comment
class Opportunity extends Table {
	protected static	$_name = "opportunity";
	protected static	$_primary_key = "id";
	public static		$_noSecure = [];


	public static function getAllForStore() {
		$data = self::getAll();
		$req = "SELECT COUNT(*) AS `tot` FROM `opportunity_interact` WHERE `op_id`=:id";
		$index = 0;
		foreach ($data as $line) {
			$ret = Database::prepare(static::$_db, $req, ['id' => $line->id], get_called_class());
			//$ret = Database::prepareNoClass(static::$_db, $req, ['id' => $line->id]);
			$data[$index]->inter = ($ret[0]->tot == null) ? 0 : $ret[0]->tot;
			$data[$index]->author = Dh::getById($data[$index]->id_author)->getShortName();
			//$data[$index]->inter = ($ret == null) ? 0 : $ret;
			$index++;
		}
		return ($data);
	}
	public static function getAllForFrontStore() {
		$data = self::getFromKeyValue("validated", "1");
		foreach ($data as $line)
		{
			$scpi = Scpi::getFromId($line->id_scpi);
			$line->url = $scpi->getUrl();
		}
		$list = [];
		$full_list = $data;
		foreach ($full_list as $el) {
			if ($el->state < 2)
				$list[] = $el;
		}
		return ($list);
	}
	private function updateOp($data, $admin) {
		$req = "UPDATE `opportunity` SET
		`type` = :type,
		`time_demembrement` = :time_dem,
		`price_per_part` = :price,
		`key_nue` = :key_nue,
		`nb_part` = :nb_part,
		`state` = :state,
		`partial_subscrib` = :partial";

		$data['type'] = intval($data['type']);
		$data['time_dem'] = intval($data['time_dem']);
		$data['price'] = floatval($data['price']);
		$data['key_nue'] = floatval($data['key_nue']);
		$data['nb_part'] = intval($data['nb_part']);
		$data['state'] = intval($data['state']);
		$data['partial'] = intval($data['partial']);

		if ($admin)
		{
			$req .= ", `validated` = :validated";
			$test = Database::prepare(static::$_db, "SELECT `validated`, `id_author`, `notif_client` FROM `opportunity` WHERE `id` = :id", ["id" => $data['id']], get_called_class());
			if ($test[0]->validated != $data['validated'] && $data['validated'] == 1)
			{
				$req .= ", `date` = CURRENT_TIMESTAMP";
				if ($test[0]->notif_client == 1 || (isset($data['notif_client']) && $data['notif_client'] == 1))
					MailSender::sendToDhWithTemplateName((Dh::getById(intval($test[0]->id_author))), "Votre Opportunité a été validée !", "", "validation_dopportunite");
			}
		}
		$req .= " WHERE `id` = :id";
		return (Database::prepareNoClass(static::$_db, $req, $data));
	}
	public function updateForClientAdmin($data){
		$req = "UPDATE `opportunity` SET
		`type` = :type,
		`id_scpi` = :id_scpi,
		`time_demembrement` = :time_demembrement,
		`price_per_part` = :price_per_part,
		`key_nue` = :key_nue,
		`nb_part` = :nb_part,
		`date` = CURRENT_TIMESTAMP,
		`state` = :state,
		`partial_subscrib` = :partial_subscrib,
		`id_author` = :id_author,
		`validated` = :validated,
		`notif_client` = :notif_client
		WHERE `id` = :id";

		$bind = [
			"id" => intval($data['id']),
			"type" => intval($data['type']),
			"id_scpi" => intval($data['id_scpi']),
			"time_demembrement" => intval($data['time_demembrement']),
			"price_per_part" => floatval($data['price_per_part']),
			"key_nue" => floatval($data['key_nue']),
			"nb_part" => intval($data['nb_part']),
			"state" => intval($data['state']),
			"partial_subscrib" => intval($data['partial_subscrib']),
			"id_author" => intval($data['id_author']),
			"validated" => intval($data['validated']),
			"notif_client" => intval($data['notif_client'])
		];

		return (Database::prepareNoClass(static::$_db, $req, $bind));
	}

	public function createForClientAdmin($data){
		$req = "INSERT INTO `opportunity` (
			`id`,
			`type`,
			`id_scpi`,
			`time_demembrement`,
			`price_per_part`,
			`key_nue`,
			`nb_part`,
			`date`,
			`state`,
			`partial_subscrib`,
			`id_author`,
			`validated`,
			`notif_client`) VALUES (
				NULL,
				:type,
				:id_scpi,
				:time_demembrement,
				:price_per_part,
				:key_nue,
				:nb_part,
				CURRENT_TIMESTAMP,
				:state,
				:partial_subscrib,
				:id_author,
				:validated,
				:notif_client
			)";

			if ($data['key_nue'] < 50.0)
				error("La Clé  de répartition n'est pas valide ! Elle doit être comprise entre 50 et 100 pour le nu et entre 0 et 50 pour l'usufruit");
			$bind = [
				"type" => intval($data['type']),
				"id_scpi" => intval($data['id_scpi']),
				"time_demembrement" => intval($data['time_demembrement']),
				"price_per_part" => floatval($data['price_per_part']),
				"key_nue" => floatval($data['key_nue']),
				"nb_part" => intval($data['nb_part']),
				"state" => intval($data['state']),
				"partial_subscrib" => intval($data['partial_subscrib']),
				"id_author" => intval($data['id_author']),
				"validated" => intval($data['validated']),
				"notif_client" => intval($data['notif_client'])
			];
		//$data['type'] = intval($data['type']);

		return (Database::prepareInsertCheckSecurity(static::$_db, $req, $bind, get_called_class()));
	}

	private function createOp($data, $admin) {
		$req = "INSERT INTO `opportunity` (
			`id`,
			`type`,
			`id_scpi`,
			`time_demembrement`,
			`price_per_part`,
			`key_nue`,
			`nb_part`,
			`date`,
			`state`,
			`partial_subscrib`,
			`id_author`,
			`validated`) VALUES (
				NULL,
				:type,
				:id_scpi,
				:time_dem,
				:price,
				:key_nue,
				:nb_part,
				CURRENT_TIMESTAMP,
				:state,
				:partial,
				:id_author,
				:validated);";
		if (!$admin)
			$data['validated'] = 0;

		$data['type'] = intval($data['type']);
		$data['id_scpi'] = intval($data['id_scpi']);
		$data['time_dem'] = intval($data['time_dem']);
		$data['price'] = floatval($data['price']);
		$data['key_nue'] = floatval($data['key_nue']);
		$data['nb_part'] = intval($data['nb_part']);
		$data['state'] = intval($data['state']);
		$data['partial'] = intval($data['partial']);
		$data['id_author'] = Dh::getCurrent()->id_dh;
		//$data['validated'] = 0;
		return (Database::prepareInsertCheckSecurity(static::$_db, $req, $data, get_called_class()));
	}

	private function deleteOp($data, $admin){
		$req = "DELETE FROM `opportunity`
		WHERE `id` = :id";
		return (Database::prepareInsertCheckSecurity(static::$_db, $req, $data, get_called_class()));
	}

	public function createUser($data) {
		if ($data['dem'] < 3 || $data['dem'] > 20)
			error("La durée du démembrement n'est pas valide");
		if ($data["crnp"] < 0 || $data["crnp"] > 100)
			error("Pinguin");
			$binddata = [
				"type" => $data['m_type'],
				"id_scpi" => $data['m_scpi'],
				"time_dem" => $data['dem'],
				"price" => $data['price_per_part'],
				"key_nue" => $data['crnp'],
				"nb_part" => $data['nb_part'],
				"state" => 0,
				"partial" => $data['partial'],
				"id_author" => Dh::getCurrent()->id_dh,
				"validated" => 0
			];
		return (($this->createOp($binddata, false)));
	}

	public function updateUser($data) {
		if (!isset($data['duree']) || $data['duree'] < 3 || $data['duree'] > 20)
			error("Impossible d'effectuer l'action. Les valeurs sont incorrecte.");
		if (!isset($data['key']) || $data["key"] < 0 || $data["key"] > 100)
			error("Impossible d'effectuer l'action. Les valeurs sont incorrecte.");
		$binddata = [
			"type" => $data['type'],
			"time_dem" => $data['duree'],
			"price" => ($data['part']),
			"key_nue" => $data['key'],
			"nb_part" => $data['parts'],
			"state" => intval($data['state']),
			"partial" => $data['partiel'],
			"id" => $data['id']
		];
		return ($this->updateOp($binddata, false));
	}

	public function deleteUser($data){
		if (!isset($data['id'])) //TODO: OU ne m'appartiens pas
			error("Impossible d'effectuer l'action. Les valeurs sont incorrecte.");
		$binddata = [
			"id" => intval($data['id'])
		];
		return ($this->deleteOp($binddata, false));
	}

	public function createAdmin($data) {
		if ($data['dem'] < 3 || $data['dem'] > 20)
			error("Impossible d'effectuer l'action. Les valeurs sont incorrecte.");
		if ($data["crnp"] < 0 || $data["crnp"] > 100)
			error("Impossible d'effectuer l'action. Les valeurs sont incorrecte.");
			$binddata = [
				"type" => $data['m_type'],
				"id_scpi" => $data['m_scpi'],
				"time_dem" => $data['dem'],
				"price" => $data['price_per_part'],
				"key_nue" => $data['crnp'],
				"nb_part" => $data['nb_part'],
				"state" => 0,
				"partial" => $data['partial'],
				"id_author" => Dh::getCurrent()->id_dh,
				"validated" => $data['validated']
			];
		return ($this->createOp($binddata, true));
	}

	public function updateAdmin($data) {
		if (!isset($data['duree']) || $data['duree'] < 3 || $data['duree'] > 20)
			error("Impossible d'effectuer l'action. Les valeurs sont incorrecte. (duree)");
		if (!isset($data['key']) || $data["key"] < 0 || $data["key"] > 100)
			error("Impossible d'effectuer l'action. Les valeurs sont incorrecte. (key)");
		$binddata = [
			"type" => $data['type'],
			"time_dem" => $data['duree'],
			"price" => $data['part'],
			"key_nue" => $data['key'],
			"nb_part" => $data['parts'],
			"state" => $data['state'],
			"partial" => $data['partiel'],
			"validated" => $data['active'],
			"id" => $data['id']
		];
		//error($data['partiel']);
		return ($this->updateOp($binddata, true));
	}

	public function deleteAdmin($data){
		if (!isset($data['id']))
			error("Impossible d'effectuer l'action. Les valeurs sont incorrecte.");
		$binddata = [
			"id" => intval($data['id'])
		];
		return ($this->deleteOp($binddata, true));
	}

	public function interrest($data)
	{
		$bindata = [
			"uid" => Dh::getCurrent()->id_dh,
			"opid" => intval($data['id']),
			"type" => 0
		];

		$req = "INSERT INTO `opportunity_interact` (
			`id`,
			`uid`,
			`op_id`,
			`type`,
			`date`) VALUES (
				NULL,
				:uid,
				:opid,
				:type,
				CURRENT_TIMESTAMP);";
		return (Database::prepareInsertCheckSecurity(static::$_db, $req, $bindata, get_called_class()));
	}

	public function count_interested($id){
		$bindata = [
			"id" => intval($id)
		];
		$req = "SELECT COUNT(*) AS `nb_interest` FROM `opportunity_interact` WHERE `op_id` = :id";
		return (Database::prepare(static::$_db, $req, $bindata, get_called_class()));
	}

	private function calculate_volume($data)
	{
		$d = 0;
		foreach ($data as $line)
		{
			if ($line->type == 1)
				$line->key_nue = 100.0 - floatval($line->key_nue);
			$key = $line->key_nue / 100.0;
			$d += $line->price_per_part * $line->nb_part * $key;
		}
		return ($d);
	}

	private function volume($type)
	{
		$req = "SELECT `price_per_part`, `nb_part`, `key_nue`, `type` FROM `opportunity` WHERE `type` = :type AND `state` <= 1";
		$binddata = ["type" => $type];
		$data = Database::prepare(static::$_db, $req, $binddata, get_called_class());
		return (Opportunity::calculate_volume($data));
	}

	private function volume_final($type, $is_final){
		$is_final = ($is_final) ? 2 : 3;
		$req = "SELECT `price_per_part`, `nb_part`, `key_nue`, `type` FROM `opportunity` WHERE `state` = :state";
		$binddata = [ "state" => $is_final ];
		if ($type != -1)
		{
			$binddata['type'] = $type;
			$req .= " AND `type` = :type";
		}
		$data = Database::prepare(static::$_db, $req, $binddata, get_called_class());
		return (Opportunity::calculate_volume($data));
	}

	public function getAllStats(){
		$req = [
			"SELECT COUNT(*) AS `nue_count` FROM `opportunity` WHERE `type` = 0 AND `state` <= 1",
			"SELECT COUNT(*) AS `usu_count` FROM `opportunity` WHERE `type` = 1 AND `state` <= 1",
			"SELECT COUNT(*) AS `op_total` FROM `opportunity` WHERE `state` <= 1",
			"SELECT COUNT(*) AS `nue_active` FROM `opportunity` WHERE `type` = 0 AND `state` = 0",
		];
		$data = [];
		foreach ($req as $cmd){
			$tmp = Database::prepare(static::$_db, $cmd, [], get_called_class());
			$tmp = get_object_vars($tmp[0]);
			foreach ($tmp as $key => $value) {
				if ($key != '_is_new')
					$data[$key] = $value;
			}
		}
		$data['nue_volume'] = Opportunity::volume(0);
		$data['usu_volume'] = Opportunity::volume(1);
		$data['total_volume'] = $data['usu_volume'] + $data['nue_volume'];

		$data['nb_final'] = Opportunity::volume_final(-1, true);
		$data['nb_final_nue'] = Opportunity::volume_final(0, true);
		$data['nb_final_usu'] = Opportunity::volume_final(1, true);
		$data['nb_not_final'] = Opportunity::volume_final(-1, false);
		$data['nb_not_final_nue'] = Opportunity::volume_final(0, false);
		$data['nb_not_final_usu'] = Opportunity::volume_final(1, false);
		return ($data);
	}

	public function getInterest(){
		$cmd = "SELECT `op_id`, `opportunity`.`type`, COUNT(*) AS `tot` FROM `opportunity_interact` INNER JOIN `opportunity` ON `opportunity`.`id`=`opportunity_interact`.`op_id` GROUP BY `op_id` ORDER BY `tot` DESC LIMIT 10";
		$data = Database::prepare(static::$_db, $cmd, [], get_called_class());
		return ($data);
	}

	public function getInterestType(){
		$cmd = "SELECT `opportunity`.`type`, COUNT(*) AS `tot` FROM `opportunity_interact` INNER JOIN `opportunity` ON `opportunity`.`id`=`opportunity_interact`.`op_id` GROUP BY `type` ORDER BY `tot` DESC";
		$data = Database::prepare(static::$_db, $cmd, [], get_called_class());
		return ($data);
	}

	public function stats_all()
	{
		$data = Opportunity::getAllStats();
		return ($data);
	}

	public function getPage($page){
		$start = (intval($page) - 1) * 3;
		$req = "SELECT * FROM `opportunity` WHERE `validated` = 1 AND `state` < 2 ORDER BY `date` DESC LIMIT " . intval($start) . ",3 ";
		$data = Database::prepare(static::$_db, $req, [], get_called_class());
		return ($data);
	}

	public function getMaxPage(){
		$req = "SELECT COUNT(*) AS `page` FROM `opportunity` WHERE `validated` = 1 AND `state` < 2";
		$data = Database::prepare(static::$_db, $req, [], get_called_class());
		return (intval($data[0]->page));
	}
	public function getScpi() {
		return (Scpi::getFromId($this->id_scpi));
	}
}
