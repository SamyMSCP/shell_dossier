<?php
require_once("core/Database.php");
require_once("core/Table.php");


class HistoriqueStats extends Table {
	protected static		$_name = "historique_stats";
	protected static		$_primary_key = "id";
	public static			$_noSecure = ['datas'];


	public static function createNew($stats) {
		$req = "INSERT INTO `historique_stats`(datas, date_creation) VALUES(?, ?);";
		$datas = [
			serialize($stats),
			time()
		];
		return Database::prepareInsertCheckSecurity(static::$_db, $req, $datas, 'HistoriqueStats');
	}
	public function getDatas() {
		return (mb_unserialize($this->datas));
	}
}
