<?php
require_once("class/core/Module.php");
require_once("class/core/Cache.php");
class ApercuDeMonPorteFeuilleAccueilOld extends Module
{
	use Cache;
	public $modal_content = "";
	public $tmp = 0;
	public $forTable = array(
		"sumVentePotentielle" => 0,
		"data" => array()
	);

	private static function toSortTable($a, $b) {
		return ($a["ventePotentielle"] < $b["ventePotentielle"]);
	}

	public function generateCacheModal() {
		ob_start();
		/*if (count($this->dh->getTransaction()) !== 0) {
			foreach($this->data as $name => $oneTransaction) {
				if ($name == "precalcul")
					continue ;
				foreach ($oneTransaction as $keyType => $dataType) {
					if ($keyType == "precalcul")
						continue ;
					if (count($dataType)) {
						include($this->getPath() . "modal_tmp.php");
					}
				}
			}
		}*/
		include($this->getPath() . "modal_new.php");
		$dataRt = ob_get_contents();
		ob_end_clean();
		return ($dataRt);
	}
	public static function genereateCacheForDh($id_dh) {
		$tmp = new ApercuDeMonPorteFeuillev2();
		$tmp->regenerateCacheModal($id_dh);
	}
	public function getLst() {
		return ($this->forTable);
	}
	public function insertNewTransaction() {
		if (!isset($_POST['SCPI']) || intval($_POST['SCPI']) < 1 || !isset($_POST['isMore']))
		{
			Notif::set("addTransaction", "Il y a eu un probleme lors de l'ajout de la transaction [0x1]");
			header("Location: ?p=Portefeuille");
			exit();
		}
		if (empty(trim($_POST['part'])) || !preg_match("/^\d{1,}((\.|,)(\d{1,5}))?$/", trim($_POST['part'])))
		{
			Notif::set("addTransaction", "Il y a eu un probleme lors de l'ajout de la transaction [0x2]");
			header("Location: ?p=Portefeuille");
			exit();
		}
		if (!isset($_POST['propriete']) ||
			($_POST['propriete'] != "Pleine propriété" && $_POST['propriete'] != "Nue propriété" && $_POST['propriete'] != "Usufruit")
		)
		{
			Notif::set("addTransaction", "Il y a eu un probleme lors de l'ajout de la transaction [0x3]");
			header("Location: ?p=Portefeuille");
			exit();
		}
		$scpi_name = ft_crypt_information(Scpi::getFromId($_POST['SCPI'])->name);
		$id_scpi = $_POST['SCPI'];
		$nbr_part = floatval(str_replace(',','.',$_POST['part']));
		$propriete = ft_crypt_information(htmlspecialchars($_POST['propriete']));
		$date = 0;
		$date2 = 0;
		if ((DateTime::createFromFormat("Y-m-d", $_POST["date"]) instanceof DateTime))
		{
			$date = ft_crypt_information(DateTime::createFromFormat("Y-m-d", $_POST["date"])->format("d/m/Y"));
			$date2 = DateTime::createFromFormat("Y-m-d", $_POST["date"])->format("d/m/Y");
		}
		else if ((DateTime::createFromFormat("d/m/Y", $_POST["date"]) instanceof DateTime))
		{
			$date = ft_crypt_information(DateTime::createFromFormat("d/m/Y", $_POST["date"])->format("d/m/Y"));
			$date2 = DateTime::createFromFormat("d/m/Y", $_POST["date"])->format("d/m/Y");
		}
		if (isset($_POST['marche']) && $_POST['marche'] != "-")
		{
			if ($_POST['marche'] == "Primaire" || $_POST['marche'] == "Secondaire" || $_POST['marche'] == "Gris à gris")
				$marche = ft_crypt_information(htmlspecialchars($_POST['marche']));
			else
			{
				Notif::set("addTransaction", "Il y a eu un probleme lors de l'ajout de la transaction [0x4]");
				header("Location: ?p=Portefeuille");
				exit();
			}
		}
		else
			//$marche = ft_crypt_information("Primaire");
			$marche = null;
		$prix = 0;
		if(isset($_POST['prix']))
			$prix = $_POST['prix'];
		$information = null;
		if (!empty($_POST['informations']))
		{
			$information = htmlspecialchars($_POST['informations']);
		}
		if ($_POST['propriete'] == "Pleine propriété")
		{
			$duree = null;
			$cle = null;
		}
		else if ($_POST['propriete'] == "Usufruit" || $_POST['propriete'] == "Nue propriété")
		{
			if (empty(trim($_POST['cle'])) || !preg_match("/^\d{1,2}((\.|,)(\d{1,5}))?$/", trim($_POST['cle'])))
			{
				Notif::set("addTransaction", "Il y a eu un probleme lors de l'ajout de la transaction [0x5]");
				header("Location: ?p=Portefeuille");
				exit();
			}
			if (!isset($_POST['type_demembrement']) || ($_POST['type_demembrement'] != "temporaire" && $_POST['type_demembrement'] != "viage"))
			{
				Notif::set("addTransaction", "Il y a eu un probleme lors de l'ajout de la transaction [0x6]");
				header("Location: ?p=Portefeuille");
				exit();
			}
			$viager = $duree = 0;

			if ($_POST['type_demembrement'] == "temporaire")
			{
				if (!isset($_POST['duree']) || $_POST['duree'] < 1 || $_POST['duree'] > 20)
				{
					Notif::set("addTransaction", "Il y a eu un probleme lors de l'ajout de la transaction [0x7]");
					header("Location: ?p=Portefeuille");
					exit();
				}
				$duree = $_POST['duree'];
			}
			else if ($_POST['type_demembrement'] == "viager")
				$viager = 1;
			$cle = floatval(str_replace(',','.',$_POST['cle']));
			if ($_POST['propriete'] == "Usufruit")
				$cle = 100.0 - $cle;
			$type_demembrement = $_POST['type_demembrement'];
			$cle = ft_crypt_information($cle);
		}
		else
		{
			Notif::set("addTransaction", "Il y a eu un probleme lors de l'ajout de la transaction [0x8]");
			header("Location: ?p=Portefeuille");
			exit();
		}
		$rt = Transaction::insertOtherTransactionPleine($this->dh->id_dh, $information, $date, $marche, $propriete, $nbr_part, $prix, $id_scpi, $scpi_name, $duree, $cle, $viager, $montant_credit, $duree_credit, $date_debut_credit, $taux_credit, $mensualite_credit);
		if (!empty($rt))
		{
			Notif::set("addTransaction", "La transaction a bien été enregistrée");
			$params = [
				"scpi" => Scpi::getFromId($_POST['SCPI'])->name,
				"nbr_part" => $nbr_part,
				"prix" => $prix,
				"type pro" => $_POST['propriete'],
				"marcher" => $marche,
				"date enregistrement" => $date2,
				"duree" => $duree,
				"cle" => $cle,
				"information" => $information
			];
			Logger::setNew("Ajout d'une transaction front client", Dh::getCurrent()->id_dh, $this->dh->id_dh, $params);
		}
		else
			Notif::set("addTransaction", "Il y a eu un probleme lors de l'ajout de la transaction  [0x9]");
		$this->dh->regenerateCacheArrayTable();
		header("Location: ?p=Portefeuille");
		exit();
	}
}
