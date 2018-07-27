<?php
/**
 * MSCPI
 * -----
 * @file
 */

require_once("class/core/AjaxClient.php");


class AjaxTransactionFrontStore extends AjaxClient
{

	public static $toSet = [
		"id",
		"id_scpi",
		"demembrement",
		"enr_date",
		"nbr_part",
		"cle_repartition",
		"prix_part",
		"type_pro",
		"marche",
		"montant_emprunt",
		"type_emprunt",
		"duree_emprunt",
		"date_debut_emprunt",
		"taux_emprunt",
		"mensualite_emprunt",
		/*
		"type_transaction",
		"status_trans",
		"scpi",
		"ventePotentiellePleinPro",
		"doByMscpi",
		"doByOther",
		"MontantInvestissement",
		"debut_valorisation",
		"fin_valorisation",
		"debut_dividendes",
		"fin_dividendes",
		"fait_par_mscpi",
		*/
		"id_cons",
		"id_beneficiaire",
		"info_trans",
		"societe"
	];

/*
montant_emprunt
type_emprunt
duree_emprunt
date_debut_emprunt
taux_emprunt
mensualite_emprunt
*/
	public function checkTransaction($data) {
		$error = [
			"datas" => [],
			"notif" => [],
		];

		$rt = [];

		//$error['datas']['info_trans'] = "SALUT LE MONDE";
		//error($error);
		foreach (self::$toSet as $elm) {
			//$error["datas"][$elm] = "Error test $elm";
			if (!isset($data[$elm])) {
				$error["datas"][$elm] = "Colonne manquante";
			}
			$rt[$elm] = null;
		}
		$rt['id'] = $data['id'];
		if (!empty($error["datas"])) {
			error($error);
		}

		if (!isset($curDh))
			$curDh = Dh::getCurrent();

		$date = time() - 86400;
		if (count(Logger::getByTypeExecutantSince('Ajout d\'une transaction front client', $curDh->id_dh, $date)) >= MAX_TRANSACTION_PER_DAY)
		{
			$error["notif"][] = 'Vous avez atteint le maximum d\'ajout de transaction sous ces dernières 24H.';
			error($error);
		}

		if (empty($data['id_scpi']) || empty(Scpi::getFromId($data['id_scpi'])) || !Scpi::getFromId($data['id_scpi'])->isShow())
			$error["datas"]["id_scpi"] = 'SCPI incorrecte';
		$rt['scpi'] = Scpi::getFromId($data['id_scpi']);


		$rt['id_beneficiaire'] = null;
		if (!empty($data['id_beneficiaire'])) {
			$beneficiaire = Beneficiaire::getById(intval($data['id_beneficiaire']));
			if (empty($beneficiaire) || $beneficiaire->id_dh != $curDh->id_dh)
				$error["datas"]["id_beneficiaire"] = 'Le bénéficiaire est invalide';
			else
				$rt['id_beneficiaire'] = $beneficiaire->id_benf;
		}

		$rt['nbr_part'] = trim($data['nbr_part']);
		$rt['nbr_part'] = floatval(str_replace(',','.',$rt['nbr_part']));
		if (empty($rt['nbr_part']) || $rt['nbr_part'] <= 0)
			$error["datas"]["nbr_part"] = 'Le nombre de part est invalide';

		$rt['prix_part'] = trim($data['prix_part']);
		$rt['prix_part'] = floatval(str_replace(',','.',$rt['prix_part']));
		if (empty($rt['prix_part']) || $rt['prix_part'] <= 0)
			$error["datas"]["prix_part"] = 'Le prix de part est invalide';


		//error();
		$rt['enr_date'] = $data['enr_date'];
		if ((!empty($data['enr_date']) && $data['enr_date'] == "NaN") || $data['enr_date'] <= 0){
			$error["datas"]["enr_date"] = "La date d'enregistrement n'est pas valide" . $data['enr_date'];
		} else if (!empty($rt['scpi']->DateCreation) && intval($rt['enr_date']) < $rt['scpi']->DateCreation) {
			$error["datas"]["enr_date"] = "La {$rt['scpi']->getName()} n'existait pas à la date indiqué";
		} else if (intval($rt['enr_date']) >= time()) {
			$error["datas"]["enr_date"] = "Vous ne pouvez pas déclarer une date d'enregistrement future.";
		} else if (!empty($rt['scpi']->absorbed_at) && intval($rt['enr_date']) < $rt['scpi']->getDateAbsorption()->getTimestamp()) {
			$error["datas"]["enr_date"] = "La SCPI etait absorbée avant la date d'enregistrement indiquée.";
		}

	
		$rt['marche'] = trim($data['marche']);
		if (isset($data['marche']) && !in_array($rt['marche'], Transaction::getMarcheLst()))
			$error["datas"]["marche"] = "Le Marché est invalide";


		$rt['type_pro'] = trim($data['type_pro']);
		if (isset($data['type_pro']) && (!$rt['type_pro']=="Usufruit" || !$rt['type_pro']=="Pleine propriété" || !$rt['type_pro']=="Nue propriété"))
			$error["datas"]["type_pro"] = 'Le type de propriété est invalide';

		if ($rt['marche'] != "Primaire" && $rt['type_pro'] != "Pleine propriété") {
			$error["datas"]["type_pro"] = 'Sur le marché secondaire vous ne pouvez renseigner que de la pleine propriété.';
		}
		


		$rt['societe'] = htmlspecialchars($data['societe']);
		if (!in_array($rt['societe'], [
			null,
			"-",
			"Société de gestion",
			"CGPI",
			"Banque",
			"Assureur"
		])) {
			$error["datas"]["societe"] = "Vous ne pouvez pas utiliser cette valeur";
		}

		if (in_array($rt['societe'], [
			"Société de gestion",
			"CGPI",
			"Banque",
			"Assureur"
		]))
		{
			$rt['info_trans'] = trim($data['info_trans']);
			if (empty($data['info_trans']) || strlen($data['info_trans']) < 2) {
				$error["datas"]["info_trans"] = "Veuillez préciser par qui à été effectuée cette transaction.";
			}
		}

		$rt['info_trans'] = trim($data['info_trans']);
		if (!empty($data['info_trans']) && $data['info_trans'] == 'MS.C')
			$error["datas"]["info_trans"] = "Vous ne pouvez pas utiliser cette valeur";


		$rt['cle_repartition'] = floatval(str_replace(',','.',trim($data['cle_repartition'])));
		$rt['demembrement'] = intval(trim($data['demembrement']));
		$rt['viager'] = false;
		if ($rt['type_pro'] == "Nue propriété" || $rt['type_pro'] == "Usufruit") {
			if (empty($rt['cle_repartition']) || $rt['cle_repartition'] <= 0 || $rt['cle_repartition'] >= 100)
				$error["datas"]["cle_repartition"] = 'La Clé de repartition est invalide';
			if (empty($data['demembrement']) || $rt['demembrement'] < 0 || $rt['demembrement'] >= 20)
				$error["datas"]["demembrement"] = "Le démembrement n'est pas valide";
			if ($rt['demembrement'] == 0)
				$rt['viager'] = true;
		} else if ($rt['type_pro'] == "Pleine propriété") {
			$rt['demembrement'] = null;
			$rt['cle_repartition'] = 100;
		}

		if ($rt['type_pro'] == "Usufruit") {
			$rt['cle_repartition'] = 100 - $rt['cle_repartition'];
		}

		$rt['montant_emprunt'] 	= intval($data['montant_emprunt']);
		$rt['type_emprunt'] 		= htmlspecialchars($data['type_emprunt']);
		$rt['duree_emprunt'] 		= intval($data['duree_emprunt']);
		$rt['date_debut_emprunt'] = intval($data['date_debut_emprunt']);
		$rt['taux_emprunt']		= floatval($data['taux_emprunt']);
		$rt['mensualite_emprunt'] = floatval($data['mensualite_emprunt']);

		$haveEmprunt = 
			!empty($rt['montant_emprunt']) ||
			!empty($rt['type_emprunt']) ||
			!empty($rt['duree_emprunt']) ||
			!empty($rt['date_debut_emprunt']) ||
			!empty($rt['taux_emprunt']) ||
			!empty($rt['mensualite_emprunt']);

		if ($haveEmprunt) {

			if($rt['montant_emprunt'] <= 0) {
				$error["datas"]["montant_emprunt"] = 'error montant_emprunt';
			}

			if (!in_array($rt['type_emprunt'], ['Amortissable', 'In Fine'])) {
				$error["datas"]["type_emprunt"] = 'error type_emprunt';
			}

			if($rt['duree_emprunt'] <= 0) {
				$error["datas"]["duree_emprunt"] = 'error duree_emprunt';
			}

			if($rt['date_debut_emprunt'] <= 0) {
				$error["datas"]["date_debut_emprunt"] = 'error date_debut_emprunt';
			}

			if($rt['taux_emprunt'] <= 0) {
				$error["datas"]["taux_emprunt"] = 'error taux_emprunt';
			}

			if($rt['mensualite_emprunt'] <= 0) {
				$error["datas"]["mensualite_emprunt"] = 'error mensualite_emprunt';
			}

		}
		if (!empty($error["datas"])) {
			error($error);
		}

		// TODO Code d'insertion des datas

		if ($haveEmprunt) {
			// TODO Code pour mettre à jour les colonnes liées à l'emprunt.
		}
		// TODO Code pour renvoyer les nouvelles données insérées.


/*
montant_emprunt
type_emprunt
duree_emprunt
date_debut_emprunt
taux_emprunt
mensualite_emprunt
*/

		if (!empty($rt['enr_date'])) {
			$date = new Datetime();
			$date->setTimestamp($rt['enr_date']);
			$rt['enr_date'] = ft_crypt_information($date->format("d/m/Y"));
		}
		if (!empty($rt['marche']))
			$rt['marche'] = ft_crypt_information($rt['marche']);
		if (!empty($rt['type_pro']))
			$rt['type_pro'] = ft_crypt_information($rt['type_pro']);
		if (!empty($rt['cle_repartition']) || $rt['cle_repartition'] === 0)
			$rt['cle_repartition'] = ft_crypt_information($rt['cle_repartition']);
		$rt['id_scpi'] = $rt['scpi']->id;
		$rt['name'] = ft_crypt_information($rt['scpi']->getName());
		return ($rt);
	}

