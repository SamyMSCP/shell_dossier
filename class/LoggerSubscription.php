<?php
require_once("core/Database.php");
require_once("core/Table.php");

class LoggerSubscription extends Table
{
	protected static		$_name = "logger_subscription";
	protected static		$_primary_key = "id";

	/**
		id_souscripteur :
		0 systeme
		-1 yoda
		-2 conseiller du client
		-3 backoffice
		-4 developpeur
	**/

	public function __construct() {}
	public static function	newSubscription(
		$type_name,
		$type_subscription = 1,
		$id_souscripteur = -1,
		$id_executant = -1,
		$id_client = -1,
		$params = []
	) {
		$type = TypeLogger::getByName($type_name);
		/// Il faut checker que tout les parametres requis pour ce type de logs est bien present !
		if (!$type)
			return (false);
		$req = "INSERT INTO `logger_subscription` (
			id_type_logger,
			id_souscripteur,
			id_executant,
			id_client,
			type_subscription
			) VALUES (?, ?, ?, ?, ?)";
		$data = [
			$type->id,
			$type_subscription,
			$id_executant,
			$id_client,
			//$params,
			$type_subscription
		];
		return Database::prepareInsert(static::$_db, $req, $data);
	}
	public static function getForLog($log) {
		$req = "SELECT * FROM `logger_subscription`
			WHERE id_type_logger = ?
			AND (id_executant = ? OR id_executant = -1)
			AND (id_client = ? OR id_client = -1)
		";
		$data = [
			$log->getTypeId(),
			$log->id_executant,
			$log->id_client
		];
		return Database::prepare(static::$_db, $req, $data, "LoggerSubscription");
	}
	public static function dispatch($log) {
		$destinataire = self::getForLog($log);
		foreach ($destinataire as $key => $elm)
		{
			$elm->execute($log);
		}
	}
	public function execute($log)
	{
		if ($this->id_souscripteur > 0 )
			$destinataire = $this->id_souscripteur;
		else if ($this->id_souscripteur == -1)
			$destinataire = 1;
		else if ($this->id_souscripteur == -2)
			$destinataire = Dh::getById($log->id_client)->getConseiller()->id_dh;
		else if ($this->id_souscripteur == -3)
			;// Envoi aux comptes backoffice
		else if ($this->id_souscripteur == -4)
			;// Envoi aux comptes developpeurs
			
		$type_subscription = TypeSubscription::getFromId($this->type_subscription)[0];
		$type_logger_params = TypeLogger::getFromId($this->id_type_logger)[0]->getParams();
		$log_params = $log->getParams();
		$data = [
		];
		foreach ($type_subscription->getParams() as $key => $elm)
		{
			if (isset($type_logger_params[$elm]))
				$data[$elm] = $log->render($type_logger_params[$elm]);
			else
				$data[$elm] = '';
		}
		foreach ($type_subscription->getParams() as $key => $elm)
		{
			if (isset($log_params[$elm]))
				$data[$elm] = $log->render($log_params[$elm]);
		}
		$data['dh'] = $destinataire;
		$class = $type_subscription->class;
		$methode = $type_subscription->methode;
		$class::$methode($data);
		//dbg($destinataire->getShortName());
	}
}
