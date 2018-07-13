<?php
require_once("class/core/Ajax.php");
class RestTransaction  extends Ajax
{
	/*
		id
		id_scpi
		type_pro
		nbr_part
		prix_part
		status_transaction
	*/

	public function reloadPrecalcul($data) {
		if (!isset($data['id']) || !intval($data['id']))
			error("Certaines variables nécéssaires sont manquantes !");
		success(["data" => Dh::getById(intval($data['id']))->getCacheArrayTable()]);
	}
	public function createTransaction($data)
	{
		//echo json_encode($data);
		//exit();
		//return (false);
		if (
			empty($data['id_dh']) ||
			empty($data['status_trans']) ||
			!isset($data['info_trans']) ||
			empty($data['id_projet'])
		)
			error("Certaines variables nécéssaires sont manquantes !");

		if (
			isset($data['marcher']) &&
			!empty($data['marcher']) &&
			$data['marcher'] != "Primaire" &&
			$data['marcher'] != "Secondaire"
		)
			error("Le Type de marché est invalide !");

		if ($data['status_trans'] != -1)
		{
			$status = preg_split("/-/", $data['status_trans']);
			if (count($status) != 2)
				error();
		}

		$nTrans = Transaction::insertForStore($data['id_dh'], $data['id_projet'], $data['info_trans']);
		if (empty($nTrans))
			error();

		$elm = Transaction::getFromId($nTrans)[0];

		if (isset($data['marcher']))
			$elm->updateOneColumn("Marcher", ft_crypt_information($data['marcher']));

		if (isset($data['id_beneficiaire']))
			$elm->updateOneColumn("id_beneficiaire", $data['id_beneficiaire']);

		$elm->updateOneColumn("nbr_part", 1);
		$elm->updateOneColumn("prix_part", Scpi::getFromId($elm->getScpiId())->getPrixAcquereur());

		if (!empty($data['doByMscpi']) && (intval($data['doByMscpi']) || $data['doByMscpi'] == "true"))
			$elm->setIsMscpi();


		$id_projet = intval($data['id_projet']);
		if ($id_projet != -1)
			$elm->updateOneColumn('id_projet', $id_projet);
		if (empty($elm))
			error();

		if ($data['status_trans'] != -1)
		{
			$nelm = new StatusTransaction();
			$nelm->setTransaction($elm);
			$nelm->setStatus(
				intval($status[0]),
				intval($status[1])
			);
			$rt = $nelm->insertIt();
		}

		$dh = $elm->getDh();
		if (empty($dh))
			error();
		$dh->regenerateCacheArrayTable();
		success($elm->getForStore());
	}

	public function readTransaction($data)
	{
		if (!empty($data['id']) && ($trans = Transaction::getFromId($data['id'])))
			success(["transaction" => $trans[0]->getForStore()]);
		error();
	}

	public function deleteTransaction($data)
	{
		if (!isset($data['id']))
			error();
		$id_trans = intval($data['id']);
		$trans = Transaction::getFromId($id_trans);
		if (empty($trans))
			error();
		$trans = $trans[0];
		$status = $trans->getStatusTransactionObject();
		if ($trans->doByMscpi() && $status->getStatus()[0] != 0)
			error("Vous ne pouvez pas supprimer une transaction effectuée par MeilleureSCPI.com qui n'est pas une transaction potentielle !");
		$dh = $trans->getDh();
		if (empty($dh))
			error();
		$trans->remove();
		$dh->regenerateCacheArrayTable();
		success(["id" => $id_trans]);
	}