	public function createTransaction($data) {
		$error = [
			"datas" => [],
			"notif" => [],
		];
		//var_dump($data);
		//error();
		$dh =  Dh::getCurrent();
		if (empty($dh))
			error("pas d'utilisateur");
		$id_dh = $dh->id_dh;

		$rt = Transaction::insertOtherTransactionPleine(
			$id_dh,
			$data['info_trans'],
			$data['enr_date'],
			$data['marche'],
			$data['type_pro'],
			$data['nbr_part'],
			$data['prix_part'],
			$data['id_scpi'],
			$data['name'],
			$data['demembrement'],
			$data['cle_repartition'],
			$data['viager'],
			$data['montant_emprunt'],
			$data['duree_emprunt'],
			$data['date_debut_emprunt'],
			$data['taux_emprunt'],
			$data['mensualite_emprunt']
		);
		$cache = $dh->regenerateCacheArrayTable();
		if (empty($rt)) {
			$error['notif'][] = "L'insertion de la transaction à échouée";
			error($error);
		}
		$transaction = Transaction::getById($rt);
		$transaction->updateOneColumn('societe', htmlspecialchars($data['societe']));
		//$transaction->updateOneColumn('fait_par_mscpi', false);
        $params = [
            "id_beneficiaire" => $data["id_beneficiaire"],
            "id_scpi" => $data["id_scpi"],
            "info_trans" => $data["info_trans"],
            "marche" => ft_decrypt_crypt_information($data["marche"]),
            "type_pro" => ft_decrypt_crypt_information($data["type_pro"]),
            "cle_repartition" => ft_decrypt_crypt_information($data["cle_repartition"]),
            "demembrement" => $data["demembrement"],
            "nbr_part" => $data["nbr_part"],
            "prix_part" => $data["prix_part"],
            "enr_date" => ft_decrypt_crypt_information($data["enr_date"]),
            "montant_emprunt" => $data["montant_emprunt"],
            "type_emprunt" => $data["type_emprunt"],
            "duree_emprunt" => $data["duree_emprunt"],
            "date_debut_emprunt" => $data["date_debut_emprunt"],
            "taux_emprunt" => $data["taux_emprunt"],
            "mensualite_emprunt" => $data["mensualite_emprunt"],
            "societe" => $data["societe"],
            "name" => ft_decrypt_crypt_information($data["name"])
        ];
        Logger::setNew("Ajout d'une transaction front client", $dh->id_dh, $dh->id_dh, $params);
		success([
			"datas" => $transaction->getForFrontStore()
		]);
	}

