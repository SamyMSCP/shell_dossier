<?php
require_once("class/core/AjaxClient.php");
class RestTransaction extends AjaxClient
{
	public function readTransaction($data)
	{
		if (!empty($data['id']) && ($trans = Transaction::getFromId($data['id'])))
			success(["transaction" => $trans[0]->getForFrontStore()]);
		error();
	}

	public function readAllTransaction($data)
	{
		global $curDh;

		if (!isset($curDh))
			$curDh = Dh::getCurrent();

		$transactions = [];
		if (($tr = $curDh->getTransaction()))
		{
			foreach ($tr as $k => $v)
			{
				$transactions[] = $v->getForFrontStore();
			}
		}
		success(["transactions" => $transactions]);
	}

	public function createTransaction($data)
	{
		global $curDh;

		if (!isset($curDh))
			$curDh = Dh::getCurrent();

		$date = time() - 86400;
		if (count(Logger::getByTypeExecutantSince('Ajout d\'une transaction front client', $curDh->id_dh, $date)) >= MAX_TRANSACTION_PER_DAY)
		{
			Notif::set('Transactions', 'Vous avez atteint le maximum d\'ajout de transaction sous ces dernières 24H.');
			error([]);
		}

		if (empty($data['scpi']) || !($scpi = Scpi::getFromId($data['scpi'])) || !$scpi->isShow())
			error('SCPI incorrecte.');


		$nbr_part = trim($data['part']);
		if (empty($nbr_part) || !preg_match("/^\d{1,}((\.|,)(\d{1,5}))?$/", $nbr_part))
			error('Parts incorrectes.');
		$nbr_part = floatval(str_replace(',','.',$nbr_part));

		if (empty($data['propriete']) || !in_array($data['propriete'], Transaction::getTypeProLst()))
			error('Propriété incorrecte.');

		$date = 0;
		$date2 = null;
		if (!empty($data['date']))
		{
			if (!($date2 = DateTime::createFromFormat("Y-m-d", $data["date"])))
				$date2 = DateTime::createFromFormat("d/m/Y", $data["date"]);
			if ($date2 instanceof DateTime)
				$date = ft_crypt_information($date2->format("d/m/Y"));
			else
				error("Date d'enregistrement incorrect.");
		}

		if (!empty($data['marche']) && $data['marche'] != "-")
		{
			if (!in_array($data['marche'], Transaction::getMarcheLst()))
				error('Marché incorrect.');
		}
		$marche = $data['marche'];

		$prix = 0;
		if (!empty($data['prix']))
		{
			if (!preg_match("/^\d{1,}((\.|,)(\d{1,5}))?$/", $data['prix']))
				error("Prix incorrect.");
			$prix = floatval(str_replace(',','.', $data['prix']));
		}

		if ($data['propriete'] == "Pleine propriété")
		{
			$duree = null;
			$cle = "100.0";
			$viager = 0;
		}
		else
		{
			$cle = trim($data['cle']);
			if (empty($cle) || !preg_match("/^\d{1,2}((\.|,)(\d{1,5}))?$/", $cle))
				error("Clé de répartition incorrect.");
			$cle = floatval(str_replace(',','.', $cle));

			if (empty($data['type_demembrement']) || !in_array($data['type_demembrement'], Transaction::getTypeDemembrementLst()))
				error("Type de démembrement incorrect.");
			$viager = $duree = 0;

			if ($data['type_demembrement'] == "Temporaire")
			{
				$duree = intval($data['duree']);
				if (empty($data['duree']) || empty(($duree = intval($data['duree']))) || $duree < 1 || $duree > 20)
					error("Durée de démembrement incorrect.");
			}
			else
				$viager = 1;

			if ($data['propriete'] == "Usufruit")
				$cle = 100.0 - $cle;
		}

		$information = "";
		if (!empty($data['informations']))
			$information = substr(htmlspecialchars($data['informations']), 0 , 100);

		$montant_emprunt = $duree_emprunt = $date_debut_emprunt = $taux_emprunt = $mensualite_emprunt = 0;

		if (!empty($data['montant_emprunt']))
		{
			if (intval($data['montant_emprunt']) > $prix * $nbr_part)
				error("Montant emprunt incorrect");
			$montant_emprunt = intval($data['montant_emprunt']);
		}

		if (!empty($data['duree_emprunt']))
		{
			if (intval($data['duree_emprunt']) > 240)
				error("Durée emprunt incorrecte");
			$duree_emprunt = intval($data['duree_emprunt']);
		}

		if ($data['date_debut_emprunt'])
		{
			if (!($date_debut_emprunt = DateTime::createFromFormat("Y-m-d", $data["date_debut_emprunt"])))
				$date_debut_emprunt = DateTime::createFromFormat("d/m/Y", $data["date_debut_emprunt"]);
			if ($date_debut_emprunt instanceof DateTime)
				$date_debut_emprunt = ft_crypt_information($date_debut_emprunt->format("d/m/Y"));
			else
				error("Date début emprunt");
		}

		if (!empty($data['taux_emprunt']))
		{
			if (!preg_match("/^\d{1,2}((\.|,)(\d{1,2}))?$/", $data['taux_emprunt']))
				error("Taux d'emprunt incorrect.");
			$taux_emprunt = floatval(str_replace(',', '.', $data['taux_emprunt']));
		}

		if (!empty($data['mensualite_emprunt']))
		{
			if (!preg_match("/^\d{1,2}((\.|,)(\d{1,2}))?$/", $data['mensualite_emprunt']))
				error("Mensualite d'emprunt incorrect.");
			$mensualite_emprunt = $data['mensualite_emprunt'];
		}

		$rt = Transaction::insertOtherTransactionPleine($curDh->id_dh,
			$information,
			$date,
			ft_crypt_information($data['marche']),
			ft_crypt_information($data['propriete']),
			$nbr_part,
			$prix,
			$data['scpi'],
			ft_crypt_information($scpi->getName()),
			$duree,
			ft_crypt_information($cle),
			$viager,
			$montant_emprunt,
			$duree_emprunt,
			$date_debut_emprunt,
			$taux_emprunt,
			$mensualite_emprunt
		);

		if (empty($rt))
			error("Impossible d'ajouter cette transaction.");
// DONT USE THAT, WE USE AJAX !
//		Notif::set("addTransaction", "La transaction a bien été ajoutée à votre portefeuille.");
		if ($date2 === null)
			$date3 = "";
		else
			$date3 = $date2->format('d/m/Y');
		$params = [
			"scpi" => $scpi->getName(),
			"nbr_part" => $nbr_part,
			"prix" => $prix,
			"type pro" => $data['propriete'],
			"marcher" => $marche,
			"date enregistrement" => $date3,
			"duree" => $duree,
			"cle" => $cle,
			"information" => $information
		];
		Logger::setNew("Ajout d'une transaction front client", $curDh->id_dh, $curDh->id_dh, $params);
		$curDh->regenerateCacheArrayTable();
		success([$data]);
	}