	public function updateTransactionNew($data)
	{
/*
 * Verif informations obligatoires (bloque la mise à jour)
 */
// Id transaction
		if (empty($data['id']) || !($tr = Transaction::getById($data['id'])))
			error("La transaction n'existe pas.");
// Id DH
		if (empty($data['id_donneur_ordre']) || $tr->id_donneur_ordre != intval($data['id_donneur_ordre']))
			error("Le donneur d'ordre ne correspond pas.");
// Type propriété
		if (empty($data['type_pro']) || !in_array($data['type_pro'], Transaction::getTypeProLst()))
			error("Type de propriété inconnu.");
// Id SCPI
		if (empty($data['id_scpi']) || !($scpi = Scpi::getFromId($data['id_scpi'])))
			error("Aucune SCPI associée à la transaction.");
// Type de transaction
		if (empty($data['type']) || $data['type'] != $tr->getTypeTransaction())
			error("Le type de transaction n'est pas modifiable.");
/*
 * Informations optionnelles (erreurs non bloquantes)
 */
		$err = [];
// doByMscpi
		if (!empty($data['doByMscpi']) && $data['doByMscpi'] != $tr->doByMscpi())
			$tr->setIsMscpi();
// Id Excel
		if (!empty($data['id_excel']) && ($tr_x = Transaction::getFromKeyValue('id_excel', intval($data['id_excel']))) && $tr_x[0]->id != $tr->id)
			$err[] = "L'id_excel spécifié appartient à une autre transaction ! [Tr nº {$tr_x[0]->id}]";
		else if ($data['id_excel'] != $tr->id_excel)
			$tr->updateOneColumn('id_excel', intval($data['id_excel']));
// Status Transaction
		if (!empty($data['status_trans']) && $tr->doByMscpi())
		{
			$status = preg_split("/-/", $data['status_trans']);
			if (count($status) != 2)
				$err[] = "Le status spécifié semble incorrect";
			else
			{
				/*$founded = 0;
				if (($status_list = $tr->getAllStatusTransaction()))
				{
					foreach ($status_list as $st)
					{
						if ($st->getStatus() == $status)
							$founded = 1;
					}
				}
				if (!$founded) */
					$tr->setNewStatusTransaction($status[0], $status[1]);
			}
		}
// Id projet
		if (!empty($data['id_projet']) && !($projet = Projet::getFromId($data['id_projet'])))
			$err[] = "Le projet associé n'existe pas.";
		else if ($data['id_projet'] != $tr->id_projet)
			$tr->updateOneColumn('id_projet', $data['id_projet']);
// Id conseiller
		if (!empty($data['id_cons']) && (!($cons = Dh::getById($data['id_cons'])) || $cons->type != "conseiller"))
			$err[] = "Impossible de changer le conseiller";
		else if ($data['id_cons'] != $tr->id_cons)
			$tr->updateOneColumn('id_cons', $data['id_cons']);
// Id Beneficiaire

		if (isset($data['commentaire_projet']) && !empty($data['commentaire_projet']))
			$tr->updateOneColumn('commentaire_projet', htmlspecialchars($data['commentaire_projet']));

		if (isset($data['id_beneficiaire']) && $data['id_beneficiaire'] != $tr->id_beneficiaire)
		{
			if (empty($data['id_beneficiaire']))
				$tr->updateOneColumn('id_beneficiaire', NULL);
			else
			{
				$_benef_list = $tr->getDh()->getBeneficiaires();
				if (!empty($_benef_list))
				{
					$_benef_id_list = [];
					foreach ($_benef_list as $e) {
						$_benef_id_list[] = $e->id_benf;
					}
					if (in_array($data['id_beneficiaire'], $_benef_id_list))
						$tr->updateOneColumn('id_beneficiaire', $data['id_beneficiaire']);
					else
						$err[] = "Le bénéficiaire est inconnu.";
				}
				else
					$err[] = "Aucun bénéficiaire trouvé.";
			}
		}
// SCPI (vérifié plus haut)
		if ($data['id_scpi'] != $tr->id_scpi)
			$tr->updateOneColumn('id_scpi', $data['id_scpi']);

// Marché 
		if (isset($data['marcher']) && $data['marcher'] != $tr->getMarcher())
		{
			if (empty($data['marcher']))
				$tr->updateOneColumn('marcher', "");
			else if (in_array($data['marcher'], Transaction::getMarcheLst()))
				$tr->updateOneColumn('marcher', ft_crypt_information($data['marcher']));
			else
				$err[] = "Type de marché inconnu.";
		}
// Type de propriété (vérifié plus haut)
		if ($data['type_pro'] != $tr->getTypePro())
			$tr->updateOneColumn('type_pro', ft_crypt_information($data['type_pro']));

		if ($data['type_pro'] == "Pleine propriété")
		{
			if ($tr->getClefRepartition() != 100)
				$tr->updateOneColumn('cle_repartition', 0);
			if (!empty($tr->getDuree()))
				$tr->updateOneColumn('dt', 0);
			if (!empty($t->viager))
				$tr->updateOneColumn('viager', 0);
		}
		else
		{
// Clé de répartition
			$cle = floatval(str_replace(',','.', $data['cle_repartition']));
			if ($data['type_pro'] == "Usufruit")
			{
				$cle = 100.0 - $cle;
				//error("$cle - " . $tr->getClefRepartition());
			}
			if ($cle <= 0 || $cle >= 100.0)
				$err[] = "Clé de répartition incorrecte";
			elseif (!empty($cle)/* && $cle != $tr->getClefRepartition()*/ )
				$tr->updateOneColumn('cle_repartition', ft_crypt_information($cle));
// Durée de démembrement
			$dt = intval($data['dt']);
			if ($dt < 0 || $dt > 20)
				$err[] = "Durée de démembrement incorrecte";
			elseif ($dt != $tr->getDuree())
			{
				if ($dt == 0)
					$tr->updateOneColumn('viager', 1);
				else
				{
					if ($tr->viager)
						$tr->updateOneColumn('viager', 0);
					$tr->updateOneColumn('dt', $dt);
				}
			}
		}
//  Nombre de part 
		$nbr_part = floatval(str_replace(',', '.', $data['nbr_part']));
		if (empty($nbr_part) || !preg_match("/^\d{1,}((\.|,)(\d{1,5}))?$/", $data['nbr_part'])
				|| $nbr_part < 1.0)
			$err[] = "Le nombre de part est incorrect";
		else if ($nbr_part != $tr->nbr_part)
		{
			if ($tr->getTypeTransaction() == 'A')
				$tr->updateOneColumn('nbr_part', $nbr_part);
			else
			{
				$tr->updateOneColumn('nbr_part', -$nbr_part);
				$tr->updateOneColumn('nbr_part_vente', $nbr_part);
			}
		}
//  Prix par part
		$prix_part = floatval(str_replace(',', '.', $data['prix_part']));
		if (empty($prix_part) || !preg_match("/^\d{1,}((\.|,)(\d{1,5}))?$/", $data['prix_part']) || $prix_part < 1.0)
				$err[] = "Le prix par part est incorrect";
		else if ($prix_part != $tr->prix_part)
		{
			if ($tr->getTypeTransaction() == 'A')
				$tr->updateOneColumn('prix_part', $prix_part);
			else
			{
				$tr->updateOneColumn('prix_part', -$prix_part);
				$tr->updateOneColumn('prix_part_vente', $prix_part);
			}
		}
// Information transaction
		/*if (!$tr->DoByMscpi() && $data['info_trans'] == "MS.C")
			$err[] = "Merci de vérifier votre saisie pour le champ 'effectué par'";
		else*/ if ($data['info_trans'] != $tr->getInfoTransaction())
			$tr->updateOneColumn('info_trans', $data['info_trans']);
// Commentaire
		if ($data['commentaire'] != $tr->getCommentaire())
			$tr->updateOneColumn('commentaire', ft_crypt_information($data['commentaire']));
// Date signature Bon de souscription
		$date_bs = new DateTime();
		if (!$date_bs->setTimestamp(intval($data['date_bs'])))
			$err[] = "Date de signature du bon de souscription incorrecte.";
//		else if ($date_bs->getTimestamp() != $tr->getDateSignatureTs())
			$tr->updateOneColumn('date_bs', $date_bs->getTimestamp());
// Date d'enregistrement
		$enr_date = new DateTime();
		if (!$enr_date->setTimestamp(intval($data['enr_date'])))
			$err[] = "Date d'enregistrement incorrecte";
		else if (!empty($data['enr_date']) && (!$tr->getEnrDate() || $enr_date->getTimestamp() != $tr->getEnrDate()->getTimestamp()))
			$tr->updateOneColumn('enr_date', ft_crypt_information($enr_date->format("d/m/Y")));
// Montant emprunt
		if (isset($data['montant_emprunt']) && $data['montant_emprunt'] != $tr->montant_emprunt)
		{
			if (intval($data['montant_emprunt']) < 0)
				$err[] = "Montant emprunt incorrect";
			else
				$tr->updateOneColumn('montant_emprunt', intval($date['montant_emprunt']));

		}
// Type emprunt
		if (isset($data['type_emprunt']) && $data['type_emprunt'] != $tr->type_emprunt)
		{
			if (!in_array($data['type_emprunt'], ['Amortissable', 'InFine']))
				$err[] = "Le type d'emprunt est incorrect";
			else
				$tr->updateOneColumn('type_emprunt', $data['type_emprunt']);
		}
// Duree emprunt
		if (isset($data['duree_emprunt']) && $data['duree_emprunt'] != $data['duree_emprunt'])
		{
			if (intval($data['duree_emprunt']) < 0)
				$err[] = "Duree d'emprunt incorrect";
			else
				$tr->updateOneColumn('duree_emprunt', intval($data['duree_emprunt']));
		}
// Date debut emprunt
		if (isset($data['date_debut_emprunt']) && $data['date_debut_emprunt'] != $tr->date_debut_emprunt)
		{
			$date_debut_emprunt = new DateTime();
			if (!$date_debut_emprunt->setTimestamp(intval($data['date_debut_emprunt'])))
				$err[] = "La date de debut d'emprunt est invalide";
			else
				$tr->updateOneColumn('date_debut_emprunt', $data['date_debut_emprunt']);
		}
// Taux emprunt
		if (isset($data['taux_emprunt']) && $data['taux_emprunt'] != $tr->taux_emprunt)
		{
			if (!preg_match("/^\d{1,}((\.|,)(\d{1,5}))?$/", $data['taux_emprunt']))
				$err[] = "Taux emprunt incorrect";
			else
				$tr->updateOneColumn('taux_emprunt', floatval(str_replace(",", '.', $data['taux_emprunt'])));
		}
// Mensualite emprunt
		if (isset($data['mensualite_emprunt']) && $data['mensualite_emprunt'] != $tr->mensualite_emprunt)
		{
			if (!preg_match("/^\d{1,}((\.|,)(\d{1,5}))?$/", $data['taux_emprunt']))
				$err[] = "Mensualite d'emprunt incorrect";
			else
				$tr->updateOneColumn('', floatval(str_replace(',', '.', $data['taux_emprunt'])));
		}

		if (!empty($err))
			error(implode($err, '<br />'));
		else
			$tr->getDh()->regenerateCacheArrayTable();
		$tr = Transaction::getById($tr->id);
		success($tr->getForStore());
		return false;
	}