	public function updateTransaction($data) {

		//var_dump($data);
		//error();

		$error = [
			"datas" => [],
			"notif" => [],
		];

		$dh =  Dh::getCurrent();

		$originTrans = Transaction::getById(intval($data['id']));

        if (empty($originTrans)) {
            $error['notif'][] = "La transaction n'existe pas en base de donnée !";
            error($error);
        }

		if ($originTrans->getTypeTransaction() == "V") {
			$error['notif'][] = "Vous ne pouvez pas modifier une transaction de vente.";
			error($error);
		}


		if($originTrans->id_donneur_ordre != $dh->id_dh){
            $error['notif'][] = "Vous n'avez pas les droits de modifications sur cette transaction !";
            error($error);
        }
		if ($originTrans->doByMscpi()) {
			$error['notif'][] = "Vous n'avez pas les droits de modifications sur cette transaction !";
			error($error);
		}


		$toUpdate = [ 
			"id_beneficiaire" => "id_beneficiaire",
			"id_scpi" => "id_scpi",
			"info_trans" => "info_trans",

			"marche" => "marcher",
			"type_pro" => "type_pro",
			"cle_repartition" => "cle_repartition",
			"demembrement" => "dt",

			"nbr_part" => "nbr_part",
			"prix_part" => "prix_part",
			"enr_date" => "enr_date",

			"montant_emprunt" => "montant_emprunt",
			"type_emprunt" => "type_emprunt",
			"duree_emprunt" => "duree_emprunt",
			"date_debut_emprunt" => "date_debut_emprunt",
			"taux_emprunt" => "taux_emprunt",
			"mensualite_emprunt" => "mensualite_emprunt",
			"societe" => "societe",
			"name" => "Name"
		];

        $tab_crypt=["marche","type_pro","cle_repartition","enr_date","name"];


		$ventes = Transaction::getFromKeyValue('id_transaction_achat', $originTrans->id);
		if (!empty($data['type_pro']) && ft_decrypt_crypt_information($data['type_pro']) != "Pleine propriété") {
			foreach ($ventes as $elm) {
				$elm->deleteMe();
			}
		} else 
			$date = Datetime::createFromFormat("d/m/Y", ft_decrypt_crypt_information($data['enr_date']));
			foreach ($ventes as $elm) {
				if ($elm->getEnrDate() < $date) {
					$error["datas"]["enr_date"] = "Vous avez déclaré des ventes avant cette date";
					error($error);
				}
		}

        $params=[];
        if($originTrans->getBeneficiaire() != 0){
            $params["Beneficiaire"]=$originTrans->getBeneficiaire();
        }
		foreach ($toUpdate as $col => $colDb) {
			if ($originTrans->{$colDb} != $data[$col]) {
			    if(in_array($col, $tab_crypt)){
                    $params[$colDb] = ft_decrypt_crypt_information($data[$col]);
					if (!empty($originTrans->$col))
						$params[$colDb."*Avant*"]=ft_decrypt_crypt_information($originTrans->$col);
					else
						$params[$colDb."*Avant*"]="NULL";
                }
                else{
                    $params[$colDb] = $data[$col];
					if (!empty($originTrans->$col))
						$params[$colDb."*Avant*"]=$originTrans->$col;
					else
						$params[$colDb."*Avant*"]="NULL";
                }
				$originTrans->updateOneColumn($colDb, $data[$col]);
				//$error["datas"][$col] = "DIFF [" . $originTrans->{$colDb} . "] [" . $data[$col] . "]";
			}
		}

		//error($error);

		$transaction = Transaction::getById($originTrans->id);

		$cache = $dh->regenerateCacheArrayTable();

        if(isset($params["date_debut_emprunt"])){
            $da = new DateTime();
            $da->setTimestamp($params["date_debut_emprunt"]);
            $params["date_debut_emprunt"]= $da->format("d/m/Y");
        }
        Logger::setNew("Modification d'une transaction front client", $dh->id_dh, $dh->id_dh, $params);

		success([
			"datas" => $transaction->getForFrontStore()
		]);
	}