	public function sellTransaction($data)
	{
		global $curDh;

		if (!isset($curDh))
			$curDh = Dh::getCurrent();

		if (!empty($data['date_sell']) && !empty($data['nbr_part_sell']) && !empty($data['prix_part_sell']) && !empty($data['transaction_id']) && ($t = Transaction::getFromId($data['transaction_id'])) && $t[0]->getDh()->id_dh == $curDh->id_dh)
		{
			$t = $t[0];
			$date_sell = new DateTime();
			if (!$date_sell->setTimestamp(intval($data['date_sell'])))
				error("Date de vente incorrecte.");

			$nbr_part_sell = floatval(str_replace(',','.', trim($data['nbr_part_sell'])));
			if (!preg_match("/^\d{1,}((\.|,)(\d{1,5}))?$/", trim($data['nbr_part_sell'])))
				error("Nombre de part incorrect.");

			$prix_part_sell = floatval(str_replace(',','.', trim($data['prix_part_sell'])));
			if (!preg_match("/^\d{1,}((\.|,)(\d{1,5}))?$/", trim($data['prix_part_sell'])))
				error("Prix de vente unitaire net vendeur incorrect.");

			if ($t->getEnrDate() instanceof DateTime)
			{
				if ($t->getEnrDate() > $date_sell)
					error("Vous ne pouvez avoir vendu des parts avant de les avoir achetées.");
			}

			if (($_t = Transaction::createNewSellTransaction($t->getId(),$date_sell,$nbr_part_sell,$prix_part_sell, $curDh->getCacheArrayTable(), 1)))
			{
				$params = [
					"objet" => "Ajout d'une transaction de vente",
					"transaction_id" => $data["transaction_id"],
					"scpi_name" => $t->getScpi()->name,
					"date" => $date_sell->format('d/m/Y'),
					"nbr_part" => $nbr_part_sell,
					"prix" => $prix_part_sell,
				];
				Logger::setNew("Ajout d'une transaction front client", $curDh->id_dh, $curDh->id_dh, $params);
				$curDh->regenerateCacheArrayTable();
				success(['transaction_id' => $_t]);
			}
		}
		error("Merci de vérifier votre saisie");
	}
	public function deleteTransaction($data)
	{
		global $curDh;

		if (!isset($curDh))
			$curDh = Dh::getCurrent();

		if (!empty($data['id']) && !empty(($t = Transaction::getById($data['id']))) && $t->id_donneur_ordre == $curDh->id_dh && !$t->doByMscpi())
		{
			$hasDoc = false;
			foreach ($t->getDocs as $doc)
			{
				if (!empty($doc))
				{
					$hasDoc = 1;
					break ;
				}
			}
			if (!$hasDoc && $t->remove())
			{
				$curDh->regenerateCacheArrayTable();
				success(['Transaction supprimée']);
			}
		}
		error(["Vous ne pouvez pas supprimer cette transaction."]);
	}