	public function updateTransaction($data) {
		if (
			!isset($data['id']) ||
			!isset($data['id_scpi']) ||
			!isset($data['type_pro']) ||
			!isset($data['nbr_part']) ||
			!isset($data['status_trans']) ||
			!isset($data['info_trans']) ||
			!isset($data['enr_date']) ||
			!isset($data['prix_part']) ||
			!isset($data['id_beneficiaire']) ||
			!isset($data['id_cons']) ||
			!isset($data['marcher']) ||
			!isset($data['date_bs']) ||
			!isset($data['type']) ||
			!isset($data['commentaire'])
		)
			error("La requete n'est pas valide");

		$trans = Transaction::getFromId($data['id']);
		if (empty($trans))
			error("La transaction que vous souhaitez mettre a jours ne semble pas exister !");

		if (!empty($data['marcher']) &&	$data['marcher'] != "Primaire" && $data['marcher'] != "Secondaire" && $data['marcher'] != "Gré à gré")
			error("Le type de marché est invalide !");

		if (!preg_match("/^\d{1,}((\.|,)(\d{1,5}))?$/",$data['nbr_part']))
			error("Le nombre de parts est invalide");
		
		if (!preg_match("/^\d{1,}((\.|,)(\d{1,5}))?$/",$data['prix_part']) && $data['prix_part'] < 1)
			error("Le prix de parts est invalide");

		/* Est vérifier plus bas 
		$status = preg_split("/-/", $data['status_trans']);
		if (count($status) != 2)
			error("La transaction n'a pas pu etre mise a jours ! sttus trans 0');
		*/

		if (
			$data['type_pro'] != "Pleine propriété" &&
			$data['type_pro'] != "Nue propriété" &&
			$data['type_pro'] != "Usufruit"
		)
			error("La transaction n'a pas pu etre mise a jours ! Type pro");

		if ($data['type_pro'] != "Pleine propriété")
		{
			if (
				!isset($data['dt']) ||
				!isset($data['cle_repartition'])
			)
				error("La transaction n'a pas pu etre mise a jours !Type pro");
			$data['cle_repartition'] = floatval(str_replace(',','.',$data['cle_repartition']));
			if (
				$data['cle_repartition'] <= 0 ||
				$data['cle_repartition'] >= 100
			)
				error("La cle de repartition doit etre entre 1 et 99 compris");
			if (
				$data['dt'] < 0 ||
				$data['dt'] > 20
			)
				error("Le démembrement doit etre entre 0 et 20 compris");

			if ($data['type_pro'] == "Usufruit")
			{
				$data['cle_repartition'] = 100.0 - $data['cle_repartition'];
			}
		}

		$trans = $trans[0];

		$tmp = $data['status_trans'];
        $id_excel = 0;
		if ($tmp != -1 && $data['info_trans'] == "MS.C") { // Vérification si la transaction est bien renseignée en MS.C
		

			$id_excel = intval($data['id_excel']);
			// Vérification si il y a bien un id excel de renseigné, et si oui, vérifier si il n'est pas utilisé par une autre transaction.
			if (empty($id_excel) && ($tmp == "5-0" || $tmp == "6-0"))
				error("Les transactions MeilleureSCPI doivent avoir un id excel !!");

			$excelTrans = Transaction::getFromKeyValue('id_excel', $id_excel);
			if (!empty($excelTrans) && $id_excel != $trans->getIdExcel())
				error("L'id excel renseigné est utilisé par une autre transaction !");


			if (empty($trans->getStatusTransactionObject()) || $trans->getStatusTransactionObject()->getKeyForStore() != $tmp)
			// Vérification si la transaction avaient au par avant aucun status ou sinon si le status est différent de celui renseigné !
			{
				/*if ($tmp != "5-0" && $tmp != "6-0" && empty($trans->getProject()))
					error("La transaction n'a pas pu etre mise a jours ! (statu trans)");
				else
				{*/
					$status = preg_split("/-/", $tmp);
					if (count($status) != 2)
						error("La transaction n'a pas pu etre mise a jours ! status trans 2");
					$nelm = new StatusTransaction();
					$nelm->setTransaction($trans);
					$nelm->setStatus(
						intval($status[0]),
						intval($status[1])
					);
					$rt = $nelm->insertIt();
					if (empty($rt))
						error("La transaction n'a pas pu etre mise a jours ! status trans insert");
					$trans->setIsMscpi();
				//}
			}
		}
		else if (empty($trans->getProject()) && $data['info_trans'] == "MS.C")
			error("Une transaction Meilleurescpi doit forcément avoir un status de transaction pour etre enregistré !");

		// Si le status de transaction est renseigné et qu'il est différent de celui qui est en base alors on le renseigne !
		// Si le status est different de -1, 5-0, 6-0 alors si on a pas d'id projet alors on ne peux pas l'ajouter !

		$enr_date = intval($data['enr_date']);
		if (!empty($enr_date))
		{
			$date = new DateTime();
			$date->setTimestamp($enr_date);
			//success($date->format('d/m/Y H:i:s'));
			$trans->updateOneColumn('enr_date', ft_crypt_information($date->format("d/m/Y")));
		}
		else
		{
			$trans->updateOneColumn('enr_date', ft_crypt_information("-"));
		}

//		if (isset($data['id_excel']) && !empty($data['id_excel']))
        $trans->updateOneColumn('id_excel', $id_excel);
		$trans->updateOneColumn('info_trans', $data['info_trans']);
		$trans->updateOneColumn('id_scpi', $data['id_scpi']);
		$trans->updateOneColumn('type_pro', ft_crypt_information($data['type_pro']));
		$trans->updateOneColumn('nbr_part', floatval(str_replace(',','.',$data['nbr_part'])));
		$trans->updateOneColumn('prix_part', floatval(str_replace(',','.',$data['prix_part'])));
		$trans->updateOneColumn('date_bs', intval($data['date_bs']));
		$trans->updateOneColumn('id_cons', intval($data['id_cons']));
		if (isset($data['marcher']) && !empty($data['marcher']))
			$trans->updateOneColumn('marcher', ft_crypt_information(htmlspecialchars($data['marcher'])));

		if (isset($data['commentaire_projet']) && !empty($data['commentaire_projet']))
			$trans->updateOneColumn('commentaire_projet', htmlspecialchars($data['commentaire_projet']));

		$trans->updateOneColumn('id_beneficiaire', intval($data['id_beneficiaire']));
		$data['commentaire'] = empty($data['commentaire']) ? " " : $data['commentaire'];
		$trans->updateOneColumnCheckSecurity('commentaire', ft_crypt_information($data['commentaire']));
		if ($data['type_pro'] != "Pleine propriété")
		{
			$trans->updateOneColumn('cle_repartition', ft_crypt_information($data['cle_repartition']));
			$trans->updateOneColumn('dt', $data['dt']);
		}

		$trans = Transaction::getFromId($data['id']);
		if (empty($trans))
			return (false);
		$trans = $trans[0];
		$dh = $trans->getDh();
		if (empty($dh))
			return (false);
		$dh->regenerateCacheArrayTable();
		success($trans->getForStore());
	}
}
