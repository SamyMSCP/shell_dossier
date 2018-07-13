<?php
require_once("class/core/ModuleAdmin.php");
class SyntheseClient extends ModuleAdmin
{
	public function updateCommentaire() {
		if (!isset($_POST['commentaire']) || !isset($_POST['id_transaction']))
		{
			Notif::set("msgupdateCommentaire", "Le commentaire n'a pas pu etre enregistre");
			header("Location: ?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client']);
			exit();
		}
		$id_trans = intval($_POST['id_transaction']);
		$commentaire = htmlspecialchars($_POST['commentaire']);
		if ($id_trans < 0 || strlen($commentaire) >= 2500)
		{
			Notif::set("msgupdateCommentaire", "Le commentaire n'a pas pu etre enregistre");
			header("Location: ?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client']);
			exit();
		}
		$trans = Transaction::getFromId($id_trans);
		if (count($trans) == 0)
		{
			Notif::set("msgupdateCommentaire", "Le commentaire n'a pas pu etre enregistre");
			header("Location: ?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client']);
			exit();
		}
		$trans = $trans[0];
		if ($trans->id_donneur_ordre != $this->dh->id_dh)
		{
			Notif::set("msgupdateCommentaire", "Le commentaire n'a pas pu etre enregistre");
			header("Location: ?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client']);
			exit();
		}
		$trans->updateOneColumn("commentaire", ft_crypt_information($commentaire));
		$this->dh->regenerateCacheArrayTable();
		Notif::set("msgupdateCommentaire", "Le commentaire a bien ete enregistre");
		header("Location: ?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client']);
		exit();
	}
	public function updateStatusTrans() {
	/*
		if (!isset($_POST['id_transaction']) || !isset($_POST['nStatus']))
		{
			Notif::set("msgupdateStatusTransaction", "Le changement de status pour la transaction n'a pas pu etre effectue");
			header("Location: ?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client']);
			exit();
		}
		$id_trans = intval($_POST['id_transaction']);
		$nStatus = intval($_POST['nStatus']);
		if ($id_trans < 0 || $nStatus < 0)
		{
			Notif::set("msgupdateStatusTransaction", "Le changement de status pour la transaction n'a pas pu etre effectue");
			header("Location: ?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client']);
			exit();
		}
		$trans = Transaction::getFromId($id_trans);
		if (count($trans) == 0)
		{
			Notif::set("msgupdateStatusTransaction", "Le changement de status pour la transaction n'a pas pu etre effectue");
			header("Location: ?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client']);
			exit();
		}
		$trans = $trans[0];
		if ($trans->id_transaction != $this->dh->id_dh)
		{
			Notif::set("msgupdateStatusTransaction", "Le changement de status pour la transaction n'a pas pu etre effectue");
			header("Location: ?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client']);
			exit();
		}
		$trans->updateOneColumn("status_trans", $nStatus);
		$this->dh->regenerateCacheArrayTable();
		Notif::set("msgupdateStatusTransaction", "Le changement de status pour la transaction a bien ete effectue");
		header("Location: ?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client']);
		exit();
		*/
	}
	public function generateCacheModal() {
		ob_start();
		if (count($this->dh->getTransaction()) !== 0) {
			foreach($this->table as $name => $oneTransaction) {
				if ($name == "precalcul")
					continue ;
				foreach ($oneTransaction as $keyType => $dataType) {
					if ($keyType == "precalcul")
						continue ;
					if (count($dataType)) {
						include($this->getPath() . "modal_transactions.php");
					}
				}
			}
		}
//		include($this->getPath() . "modal_new.php");
		$dataRt = ob_get_contents();
		ob_end_clean();
		return ($dataRt);
	}
	public function updateTransactionBenefiaire()
	{
		//dbg($_POST);
		//exit();
		// Vérifier l'id de la transaction 'id_transaction' => intval
		if (
			!isset($_POST['id_transaction']) ||
			!isset($_POST['editNbrPart']) ||
			!isset($_POST['editPrixPart']) ||
			!isset($_POST['editMarche']) ||
			!isset($_POST['editType']) ||
			!isset($_POST['enr_date'])
		)
		{
			Notif::set("msgupdateTransaction", "Une des données requises pour mettre a jours la transaction est manquantes !");
			//dbg($_POST);
			//exit();
			header("Location: ?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client']);
			exit();
		}

		$date = 0;
		$date2 = 0;
		if ((DateTime::createFromFormat("Y-m-d", $_POST["enr_date"]) instanceof DateTime))
		{
			$date = ft_crypt_information(DateTime::createFromFormat("Y-m-d", $_POST["enr_date"])->format("d/m/Y"));
			$date2 = DateTime::createFromFormat("Y-m-d", $_POST["enr_date"])->format("d/m/Y");
		}
		else if ((DateTime::createFromFormat("d/m/Y", $_POST["enr_date"]) instanceof DateTime))
		{
			$date = ft_crypt_information(DateTime::createFromFormat("d/m/Y", $_POST["enr_date"])->format("d/m/Y"));
			$date2 = DateTime::createFromFormat("d/m/Y", $_POST["enr_date"])->format("d/m/Y");
		}

		$id_transaction = intval($_POST['id_transaction']);
		$editNbrPart = floatval(str_replace(',','.',$_POST['editNbrPart']));
		$editPrixPart = floatval(str_replace(',','.',$_POST['editPrixPart']));
		$editMarche = $_POST['editMarche'];
		$editType = $_POST['editType'];
		// Vérifier la valeur du nombre de parts 'editNbrPart' => intval
		if (
			$editNbrPart <= 0 ||
			$editPrixPart <= 0 ||
			($editMarche != "Primaire" && $editMarche != "Secondaire") ||
			($editType != "Nue propriété" && $editType != "Usufruit" && $editType != "Pleine propriété")
		)
		{
			Notif::set("msgupdateTransaction", "Une des données requises n'est pas conforme !");
			//dbg($_POST);
			//exit();
			header("Location: ?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client']);
			exit();
		}



		$trans = Transaction::getFromId($id_transaction);
		if (!count($trans))
		{
			Notif::set("msgupdateTransaction", "Une erreur est survenue lors de la mise jours de la transaction");
			header("Location: ?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client']);
			exit();
		}
		$trans = $trans[0];
		if ($trans->id_donneur_ordre != $this->dh->id_dh)
		{
			Notif::set("msgupdateTransaction", "erreur est survenue lors de la mise jours de la transaction (La transaction et la donneur d'oridre ne correspond pas)");
			header("Location: ?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client']);
			exit();
		}

		if(isset($_POST['editTransactinBeneficiaire']))
		{
			$ben = Beneficiaire::getFromId($_POST['editTransactinBeneficiaire']);
			if (count($ben))
			{
				$ben = $ben[0];
				if ($ben->id_dh != $this->dh->id_dh)
				{
					Notif::set("msgupdateTransaction", "erreur est survenue lors de la mise jours de la transaction (Le beneficiaire et la donneur d'oridre ne correspond pas)");
					header("Location: ?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client']);
					exit();
				}
				$trans->updateOneColumn("id_beneficiaire", $ben->id_benf);
				// On met a jour le beneficiaire de la transaction avec l'id du beneficiare choisi
				/*
				Notif::set("msgupdateTransaction", "Une erreur est survenue lors de la mise jours de la transaction");
				header("Location: ?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client']);
				exit();
				*/
			}
			else
			{
				// Pour le moment on ne fait rien.......
				// On met null dans l'id du beneficiare !
			}
		}


		if ($editType == "Nue propriété" || $editType == "Usufruit")
		{
			if (
				!isset($_POST['editCle']) ||
				!isset($_POST['editDuree'])
			)
			{
				Notif::set("msgupdateTransaction", "En Nue propriété ou Usufruit, la cle de repartition et la durée de démembrement ne sont pas facultatifs !");
				dbg($_POST);
				exit();
				header("Location: ?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client']);
				exit();
			}
			$editCle = floatval(str_replace(',','.',$_POST['editCle']));
			$editDuree = intval($_POST['editDuree']);
			$trans->updateOneColumn("cle_repartition", ft_crypt_information($editCle));
			$trans->updateOneColumn("dt", $editDuree);
		}
		else if ($editType != "Pleine propriété")
		{
			Notif::set("msgupdateTransaction", "Il y a un problème avec le type de propriété !");
			dbg($_POST);
			exit();
			header("Location: ?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client']);
			exit();
		}
		$trans->updateOneColumn('enr_date', $date);
		$trans->updateOneColumn("type_pro", ft_crypt_information($editType));
		$trans->updateOneColumn('nbr_part', $editNbrPart);
		$trans->updateOneColumn('prix_part', $editPrixPart);
		$trans->updateOneColumn('marcher', ft_crypt_information($editMarche));

		// Tout s'est bien passé en regenere le cache du client !
		$this->dh->regenerateCacheArrayTable();
		Notif::set("msgupdateTransaction", "La transaction a bien ete mise a jour");
		header("Location: ?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client']);
		exit();
	}

	public function insertNewTransaction() {
		if (!isset($_POST['SCPI']) || intval($_POST['SCPI']) < 1 || !isset($_POST['isMore']))
		{
			Notif::set("addTransaction", "Il y a eu un probleme lors de l'ajout de la transaction");
			header("Location: ?p=EditionClient&client=" . $GLOBALS['GET']['client']);
			exit();
		}
		if (empty($_POST['part']) || !preg_match("/^\d{1,}((\.|,)(\d{1,5}))?$/", $_POST['part']))
		{
			Notif::set("addTransaction", "Il y a eu un probleme lors de l'ajout de la transaction");
			header("Location: ?p=EditionClient&client=" . $GLOBALS['GET']['client']);
			exit();
		}
		if (!isset($_POST['propriete']) ||
			($_POST['propriete'] != "Pleine propriété" && $_POST['propriete'] != "Nue propriété" && $_POST['propriete'] != "Usufruit")
		)
		{
			Notif::set("addTransaction", "Il y a eu un probleme lors de l'ajout de la transaction");
			header("Location: ?p=EditionClient&client=" . $GLOBALS['GET']['client']);
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
				Notif::set("addTransaction", "Il y a eu un probleme lors de l'ajout de la transaction");
				header("Location: ?p=EditionClient&client=" . $GLOBALS['GET']['client']);
				exit();
			}
		}
		else
			//$marche = ft_crypt_information("Primaire");
			$marche = null;
		$prix = 0;
		if(isset($_POST['prix']))
			$prix = floatval(str_replace(',','.',$_POST['prix']));
		$information = null;
		if (isset($_POST['informations']) && !empty($_POST['informations']))
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
			if (!isset($_POST['cle']) || $_POST['cle'] < 1 || $_POST['cle'] > 99)
			{
				Notif::set("addTransaction", "Il y a eu un probleme lors de l'ajout de la transaction");
				header("Location: ?p=EditionClient&client=" . $GLOBALS['GET']['client']);
				exit();
			}
			if (!isset($_POST['type_demembrement']) || ($_POST['type_demembrement'] != "temporaire" && $_POST['type_demembrement'] != "viage"))
			{
				Notif::set("addTransaction", "Il y a eu un probleme lors de l'ajout de la transaction");
				header("Location: ?p=EditionClient&client=" . $GLOBALS['GET']['client']);
				exit();
			}
			$duree = 0;
			if ($_POST['type_demembrement'] == "temporaire")
			{
				if (!isset($_POST['duree']) || $_POST['duree'] < 1 || $_POST['duree'] > 20)
				{
					Notif::set("addTransaction", "Il y a eu un probleme lors de l'ajout de la transaction");
					header("Location: ?p=EditionClient&client=" . $GLOBALS['GET']['client']);
					exit();
				}
				$duree = $_POST['duree'];
			}
			$cle = floatval(str_replace(',','.',$_POST['cle']));
			if ($_POST['propriete'] == "Usufruit")
				$cle = 100.0 - $cle;
			$type_demembrement = $_POST['type_demembrement'];
			$cle = ft_crypt_information($cle);
		}
		else
		{
			Notif::set("addTransaction", "Il y a eu un probleme lors de l'ajout de la transaction");
			header("Location: ?p=EditionClient&client=" . $GLOBALS['GET']['client']);
			exit();
		}
		$viager = $montant_credit = $duree_credit = $date_debut_credit = $taux_credit = $mensualite_credit = 0;
		$rt = Transaction::insertOtherTransactionPleine($this->dh->id_dh, $information, $date, $marche, $propriete, $nbr_part, $prix, $id_scpi, $scpi_name, $duree, $cle, $viager, $montant_credit, $duree_credit, $date_debut_credit, $taux_credit, $mensualite_credit);
		if (!empty($rt))
		{
			Notif::set("addTransaction", "La transaction a bien été enregistrée");
			$params = [
				"scpi" => Scpi::getFromId($_POST['SCPI'])->name,
				"nbr_part" => $nbr_part,
				"prix" => $prix,
				"type pro" => $propriete,
				"marcher" => $marche,
				"date enregistrement" => $date2,
				"duree" => $duree,
				"cle" => $cle,
				"information" => $information
			];
			Logger::setNew("Ajout d'une transaction backoffice", Dh::getCurrent()->id_dh, $this->dh->id_dh, $params);
		}
		else
			Notif::set("addTransaction", "Il y a eu un probleme lors de l'ajout de la transaction");
		$this->dh->regenerateCacheArrayTable();
		header("Location: ?p=EditionClient&client=" . $GLOBALS['GET']['client']);
		exit();
	}
	public function deleteTransaction() {
		if (!isset($_POST['id_transaction']))
		{
			Notif::set('deleteTransaction', 'Il manque des données pour pouvoir supprimer cette transaction !');
			header("Location: ?p=EditionClient&client=" . $GLOBALS['GET']['client']);
			exit();
		}
		$id_trans = intval($_POST['id_transaction']);
		// On recupere la transaction 

		$trans = Transaction::getFromId($id_trans);
		if (empty($trans))
		{
			Notif::set('deleteTransaction', 'Cette transaction ne semble pas exister :(  ');
			header("Location: ?p=EditionClient&client=" . $GLOBALS['GET']['client']);
			exit();
		}
		$trans = $trans[0];

		// On verifie qu'elle appartien bien bien au donneur d'ordre $GLOBALS['GET']['client'];
		if ($trans->id_donneur_ordre != $GLOBALS['GET']['client'])
		{
			Notif::set('deleteTransaction', 'Cette transaction ne semble pas appartenir a ce donneur d\'ordre !');
			header("Location: ?p=EditionClient&client=" . $GLOBALS['GET']['client']);
			exit();
		}
		$trans->remove();

		// On la supprime;
		Notif::set('deleteTransaction', 'La transaction à bien été supprimée !');
		$this->dh->regenerateCacheArrayTable();
		header("Location: ?p=EditionClient&client=" . $GLOBALS['GET']['client']);
		exit();
	}
}