	public function updateTransaction($data)
	{
		global $curDh;

		$err = [];
		$date_time = new DateTime();

		if (!isset($curDh))
			$curDh = Dh::getCurrent();
		if (!empty($data['id']) && !empty(($t = Transaction::getById($data['id']))) && $t->id_donneur_ordre == $curDh->id_dh)
		{
			if ($t->doByMscpi())
				error("Vous ne pouvez pas modifier une transaction MeilleureSCPI.com");
			// Date d'enregistrement
			$ed = clone $date_time;
			$ed->setTimestamp(intval($data['enr_date']));
			if (!$ed)
				$err[] = "Date enregistrement invalide";
			else if (!empty($data['enr_date']) && (!$t->getEnrDate() || $data['enr_date'] != $t->getEnrDate()->getTimestamp()))
				$t->updateOneColumn('enr_date', ft_crypt_information($ed->format("d/m/Y")));

			if ($t->getTypeTransaction() == 'V')
			{
				// Nombre de part
				$nbr_part = floatval(str_replace(',','.', trim($data['nbr_part'])));
				if (!preg_match("/^\d{1,}((\.|,)(\d{1,5}))?$/", trim($data['nbr_part']))
					|| $nbr_part <= 0.0)
				{
					$err[] = "Le nombre de parts est invalide";
				}
				else if (-$nbr_part != $t->getNbrPart())
				{
					$t->updateOneColumn('nbr_part_vente', $nbr_part);
					$t->updateOneColumn('nbr_part', -$nbr_part);
				}
				// Prix par part
				$prix_part = floatval(str_replace(',','.', trim($data['prix_part'])));
				if (!preg_match("/^\d{1,}((\.|,)(\d{1,5}))?$/", trim($data['prix_part']))
					|| $prix_part <= 0.0)
				{
					$err[] = "Le prix par parts est invalide";
				}
				else if ($prix_part != $t->prix_part_vente)
				{
					$t->updateOneColumn('prix_part_vente', $prix_part);
				}
			}
			else
			{
	// Bénéficiaire
				if (!empty($data['id_beneficiaire']) && $t->id_beneficiaire != $data['id_beneficiaire'])
				{
					if (!empty(($rt = Beneficiaire::getById($data['id_beneficiaire']))) && $rt->getDh()->id_dh == $curDh->id_dh)
						$t->updateOneColumn('id_beneficiaire', $data['id_beneficiaire']);
					else
						$err[] = "Bénéficiaire incorrect";
				}
	// Info transaction
				if ($data['info_trans'] == "MS.C" && !$t->doByMscpi())
					$err[] = "Merci de vérifier votre saisie pour le champ 'Effectué par'";
				if ($data['info_trans'] !== $t->getInfoTransaction())
					$t->updateOneColumn('info_trans', $data['info_trans']);
	// Marché
				if ($data['marcher'] != $t->getMarcher())
				{
					if (in_array($data['marcher'], Transaction::getMarcheLst()))
						$t->updateOneColumn('marcher', ft_crypt_information($data['marcher']));
					else
						$err[] = "Marché incorrect";
				}
	// Type propriété
				if ($data['type_pro'] != $t->getTypePro())
				{
					if (in_array($data['type_pro'], Transaction::getTypeProLst()))
						$t->updateOneColumn('type_pro', ft_crypt_information($data['type_pro']));
					else
						$err[] = "Type de propriété incorrect";
				}
				if ($t->getTypePro() == "Pleine propriété")
				{
					if ($t->getClefRepartition() != 100)
						$t->updateOneColumn('cle_repartition', "");
					if (!empty($t->getDuree()))
						$t->updateOneColumn('dt', 0);
					if (!empty($t->viager))
						$t->updateOneColumn('viager', 0);
				}
				else
				{
	// Clé de répartition
					$cle = floatval(str_replace(',','.', $data['cle_repartition']));
					if ($cle <= 0 || $cle >= 100.0)
						$err[] = "Clé de répartition incorrecte";
					elseif (!empty($cle) && $cle != $t->getClefRepartition())
					{
						if ($t->getTypePro() == "Usufruit")
							$cle = 100.0 - $cle;
						$t->updateOneColumn('cle_repartition', ft_crypt_information($cle));
					}
	// Durée de démembrement
					// if ($data[''])
					$dt = intval($data['dt']);
					if ($dt < 0 || $dt > 20)
						$err[] = "Durée de démembrement incorrecte";
					elseif ($dt != $t->getDuree())
					{
						if ($dt == 0)
							$t->updateOneColumn('viager', 1);
						else
						{
							if ($t->viager)
								$t->updateOneColumn('viager', 0);
							$t->updateOneColumn('dt', $dt);
						}
					}
				}
	// Nombre de part
				$nbr_part = floatval(str_replace(',','.', trim($data['nbr_part'])));
				if (!preg_match("/^\d{1,}((\.|,)(\d{1,5}))?$/", trim($data['nbr_part'])) || $nbr_part <= 0.0)
					$err[] = "Le nombre de parts est invalide";
				elseif ($nbr_part != $t->getNbrPart())
					$t->updateOneColumn('nbr_part', $nbr_part);
	// Prix par part
				$prix_part = floatval(str_replace(',','.', trim($data['prix_part'])));
				if (!preg_match("/^\d{1,}((\.|,)(\d{1,5}))?$/", trim($data['prix_part'])) || $prix_part < 1.0)
					$err[] = "Le prix par parts est invalide";
				elseif ($prix_part != $t->getPrixPart())
					$t->updateOneColumn('prix_part', $prix_part);
	// Emprunt
				if (!empty($data['montant_emprunt']) || !empty($data['type_emprunt']) || !empty($data['duree_emprunt']) || !empty($data['date_debut_emprunt']) || !empty($data['taux_emprunt']) || !empty($data['mensualite_emprunt']))
				{
		// Montant de l'emprunt
					$montant_emprunt = floatval(str_replace(',','.', trim($data['montant_emprunt'])));
					if (!preg_match("/^\d{1,}((\.|,)(\d{1,5}))?$/", trim($data['montant_emprunt'])) || $montant_emprunt > $t->getNbrPart() * $t->getPrixPart())
						$err[] = "Montant emprunt incorrect";
					elseif ($data['montant_emprunt'] != $t->montant_emprunt)
						$t->updateOneColumn('montant_emprunt', $montant_emprunt);
		// Type de l'emprunt
					if (!in_array($data['type_emprunt'], ["Amortissable","In Fine"]))
						$err[] = "Type emprunt incorrect";
					elseif ($data['type_emprunt'] != $t->type_emprunt)
						$t->updateOneColumn('type_emprunt', $data['type_emprunt']);
		// Duree de l'emprunt
					$de = intval($data['duree_emprunt']);
					if (empty($data['duree_emprunt']) || $de > 100)
						$err[] = "Durée emprunt incorrecte";
					else if ($de != $t->duree_emprunt)
						$t->updateOneColumn('duree_emprunt', $de);
		// Date de début de l'emprunt
					$dde = clone $date_time;
					$dde->setTimestamp($data['date_debut_emprunt']);
					if (!$dde)
						$err[] = "Date début emprunt invalide";
					else if ($dde != $t->date_debut_emprunt)
						$t->updateOneColumn('date_debut_emprunt', $dde);
		// Taux de l'emprunt
					if (!preg_match("/^\d{1,}((\.|,)(\d{1,5}))?$/", $data['taux_emprunt']))
						$err[] = "Taux emprunt invalide";
					else if ($data['taux_emprunt'] != $t->taux_emprunt)
						$t->updateOneColumn('taux_emprunt', $data['taux_emprunt']);
		// Mensualité de l'emprunt
					if (!preg_match("/^\d{1,}((\.|,)(\d{1,5}))?$/", $data['mensualite_emprunt']))
						$err[] = "Mensualité emprunt invalide";
					else if ($data['mensualite_emprunt'] != $t->mensualite_emprunt)
						$t->updateOneColumn('mensualite_emprunt', $data['mensualite_emprunt']);
				}
			}
			$curDh->regenerateCacheArrayTable();
			if (!empty($err))
				error(implode($err, "<br />"));
			success(["transaction" => $t->getForFrontStore()]);
		}
		error("Une erreur c'est produite ! - Fin");
	}