	public function deleteTransaction($data) {

		global $curDh;
		if (!isset($curDh))
			$curDh = Dh::getCurrent();

        $dh =  Dh::getCurrent();

        $originTrans = Transaction::getById(intval($data['id']));

        if (empty($originTrans)) {
            $error['notif'][] = "La transaction n'existe pas en base de donnée !";
            error($error);
        }

        if($originTrans->id_donneur_ordre != $dh->id_dh){
            $error['notif'][] = "Vous n'avez pas les droits de modifications sur cette transaction !";
            error($error);
        }
        if ($originTrans->doByMscpi()) {
            $error['notif'][] = "Vous n'avez pas les droits de modifications sur cette transaction !";
            error($error);
        }


		if (!empty($data['id']) && !empty(($t = Transaction::getById($data['id']))) && $t->id_donneur_ordre == $curDh->id_dh && !$t->doByMscpi())
		{

			$hasDoc = false;
			foreach ($t->getDocumentsArray() as $doc)
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
                $params = [
                    "Nom" => $originTrans->getName(),
                    "clé de répartition" => ft_decrypt_crypt_information($originTrans->cle_repartition),
                    "date de debut emprunt" => $originTrans->date_debut_emprunt,
                    "date edit trans" => $originTrans->date_edit_trans,
                    "debut_dividendes" => $originTrans->debut_dividendes,
                    "debut_valorisation" => $originTrans->debut_valorisation,
                    "dt" => $originTrans->dt,
                    "duree_emprunt" => $originTrans->duree_emprunt,
                    "enr_date" => ft_decrypt_crypt_information($originTrans->enr_date),
                    "fait_par_mscpi" => $originTrans->fait_par_mscpi,
                    "fin_dividendes" => $originTrans->fin_dividendes,
                    "fin_valorisation" => $originTrans->fin_valorisation,
                    "id" => $originTrans->id,
                    "id_beneficiaire" => $originTrans->id_beneficiaire,
                    "id_donneur_ordre" => $originTrans->id_donneur_ordre,
                    "id_scpi" => $originTrans->id_scpi,
                    "info_trans" => $originTrans->info_trans,
                    "marcher" => ft_decrypt_crypt_information($originTrans->marcher),
                    "mensualite_emprunt" => $originTrans->mensualite_emprunt,
                    "montant_emprunt" => $originTrans->montant_emprunt,
                    "nbr_part" => $originTrans->nbr_part,
                    "nbr_part_vente" => $originTrans->nbr_part_vente,
                    "prix_part" => $originTrans->prix_part,
                    "prix_part_vente" => $originTrans->prix_part_vente,
                    "societe" => $originTrans->societe,
                    "status_trans" => $originTrans->status_trans,
                    "taux_emprunt" => $originTrans->taux_emprunt,
                    "type_pro" => ft_decrypt_crypt_information($originTrans->type_pro),
                    "type_transaction" => $originTrans->type_transaction
                ];
                Logger::setNew("Suppression d'une transaction front client", $dh->id_dh, $dh->id_dh, $params);
				success("La transaction a bien été supprimée");
			}

		}
		error($originTrans);


	}

	public function saveTransaction($data) {

		$arrayDatas = $this->checkTransaction($data);
		$id = $data['id'];
		if (strlen($id) == 1 && $id[0] == "0") {
			return ($this->createTransaction($arrayDatas));
		} else {
			return ($this->updateTransaction($arrayDatas));
		}

/*
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
		*/
	}
}