	public function getAllDocument($data)
	{
		global $curDh;

		if (!isset($curDh))
			$curDh = Dh::getCurrent();
		if (empty($data['id']) || empty(($t = Transaction::getById($data['id']))) || (isProd() && $tr->id_donneur_ordre != $curDh->id_dh))
			error();
		success(['docs' => $t->getAllDocument()]);
	}

	public function getDocument($data)
	{
		global $curDh;

		if (!isset($curDh))
			$curDh = Dh::getCurrent();

		if (empty($data['id_transaction']) || empty($data['id_type_document']) || empty(($doc = Document::getFromIdTypeIdEntity($data['id_type_document'], 8, $data['id_transaction']))) || (isProd() && $doc[0]->getEntity()[0]->id_donneur_ordre != $curDh->id_dh))
			error();
		else
		{
			header('Content-Type: '. $doc[0]->type);
			header('Content-Disposition: inline');
			echo ft_decode_file($doc[0]->data);
			exit();			
		}
	}

	public function saveDocument($data)
	{
		global $curDh;

		if (!isset($curDh))
			$curDh = Dh::getCurrent();

		// On vérifie si la transaction existe et qu'elle appartient bien au Dh connecté
		if (
			empty($data['id_transaction']) ||
			empty(($tr = Transaction::getById($data['id_transaction']))) ||
			(
				isProd() &&
				$tr->id_donneur_ordre != $curDh->id_dh
			) &&
			empty($data['id_type_document'])
		)
			error('You');
		// On vérifie qu'il n'existe pas déjà un doc de ce type pour la transaction spécifiée
		if (Document::getFromIdTypeIdEntity($data['id_type_document'], 8, $data['id_transaction']))
			error('Un document de ce type existe déjà pour cette transaction');

		if (
			!empty($_FILES['data']['tmp_name']['fichier']) &&
			!empty($_FILES['data']['name']['fichier'])
		)
		{
			if ($_FILES['data']['error']['fichier'] != UPLOAD_ERR_OK)
				error(self::$_FILES['data']['error']['fichier']);
			$type = mime_content_type($_FILES['data']['tmp_name']['fichier']);
			if ($type != "application/pdf")
				error("Le fichier doit être au format PDF");
			$content = ft_encryption_file($_FILES['data']['tmp_name']['fichier']);
			$name = $_FILES['data']['name']['fichier'];

			$id_new_doc = Document::insertNew($data['id_type_document'], 8, $data['id_transaction'], $content, $type, $name, '');
			if ($id_new_doc)
			{
				Crm2::insertNew($curDh->id_dh, 5, 1, time(), -2700, "Un document à été ajouté pour une transaction et doit être validé. <a href='admin_lkje5sjwjpzkhdl42mscpi.php?p=EditionClient&client={$tr->id_donneur_ordre}&transac={$data['id_transaction']}'>Cliquez-ici</a>", [], 0);
				$rt = Document::getFromId($id_new_doc);

				$doc = Document::getFromDocumentEntityId($id_new_doc)[0];

				$params = [
					"nom du fichier" => $doc->filename,
					"type de document" => $doc->getTypeDocument()->getName(),
					"id transaction" => intval($data['id_transaction']),
					"Document ajouté par" => Dh::getCurrent()->getShortName(),
				];
				Logger::setNew("Ajout document", $curDh->id_dh, $curDh->id_dh, $params);

				unset($rt['data']);

				success(['doc' => $rt]);
			}
		}
		error();
	}

	private function getError($const_err)
	{
		if ($const_err == UPLOAD_ERR_INI_SIZE)
			return "Le fichier est trop volumineux.";
		else
			return "Une erreur est survenue.";
	}
}
