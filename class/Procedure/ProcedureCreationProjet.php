<?php
class ProcedureCreationProjet extends Procedure {

	// À chaque étape il doit être définit une méthode.
	public  static $_steps = [
			// 0
			[
				'name' =>"ProjetCheckProjet",
				'page' => 'CheckProjet',
				'title' => 'titre 1',
				'isBack' => false,
				'notCommit' => true
			],
			// A1
			[
				'name' =>"ProjetChoixBeneficiaire",
				'title' => 'titre 2',
				'page' => 'CreationProjet',
				'isBack' => false
			],
			// A2
			[
				'name' =>"ProjetChoixObjectif",
				'title' => 'titre 3',
				'page' => 'CreationProjet',
				'isBack' => false
			],
			/*
			// A3
			[
				'name' =>"ProjetMontant",
				'page' => 'CreationProjet',
				'isBack' => false
			],
			*/
			
			[
				'name' =>"ProjetCredit",
				'page' => 'CreationProjet',
				'title' => 'titre 4',
				'isBack' => false
				],

			// A4
			[
				'name' =>"ProjetOrigineFondsSelection",
				'title' => 'titre 5',
				'page' => 'CreationProjet',
				'isBack' => false,
				'notBack' => true
			],

			// A4
			[
				'name' =>"ProjetOrigineFonds",
				'title' => 'titre 6',
				'page' => 'CreationProjet',
				'isBack' => false,
				'notBack' => true
			],
//////////////////////////////////////////////////////////////////////////
			// A5
			[
				'name' =>"ProjetAccompagnementInvestissement",
				'title' => 'titre 7',
				'page' => 'CreationProjet',
				'isBack' => false,
				'notBack' => true
			],
		
			[
				'name' =>"CheckSituation",
				'page' => 'CreationProjet',
				'isBack' => true
			],

//////////////////////////////////////////////////////////////////////////
			// B1
			[
				'name' =>"JuridiqueVosInformations",
				'title' => 'titre 8',
				'page' => 'SituationJuridique',
				'isBack' => false
			],


			[
				'name' =>"Coherence1",
				'page' => 'SituationJuridique',
				'isBack' => true
			],

			// B2
			[
				'name' =>"JuridiquePersonnePhysique1",
				'title' => 'titre 9',
				'page' => 'SituationJuridique',
				'isBack' => false
			],

			[
				'name' =>"Coherence6",
				'page' => 'SituationJuridique',
				'isBack' => true
			],

			[
				'name' =>"JuridiquePersonnePhysique1Complement",
				'title' => 'titre 10',
				'page' => 'SituationJuridique',
				'isBack' => false
			],


			// B3
			[
				'name' =>"JuridiquePersonnePhysique2",
				'title' => 'titre 11',
				'page' => 'SituationJuridique',
				'isBack' => false,
				'notBack' => true
			],

			[
				'name' =>"Coherence6_2",
				'page' => 'SituationJuridique',
				'isBack' => true
			],

			[
				'name' =>"JuridiquePersonnePhysique2Complement",
				'title' => 'titre 12',
				'page' => 'SituationJuridique',
				'isBack' => false,
				'notBack' => true
			],


//////////////////////////////////////////////////////////////////////////
			// C1
			[
				'name' =>"FinanciereRevenus",
				'title' => 'titre 13',
				'page' => 'SituationFinanciere',
				'isBack' => false
			],

			[
				'name' =>"Coherence7",
				'page' => 'SituationFinanciere',
				'isBack' => true
			],
			// C2

			[
				'name' =>"FinanciereHabitation",
				'title' => 'titre 14',
				'page' => 'SituationFinanciere',
				'isBack' => false
			],

			[
				'name' =>"FinanciereCharges",
				'title' => 'titre 15',
				'page' => 'SituationFinanciere',
				'isBack' => false
			],




			[
				'name' =>"Coherence2",
				'page' => 'SituationFinanciere',
				'isBack' => true
			],

			[
				'name' =>"Coherence3",
				'page' => 'SituationFinanciere',
				'isBack' => true
			],

			[
				'name' =>"Coherence10",
				'page' => 'SituationFinanciere',
				'isBack' => true
			],

//////////////////////////////////////////////////////////////////////////
			// D1
			[
				'name' =>"FiscaleDe",
				'title' => 'titre 16',
				'page' => 'SituationFiscale',
				'isBack' => false
			],

/*
			[
				'name' =>"Coherence18",
				'page' => 'SituationPatrimoniale',
				'isBack' => true
			],
*/
			[
				'name' =>"Coherence16",
				'page' => 'SituationFiscale',
				'isBack' => true
			],

			// D2
			[
				'name' =>"FiscaleImpot",
				'title' => 'titre 17',
				'page' => 'SituationFiscale',
				'isBack' => false
			],

			[
				'name' =>"Coherence11",
				'page' => 'SituationFiscale',
				'isBack' => true
			],

			// D3
			[
				'name' =>"FiscaleIsf",
				'title' => 'titre 18',
				'page' => 'SituationFiscale',
				'isBack' => false
			],

//////////////////////////////////////////////////////////////////////////
			// E1
			[
				'name' =>"PatrimoineSituation",
				'title' => 'titre 19',
				'page' => 'SituationPatrimoniale',
				'isBack' => false
			],
			// E2
			[
				'name' =>"PatrimoineRepartition",
				'title' => 'titre 20',
				'page' => 'SituationPatrimoniale',
				'isBack' => false
			],

			[
				'name' =>"Coherence4",
				'page' => 'SituationPatrimoniale',
				'isBack' => true
			],

			[
				'name' =>"Coherence5",
				'page' => 'SituationPatrimoniale',
				'isBack' => true
			],

			[
				'name' =>"Coherence8",
				'page' => 'SituationPatrimoniale',
				'isBack' => true
			],

			[
				'name' =>"Coherence9",
				'page' => 'SituationPatrimoniale',
				'isBack' => true
			],

			[
				'name' =>"Coherence12",
				'page' => 'SituationPatrimoniale',
				'isBack' => true
			],

			[
				'name' =>"Coherence13",
				'page' => 'SituationPatrimoniale',
				'isBack' => true
			],

			[
				'name' =>"Coherence14",
				'page' => 'SituationPatrimoniale',
				'isBack' => true
			],

			[
				'name' =>"Coherence15",
				'page' => 'SituationPatrimoniale',
				'isBack' => true
			],








			
			// E3
			[
				'name' =>"PatrimoineFuturePlacement",
				'title' => 'titre 21',
				'page' => 'SituationPatrimoniale',
				'isBack' => false
			],


			[
				'name' =>"CheckProfilInvestisseur",
				'page' => 'ProfilInvestisseur',
				'isBack' => true 
			],


			[
				'name' =>"ProfilInvestisseurRisque",
				'title' => 'titre 22',
				'page' => 'ProfilInvestisseur',
				'isBack' => false
			],

			[
				'name' =>"ProfilInvestisseurCompetences",
				'title' => 'titre 23',
				'page' => 'ProfilInvestisseur',
				'isBack' => false
			],

			[
				'name' =>"ProfilInvestisseurCompetencesFinance",
				'title' => 'titre 23',
				'page' => 'ProfilInvestisseur',
				'isBack' => false
			],

			[
				'name' =>"ProfilInvestisseurMarcheImmobiliers",
				'title' => 'titre 24',
				'page' => 'ProfilInvestisseur',
				'isBack' => false
			],

			[
				'name' =>"ProfilInvestisseurSupportPlacement",
				'title' => 'titre 25',
				'page' => 'ProfilInvestisseur',
				'isBack' => false
			],

			[
				'name' =>"ProfilInvestisseurPlacementDetenus",
				'title' => 'titre 26',
				'page' => 'ProfilInvestisseur',
				'isBack' => false
			],

			[
				'name' =>"ProfilInvestisseurModeGestion",
				'title' => 'titre 27',
				'page' => 'ProfilInvestisseur',
				'notBack' => true,
				'isBack' => false
			],

			[
				'name' =>"ProfilInvestisseurConnaissance",
				'title' => 'titre 28',
				'page' => 'ProfilInvestisseur',
				'isBack' => false
			],

			[
				'name' =>"ProfilInvestisseurSiJinvestis",
				'title' => 'titre 28',
				'page' => 'ProfilInvestisseur',
				'isBack' => false
			],

			[
				'name' =>"ProfilInvestisseurQuizScpi",
				'title' => 'titre 29',
				'page' => 'ProfilInvestisseur',
				'isBack' => false
			],

			[
				'name' =>"ProfilInvestisseurEnd",
				'page' => 'ProfilInvestisseur',
				'isBack' =>true 
			],

			[
				'name' =>"ProfilInvestisseurNote",
				'title' => 'titre 30',
				'page' => 'ProfilInvestisseurNote',
				'isBack' => false
			],

//////////////////////////////////////////////////////////////////////////
			[
				'name' =>"Fin",
				'title' => 'titre 31',
				'page' => 'Thanks',
				'isBack' => false
			]
	];

	protected static $_actions = [
		"setBeneficiaire"
	]; 
	

	// Cette fonction doit juste insérer les données. valeurs de retour !
	public static function setIncoherence($datas) {
		//$name = $datas['name'];
		$nbr_incoherence = intval($datas['nbr_incoherence']);
		//var_dump($datas);

		$store = new StoreGenerator("mscpi");
		// Get projet
		if (
			!isset($datas['projet']) ||
			!isset($datas['selectedDonneurDOrdre']) ||
			!isset($datas['projet']['id']) ||
			!isset($datas['projet']['id']['value']) //||
			//!isset($datas['formulaire'])
		)
			error("La requète est mal formatée il manque des élements");

		$dh = DonneurDOrdre::getById($datas['selectedDonneurDOrdre']['id']['value']);

		if (empty($dh))
			error("Pas de donneur d'ordres");
		// TODO Vérification des droits du donneur d'ordre
		// Le cas d'un nouveau projet
		if ($datas['projet']['id']['value'] == 0) {
			// on peux nettoyer la table projet ici je pense !
			$projet = new Projet2();
		}
		else {
			$projet = Projet2::getById($datas['projet']['id']['value']);
		}
		$instances['projet'] = $projet;

		// On vérifie que le statut du projet existe bien dans la liste.
		$statut = $instances['projet']->getStatutParcourClient()->get();
		if (!in_multi_array($statut, self::$_steps))
			error("le projet est corompu");

		//self::removeProtection($instances['projet']);
		$instances['projet']->removeCheck();
		$temoin = 1;
		foreach (self::$_steps as $key => $currentStatut)
		{
			if ($temoin > 1) {
				$temoin--;
				continue;
			}
			if ($currentStatut['name'] == ("Coherence" . $nbr_incoherence)) {
				$nm = "Coherence" . $nbr_incoherence;
				$count = self::{"check" . $nm}($instances, $store, $datas, $dh);
				if ($count) {
					while (self::$_steps[$key + $count]['isBack']) {
						$rt = self::{"check" . self::$_steps[$key + $count]['name']}($instances, $store, $datas, $dh, "next");
						if (!$rt)
							$store->error();
						$count += $rt;
					}
					$instances['projet']->getStatutParcourClient()->set(self::$_steps[$key + $count]['name']);
				}
				
				$instances['projet']->commit();
				$store->addToState($instances['projet']);
				$store->setSelected($instances['projet']);
				$store->success();
			}
			/*
			else if ( $datas['projet']['statut_parcour_client']['value'] == $currentStatut['name'] )
			{
				$instances['projet']->getStatutParcourClient()->set(self::$_steps[$key]['name']);
				$instances['projet']->commit();
				$store->addToState($instances['projet']);
				$store->setSelected($instances['projet']);
				$store->success();
			}
			*/
			else
			{
				$rt = self::{"check" . $currentStatut['name']}($instances, $store);
				$temoin = $rt;
				if ($currentStatut['isBack'] == false)
					$instances['projet']->getStatutParcourClient()->set($currentStatut['name']);
				if (!$rt)
				{
					//$instances['projet']->getStatutParcourClient()->set(self::$_steps[$key]['name']);
					$instances['projet']->commit();
					$store->addToState($instances['projet']);
					$store->setSelected($instances['projet']);
					$store->error();
				}
			}
		}
	}
	public static function setBlock($datas) {
		$name = $datas['name'];
		//error('pas implémenté');
		$store = new StoreGenerator("mscpi");
		// Get projet
		if (
			!isset($datas['projet']) ||
			!isset($datas['selectedDonneurDOrdre']) ||
			!isset($datas['projet']['id']) ||
			!isset($datas['projet']['id']['value']) //||
			//!isset($datas['formulaire'])
		)
			error("La requète est mal formatée il manque des élements");

		//$form = $datas['formulaire'];


		$dh = DonneurDOrdre::getById($datas['selectedDonneurDOrdre']['id']['value']);

		if (empty($dh))
			error("Pas de donneur d'ordres");
		// TODO Vérification des droits du donneur d'ordre
		// Le cas d'un nouveau projet
		if ($datas['projet']['id']['value'] == 0) {
			$projet = new Projet2();
		}
		else {
			$projet = Projet2::getById($datas['projet']['id']['value']);
		}
		$instances['projet'] = $projet;

		// On vérifie que le statut du projet existe bien dans la liste.
		$statut = $instances['projet']->getStatutParcourClient()->get();
		if (!in_multi_array($statut, self::$_steps))
			error("le projet est corompu");

		//self::removeProtection($instances['projet']);
		$instances['projet']->removeCheck();
		$haveError = false;
		$temoin = 1;
		foreach (self::$_steps as $key => $currentStatut)
		{
			if ($temoin > 1) {
				$temoin--;
				continue;
			}
			// On est dans le cas ou on doit passer à la suite
			if ( $statut == $currentStatut['name'])
			{
				$instances['projet']->getStatutParcourClient()->set($currentStatut['name']);
				$instances['projet']->commit();
				$store->setSelected($instances['projet']);
				//$count = self::{"set" . $statut}($instances, $store, $datas, $dh, "next");
				$count = self::{"check" . $statut}($instances, $store, $datas, $dh, "set");
				if ($count)
				{
					while (self::$_steps[$key + $count]['isBack']) {
						$rt = self::{"check" . self::$_steps[$key + $count]['name']}($instances, $store, $datas, $dh, "next");
						if (!$rt)
							$store->error();
						$count += $rt;
					}
					$instances['projet']->getStatutParcourClient()->set(self::$_steps[$key + $count]['name']);
				}
				
				$instances['projet']->commit();
				$store->addToState($instances['projet']);
				$store->setSelected($instances['projet']);
				if ($haveError)
					$store->error();
				else
					$store->success();
			}
			/*
			if ( $statut == $currentStatut['name'])
			{
				$instances['projet']->getStatutParcourClient()->set($currentStatut['name']);
				$instances['projet']->commit();
				$store->setSelected($instances['projet']);
				$count = self::{"set" . $statut}($instances, $store, $datas, $dh, "next");
				if ($count)
				{
					while (self::$_steps[$key + $count]['isBack']) {
						$rt = self::{"check" . self::$_steps[$key + $count]['name']}($instances, $store, $datas, $dh, "next");
						if (!$rt)
							$store->error();
						$count += $rt;
					}
					$instances['projet']->getStatutParcourClient()->set(self::$_steps[$key + $count]['name']);
				}
				
				$instances['projet']->commit();
				$store->addToState($instances['projet']);
				$store->setSelected($instances['projet']);
				$store->success();
			}*/
			// On est dans le cas ou il faut juste mettre à jours les données
			else if ( $datas['projet']['statut_parcour_client']['value'] == $currentStatut['name'] )
			{
				$instances['projet']->getStatutParcourClient()->set(self::$_steps[$key]['name']);
				$instances['projet']->commit();
				$store->addToState($instances['projet']);
				$store->setSelected($instances['projet']);
				$store->success();
			}
			// On est dans le cas ou il faut juste mettre à jours les données
			else if ( $name == $currentStatut['name'] )
			{
				$count = self::{"set" . $name}($instances, $store, $datas, $dh, "set");
				$instances['projet']->commit();
				$store->addToState($instances['projet']);
				$store->setSelected($instances['projet']);
				if ($count === false)
					$store->error();
			}
			else
			{
			/*
				$rt = self::{"check" . $currentStatut['name']}($instances, $store);
				if (!$rt)
				{
					$instances['projet']->commit();
					$store->addToState($instances['projet']);
					$store->setSelected($instances['projet']);
					$store->error();
				}
				if ($currentStatut['isBack'] == false)
					$instances['projet']->getStatutParcourClient()->set($currentStatut['name']);
*/
				$rt = self::{"check" . $currentStatut['name']}($instances, $store);
				$temoin = $rt;
				//if ($currentStatut['isBack'] == false)
					//$instances['projet']->getStatutParcourClient()->set($currentStatut['name']);
				//if ($currentStatut['isBack'] == false)
					//$instances['projet']->getStatutParcourClient()->set($currentStatut['name']);
				if (!$rt)
				{
					//$instances['projet']->commit();
					$store->addToState($instances['projet']);
					$store->setSelected($instances['projet']);
					//$store->error();
					$haveError = true;
				}
			}
		}
	}

	public static function previousStep($datas) {
		//$statut = $datas['statut'];
		//$datas = $datas['datas'];
		$store = new StoreGenerator("mscpi");
		// Get projet
		if (
			!isset($datas['projet']) ||
			!isset($datas['selectedDonneurDOrdre']) ||
			!isset($datas['projet']['id']) ||
			!isset($datas['projet']['id']['value'])
		)
			error("La requète est mal formatée il manque des élements");

		if (isset($datas['formulaire']))
			$form = $datas['formulaire'];
		else
			$form = [];

		$dh = DonneurDOrdre::getById($datas['selectedDonneurDOrdre']['id']['value']);

		$instances = [];

		if ($datas['projet']['id']['value'] == 0) {
			$store->error();
		}
		else {
			$projet = Projet2::getById($datas['projet']['id']['value']);
		}
		$instances['projet'] = $projet;

		// On vérifie que le statut du projet existe bien dans la liste.
		$statut = $projet->getStatutParcourClient()->get();
		//self::removeProtection($projet);
		$instances['projet']->removeCheck();
		foreach (self::$_steps as $key => $currentStatut)
		{
			if ($key == 0)
				continue ;
			if ( $statut == $currentStatut['name'])
			{
				$count = 1;
				$rt = self::{"set" . $statut}($instances, $store, $datas, $dh, 'previous');
				//$instances['projet']->getStatutParcourClient()->set(self::$_steps[$key - $count]['name']);
				while (
					self::$_steps[$key - $count]['isBack'] ||
					(isset(self::$_steps[$key - $count]['notBack']) && self::$_steps[$key - $count]['notBack'])
				) {
					$count++;
				}
				$instances['projet']->getStatutParcourClient()->set(self::$_steps[$key - $count]['name']);
				$instances['projet']->commit();
				$store->addToState($instances['projet']);
				$store->setSelected($instances['projet']);
				$store->success();
			}
			else if ( $datas['projet']['statut_parcour_client']['value'] == $currentStatut['name'] )
			{
				$rt = self::{"set" . $currentStatut['name']}($instances, $store, $datas, $dh, "previous");
				$instances['projet']->getStatutParcourClient()->set($currentStatut['name']);
				$instances['projet']->commit();
				$store->addToState($instances['projet']);
				$store->setSelected($instances['projet']);
				$store->success();
			}
			else if (!$currentStatut['isBack'])
			{
				$rt = self::{"check" . $currentStatut['name']}($instances, $store);
				if (!$rt)
				{
					//$instances['projet']->getStatutParcourClient()->set(self::$_steps[$key]['name']);
					$instances['projet']->commit();
					$store->addToState($instances['projet']);
					$store->setSelected($instances['projet']);
					$store->error();
				}
			}
		}
	}
	
	public static function setActual($datas) {

		//$statut = $datas['statut'];
		//$datas = $datas['datas'];

		$store = new StoreGenerator("mscpi");
		// Get projet
		if (
			!isset($datas['projet']) ||
			!isset($datas['selectedDonneurDOrdre']) ||
			!isset($datas['projet']['id']) ||
			!isset($datas['projet']['id']['value'])
		)
			error("La requète est mal formatée il manque des élements");

		//$form = $datas['formulaire'];

		$dh = DonneurDOrdre::getById($datas['selectedDonneurDOrdre']['id']['value']);

		if (empty($dh))
			error("Pas de donneur d'ordres");
		// TODO Vérification des droits du donneur d'ordre
		// Le cas d'un nouveau projet


		if ($datas['projet']['id']['value'] == 0) {
			$projet = new Projet2();
		} else {
			$projet = Projet2::getById($datas['projet']['id']['value']);
		}
		$instances['projet'] = $projet;

		// On vérifie que le statut du projet existe bien dans la liste.
		$statut = $instances['projet']->getStatutParcourClient()->get();
		if (!in_multi_array($statut, self::$_steps))
			error("le projet est corompu");

		//self::removeProtection($instances['projet']);
		$instances['projet']->removeCheck();

		$temoin = 1;
		foreach (self::$_steps as $key => $currentStatut)
		{
			if ($temoin > 1) {
				$temoin--;
				continue;
			}
			if ( $statut == $currentStatut['name']) {
				$count = self::{"set" . $statut}($instances, $store, $datas, $dh, "next");
				$instances['projet']->commit();
				$store->addToState($instances['projet']);
				$store->setSelected($instances['projet']);
				$store->success();
			} else if ( $datas['projet']['statut_parcour_client']['value'] == $currentStatut['name'] ) {
				$instances['projet']->getStatutParcourClient()->set(self::$_steps[$key]['name']);
				$instances['projet']->commit();
				$store->addToState($instances['projet']);
				$store->setSelected($instances['projet']);
				$store->success();
			} else {
				$rt = self::{"check" . $currentStatut['name']}($instances, $store);
				$temoin = $rt;
				if (!$rt) {
					$instances['projet']->commit();
					$store->addToState($instances['projet']);
					$store->setSelected($instances['projet']);
					$store->error();
				}
			}
		}
	}
	// Cette fonction devrait set les données puis passer à la suite si possible.
	public static function nextStep($datas) {

		//$statut = $datas['statut'];
		//$datas = $datas['datas'];

		$store = new StoreGenerator("mscpi");
		// Get projet
		if (
			!isset($datas['projet']) ||
			!isset($datas['selectedDonneurDOrdre']) ||
			!isset($datas['projet']['id']) ||
			!isset($datas['projet']['id']['value']) //||
			//!isset($datas['formulaire'])
		)
			error("La requète est mal formatée il manque des élements");

		//$form = $datas['formulaire'];

		$dh = DonneurDOrdre::getById($datas['selectedDonneurDOrdre']['id']['value']);

		if (empty($dh))
			error("Pas de donneur d'ordres");
		// TODO Vérification des droits du donneur d'ordre
		// Le cas d'un nouveau projet


		if ($datas['projet']['id']['value'] == 0) {
			$projet = new Projet2();
		} else {
			$projet = Projet2::getById($datas['projet']['id']['value']);
		}
		$instances['projet'] = $projet;

		// On vérifie que le statut du projet existe bien dans la liste.
		$statut = $instances['projet']->getStatutParcourClient()->get();
		if (!in_multi_array($statut, self::$_steps))
			error("le projet est corompu");

		//self::removeProtection($instances['projet']);
		$instances['projet']->removeCheck();

		$temoin = 1;
		foreach (self::$_steps as $key => $currentStatut)
		{
			if ($temoin > 1) {
				$temoin--;
				continue;
			}
			if ( $statut == $currentStatut['name']) {
				$instances['projet']->getStatutParcourClient()->set($currentStatut['name']);
				//if (!isset($currentStatut['notCommit']) || $currentStatut['notCommit'] != true)
				$instances['projet']->commit();
				$store->setSelected($instances['projet']);
				$count = self::{"set" . $statut}($instances, $store, $datas, $dh, "next");
				if ($count) {
					while (self::$_steps[$key + $count]['isBack']) {
						$rt = self::{"check" . self::$_steps[$key + $count]['name']}($instances, $store, $datas, $dh, "next");
						if (!$rt) {
							$store->error();
						}
						$count += $rt;
					}
					$instances['projet']->getStatutParcourClient()->set(self::$_steps[$key + $count]['name']);
				}
				if ($instances['projet']->getStatutParcourClient()->get() == 'Fin')
					$instances['projet']->getEtatDuProjet()->set(0);
				//if (!isset($currentStatut['notCommit']) || $currentStatut['notCommit'] != true)
				$instances['projet']->commit();
				$store->addToState($instances['projet']);
				$store->setSelected($instances['projet']);
				$store->success();
			} else if ( $datas['projet']['statut_parcour_client']['value'] == $currentStatut['name'] ) {
				$instances['projet']->getStatutParcourClient()->set(self::$_steps[$key]['name']);
				$instances['projet']->commit();
				$store->addToState($instances['projet']);
				$store->setSelected($instances['projet']);
				$store->success();
			} else {
				$rt = self::{"check" . $currentStatut['name']}($instances, $store);
				$temoin = $rt;
				if ($currentStatut['isBack'] == false)
					$instances['projet']->getStatutParcourClient()->set($currentStatut['name']);
				if (!$rt) {
					$instances['projet']->commit();
					$store->addToState($instances['projet']);
					$store->setSelected($instances['projet']);
					$store->error();
				}
			}
		}
	}
	public static function setProjetCheckProjet(&$instances, &$store, $datas, $dh, $action) {


		$projets = $dh->getProjets();
		foreach ($projets as $key => $elm) {
			if ($elm->getStatutParcourClient()->get() !== "Fin") {
				$req = "DELETE FROM `PROJET` WHERE id = :id;";
				$tt = Database::prepareNoClass("mscpi_db", $req, ["id" => $elm->getId()]);
			}
		}
		return (1);
	}

	public static function checkProjetCheckProjet($instances) {
		return (1);
	}

	public static function setProjetChoixBeneficiaire(&$instances, &$store, $datas, $dh, $action) {

		// 0 Moi seul
		// 1 Moi et mon Conjoin
		// 2 Mon conjoin
		// 3 un parent
		// 4 un enfant
		// 11 Moi et mon Conjoin + set
		// 12 Mon conjoin + set
		// 13 un parent + set
		// 14 un enfant + set


		$projet = $instances['projet'];
		if (isset($datas['formulaire']))
			$form = $datas['formulaire'];
		else
			$form = [];


		$selectedBox = intval($form['selectedBox']);

		$bf = null;
		$pp = $dh->getMyPersonnePhysique()->get();
		$pp2 = null;

		// On Vérifie si il a un béneficiaire
		$bfs = $pp->getBeneficiaires()->get();
		foreach ($bfs as $key => $elm) {
			if ($elm->getTypeBeneficiaire()->get() == 'seul')
				$bf = $elm;
		}
		if ($bf == null) {
			$bf = new Beneficiaire2();
			$bf->getTypeBeneficiaire()->set('seul');
			$bf->getDonneurDOrdre()->set($dh);
			$bf->getPersonnesPhysiques()->set($pp);
			$bf->getTypeRelation()->set('');
			$store->setSelected($bf);
			if ($bf->commit() == false)
				return (false);
			$store->addToState($bf);
			$pp = $pp->cloneFromDb();
			$store->addToState($pp);
		}

		//if (isset($form['beneficiaire']))
		if (isset($form['beneficiaire']) && intval($form['beneficiaire']['id']['value']) > 0) {
			//var_dump($form['beneficiaire']);
			//error('df');
			$bf = Beneficiaire2::getById(intval($form['beneficiaire']['id']['value']));
		} else if ($selectedBox === 0) { // Moi seul
			// On récupère sa personne physique
			// On a rien `faire ici
		} else if ($selectedBox === 11) { // Mon Couple et moi même

			$bf = null;

			// TODO Vérifier que le ppDh n'a pas déjà un beneficiaire couple
			$ppDh = $dh->getMyPersonnePhysique()->get();
			$benDh = $ppDh->getBeneficiaires()->get();
			$dhHaveCouple = false;
			$dhHaveSeul = false;
			$pp2 = null;
			$bf = null;
			foreach ($benDh as $key => $elm) {
				if ($elm->getTypeBeneficiaire()->get() == "couple") {
					$dhHaveCouple = true;
					foreach ($elm->getPersonnesPhysiques()->get() as $key2 => $elm2) {
						if ($elm2->getId() != $dh->lien_phy) {
							$pp2 = $elm2;
							$bf = $elm;
						}
					}
				} else if ($elm->getTypeBeneficiaire()->get() == "seul")
					$dhHaveSeul = true;
			}
			if (!$dhHaveCouple) {
				// Création d'une personne physique si besoins ou alors récupération.
				if ($form['PersonnePhysique']['id']['value'] != 0) {
					$pp2 = PersonnePhysique::getById(intval($form['PersonnePhysique']['id']['value']));
					$pp2->removeCheck();
					$pp2->getCivilite()->setConfig("notCheck", false);
					$pp2->getNom()->setConfig("notCheck", false);
					$pp2->getPrenom()->setConfig("notCheck", false);
				} else {
					$pp2 = new PersonnePhysique();
					$pp2->removeCheck();
					$pp2->getCivilite()->setConfig("notCheck", false);
					$pp2->getNom()->setConfig("notCheck", false);
					$pp2->getPrenom()->setConfig("notCheck", false);
					$pp2->setForGraphApi($form['PersonnePhysique']);
					$pp2->getDonneurDOrdre()->set($dh);
				}
				if ($pp2->getDonneurDOrdre()->get()->getId() != $dh->getId())
					error("ca marche pas");
				$store->setSelected($pp2);
				if ($pp2->commit() == false)
					return (false);

				$store->addToState($pp2);
				$store->setSelected($pp2);
				$bfs = $pp->getBeneficiaires()->get();

				$bf = new Beneficiaire2();
				$bf->getTypeBeneficiaire()->set('couple');
				$bf->getTypeRelation()->set('couple');
				$bf->getDonneurDOrdre()->set($dh);
				$store->setSelected($bf);
				if ($bf->commit() == false)
					return (false);
				$bf->getPersonnesPhysiques()->set($ppDh);
				$bf->getPersonnesPhysiques()->set($pp2);
				if ($bf->commit() == false)
					return (false);
				$store->addToState($bf);
				$store->addToState($pp->cloneFromDb());
				$store->addToState($pp2->cloneFromDb());
				$bf1 = $bf;


				$bf = new Beneficiaire2();
				$bf->getTypeBeneficiaire()->set('seul');
				$bf->getTypeRelation()->set('conjoint');
				$bf->getDonneurDOrdre()->set($dh);
				$store->setSelected($bf);
				if ($bf->commit() == false)
					return (false);
				$bf->getPersonnesPhysiques()->set($pp2);
				if ($bf->commit() == false)
					return (false);
				$store->addToState($bf);
				$store->addToState($pp2->cloneFromDb());
				$bf = $bf1;
			}
		}
		else if ($selectedBox === 12)  { // Mon Conjoin
			$bf = null;

			// TODO Vérifier que le ppDh n'a pas déjà un beneficiaire couple
			$ppDh = $dh->getMyPersonnePhysique()->get();
			$benDh = $ppDh->getBeneficiaires()->get();
			$dhHaveCouple = false;
			$dhHaveSeul = false;
			$pp2 = null;
			$bf = null;
			foreach ($benDh as $key => $elm) {
				if ($elm->getTypeBeneficiaire()->get() == "couple") {
					$dhHaveCouple = true;
					foreach ($elm->getPersonnesPhysiques()->get() as $key2 => $elm2) {
						if ($elm2->getId() != $dh->lien_phy) {
							$pp2 = $elm2;
							$bf = $elm;
						}
					}
				} else if ($elm->getTypeBeneficiaire()->get() == "seul")
					$dhHaveSeul = true;
			}
			if (!$dhHaveCouple) {
				// Création d'une personne physique si besoins ou alors récupération.
				if ($form['PersonnePhysique']['id']['value'] != 0) {
					$pp2 = PersonnePhysique::getById(intval($form['PersonnePhysique']['id']['value']));
					$pp2->removeCheck();
					$pp2->getCivilite()->setConfig("notCheck", false);
					$pp2->getNom()->setConfig("notCheck", false);
					$pp2->getPrenom()->setConfig("notCheck", false);
				} else {
					$pp2 = new PersonnePhysique();
					$pp2->removeCheck();
					$pp2->getCivilite()->setConfig("notCheck", false);
					$pp2->getNom()->setConfig("notCheck", false);
					$pp2->getPrenom()->setConfig("notCheck", false);
					$pp2->setForGraphApi($form['PersonnePhysique']);
					$pp2->getDonneurDOrdre()->set($dh);
				}
				if ($pp2->getDonneurDOrdre()->get()->getId() != $dh->getId())
					error("ca marche pas");
				$store->setSelected($pp2);
				if ($pp2->commit() == false)
					return (false);

				$store->addToState($pp2);
				$store->setSelected($pp2);
				$bfs = $pp->getBeneficiaires()->get();

				$bf = new Beneficiaire2();
				$bf->getTypeBeneficiaire()->set('couple');
				$bf->getTypeRelation()->set('couple');
				$bf->getDonneurDOrdre()->set($dh);
				$store->setSelected($bf);
				if ($bf->commit() == false)
					return (false);
				$bf->getPersonnesPhysiques()->set($ppDh);
				$bf->getPersonnesPhysiques()->set($pp2);
				if ($bf->commit() == false)
					return (false);
				$store->addToState($bf);
				$store->addToState($pp->cloneFromDb());
				$store->addToState($pp2->cloneFromDb());
				$bf1 = $bf;

				$bf = new Beneficiaire2();
				$bf->getTypeBeneficiaire()->set('seul');
				$bf->getTypeRelation()->set('conjoint');
				$bf->getDonneurDOrdre()->set($dh);
				$store->setSelected($bf);
				if ($bf->commit() == false)
					return (false);
				$bf->getPersonnesPhysiques()->set($pp2);
				if ($bf->commit() == false)
					return (false);
				$store->addToState($bf);
				$store->addToState($pp2->cloneFromDb());
			}
		}
		else if ($selectedBox === 13 || $selectedBox === 14)  { // Un parent
			$bf = null;
			if ($form['PersonnePhysique']['id']['value'] != 0) {
				$pp2 = PersonnePhysique::getById($form['PersonnePhysique']['id']['value']);

				$pp2->removeCheck();
				$pp2->getCivilite()->setConfig("notCheck", false);
				$pp2->getNom()->setConfig("notCheck", false);
				$pp2->getPrenom()->setConfig("notCheck", false);

			}
			else {
				$pp2 = new PersonnePhysique();

				$pp2->removeCheck();
				$pp2->getCivilite()->setConfig("notCheck", false);
				$pp2->getNom()->setConfig("notCheck", false);
				$pp2->getPrenom()->setConfig("notCheck", false);

				$pp2->setForGraphApi($form['PersonnePhysique']);
				$pp2->getDonneurDOrdre()->set($dh);
			}


			if ($pp2->getDonneurDOrdre()->get()->getId()
				!= $dh->getId())
				error("ca marche pas");

			$store->setSelected($pp2);
			if ($pp2->commit() == false)
				return (false);
			
			$store->addToState($pp2);
			$store->setSelected($pp2);
			$bfs = $pp2->getBeneficiaires()->get();
			foreach ($bfs as $key => $elm) {
				if ($elm->getTypeBeneficiaire()->get() == 'seul')
					$bf = $elm;
			}
			if ($bf == null)
			{
				$bf = new Beneficiaire2();
				$bf->getTypeBeneficiaire()->set('seul');
				if ($selectedBox == 13)
					$bf->getTypeRelation()->set('parent');
				else if ($selectedBox == 14)
					$bf->getTypeRelation()->set('enfant');
				$bf->getDonneurDOrdre()->set($dh);
				$bf->getPersonnesPhysiques()->set($pp2);
				$store->setSelected($bf);
				if ($bf->commit() == false)
					return (false);
				$store->addToState($bf);
				$store->addToState($pp2->cloneFromDb());
			}
		}
		$store->setSelected($bf);
		$store->addToState($bf);


		$projet->getMontantInvestissementPrevisionnel()->setConfig('notCheck', false);
		$projet->getMontantInvestissementPrevisionnel()->set($form['montant']['value']);

		$projet->getBeneficiaire()->set($bf);
		$projet->getConseiller()->set($dh->getConseiller()->get());

		if ($projet->commit() == false)
			return (false);

		$req = "DELETE FROM `PROJET` WHERE id_beneficiaire IS NULL;";
		$tt = Database::prepareNoClass("mscpi_db", $req, []);
		return (1);
	}

	public static function checkProjetChoixBeneficiaire($instances) {
		return (1);
	}

///////////////////////////////////////////

	public static function setProjetChoixObjectif(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (isset($datas['formulaire']))
			$form = $datas['formulaire'];
		else
			$form = [];
		$projet->getObjectifs()->setConfig("notCheck", false);
		$projet->getObjectifAutre()->setConfig("notCheck", false);
		$projet->getNom()->setConfig("notCheck", false);

		//htmlspecialchars($form['nom'])
		$nom = "";
		if (isset($form['objectifs']['value'][0]))
			$nom = $form['objectifs']['value'][0];
		$form['nom']['value'] = TypeObjectif::$_listObjectif[$nom];
		$rt = $projet->setForGraphApi($form, [
			'objectifs',
			'objectif_autre',
			'nom'
		]);
		if ($rt !== true)
		{
			$store->setSelected($rt, "Projet2");
			return (false);
		}
		return (1);
	}

	public static function checkProjetChoixObjectif($instances) {
		$projet = $instances['projet'];
		return (1);
	}

///////////////////////////////////////

	public static function setProjetMontant(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (isset($datas['formulaire']))
			$form = $datas['formulaire'];
		else
			$form = [];
		$projet->getMontantInvestissementPrevisionnel()->setConfig("notCheck", false);
		$rt = $projet->setForGraphApi($form, ['montant_investissement_previsionnel']);
		if ($rt !== true)
		{
			$store->setSelected($rt, "Projet2");
			return (false);
		}
		return (1);
	}

	public static function checkProjetMontant($instances) {
		$projet = $instances['projet'];
		return (1);
	}

///////////////////////////////////////////
	public static function setProjetCredit(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (isset($datas['formulaire']))
			$form = $datas['formulaire'];
		else
			$form = [];
		$projet->getCredit()->setConfig("notCheck", false);
		$rt = $projet->setForGraphApi($form, ['credit']);
		if ($rt !== true)
		{
			$store->setSelected($rt, "Projet2");
			return (false);
		}

		if ( $projet->getCredit()->get() == 1) {
			$projet->getOrigine()->setOnlyCredit();
			$rt2 = $projet->commit();
			return (3);
		}
		return (1);
	}

	public static function checkProjetCredit($instances) {
		$projet = $instances['projet'];
		if ( $projet->getCredit()->get() == 1)
			return (3);
		return (true);
	}
///////////////////////////////////////////

	public static function setProjetAccompagnementInvestissement(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (isset($datas['formulaire']))
			$form = $datas['formulaire'];
		else
			$form = [];
		$projet->getAccompagneInvestissement()->setConfig("notCheck", false);
		$rt = $projet->setForGraphApi($form, ['accompagne_investissement']);
		if ($rt !== true) {
			$store->setSelected($rt, "Projet2");
			return (false);
		}
		return (1);
	}

	public static function checkProjetAccompagnementInvestissement($instances) {
		$projet = $instances['projet'];
		return (1);
	}

///////////////////////////////////////////

	public static function setProjetOrigineFondsSelection(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (isset($datas['formulaire']))
			$form = $datas['formulaire'];
		else
			return (false);

		$toSet = ['origine'];

		if ($action != 'set') {
			if ($form['credit']['value'] == 1 || $form['credit']['value'] == 2) {
				$form['origine']['value']['Crédit']['enabled'] = true;
			} else if ($form['credit']['value'] == 3) {
				$form['origine']['value']['Crédit']['enabled'] = false;
				$form['origine']['value']['Crédit']['value'] = 0;
			}
		} 

		$count = 0;
		foreach ($form['origine']['value'] as $key => $elm) {
			if ($elm['enabled'] === true)
				$count++;
		}

/*
		if ($action == 'set') {
			$toSet[] = 'credit';
			if ($form['origine']['value']['Crédit']['enabled'] == true) {
				if ($count > 1)
					$form['credit']['value'] = 2;
				else
					$form['credit']['value'] = 1;
			}
			else
				$form['credit']['value'] = 3;
		}
		*/
		if ($count == 0)
			return (false);
		$count2 = $count;
		$total = 0;
		foreach ($form['origine']['value'] as $key => $elm) {
			if ($elm['enabled'] === true)
				$total += floatVal($form['origine']['value'][$key]['value']);
		}
		$actual = 100;

		if ($total < 99.1 || $total > 100.1) {
			foreach ($form['origine']['value'] as $key => $elm) {
				if ($elm['enabled'] === true) {
					$val = round($actual / $count, 2);
					$actual -= $val;
					$count--;
					$form['origine']['value'][$key]['value'] = $val;
				}
			}
		}

		DevLogs::set($total, 1);
		DevLogs::set($form['origine']['value'][$key]['value'], 1);

		$projet->getOrigine()->setConfig("notCheck", false);

		$rt = $projet->setForGraphApi($form, $toSet);
		if ($rt !== true) {
			$store->setSelected($rt, "Projet2");
			return (false);
		}
		if ($count2 == 1) {
			if ( $projet->getCredit()->get() == 3)
				return (3);
			return (2);
		}
		return (1);
	}
	public static function checkProjetOrigineFondsSelection($instances) {
		$projet = $instances['projet'];
		return (1);
	}
	public static function setProjetOrigineFonds(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (isset($datas['formulaire']))
			$form = $datas['formulaire'];
		else
			$form = [];


		$toSet = ['origine'];
		if ($action == 'set') {

			$count = 0;
			foreach ($form['origine']['value'] as $key => $elm) {
				if ($elm['enabled'] === true)
					$count++;
			}

			$toSet[] = 'credit';
			$projet->getCredit()->setConfig("notCheck", false);

			if ($form['origine']['value']['Crédit']['enabled'] == true) {
				if ($count > 1)
					$form['credit']['value'] = 2;
				else
					$form['credit']['value'] = 1;
			}
			else
				$form['credit']['value'] = 3;
		}

		$projet->getOrigine()->setConfig("notCheck", false);
		$rt = $projet->setForGraphApi($form, $toSet);
		if ($rt !== true)
		{
			$store->setSelected($rt, "Projet2");
			return (false);
		}
		if ( $projet->getCredit()->get() == 3)
			return (2);
		return (1);
	}

	public static function checkProjetOrigineFonds($instances) {
		$projet = $instances['projet'];
		if ( $projet->getCredit()->get() == 3)
			return (2);
		return (1);
	}
///////////////////////////////////////////

	public static function setCheckSituation(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		return (1);
	}

	public static function checkCheckSituation($instances, $store) {
		$projet = $instances['projet'];

		$projet->getSituationPhysique()->setConfig("notCheck", false);

		if (!isset($instances['situation'])) {
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];
		
		// Récupération du béneficiaire du projet
		$beneficiaire = $projet->getBeneficiaire()->get();
		if (empty($beneficiaire)) {
			$store->setDispatch("modal_message_box", [
				"content" => "Il y a un probleme, à cette étape le béneficiaire devrait être définit"
			]);
			$store->success();
		}

		/// Récupération de la liste des Personnes physiques liées à ce béneficiaire.
		$pps = $beneficiaire->getPersonnesPhysiques()->get();
		if (empty($pps)) {
			$store->setDispatch("modal_message_box", [
				"content" => "Il y a un probleme, le béneficiaire semble corrompu !"
			]);
			$store->success();
		}
		// On recherche une situation pour la personne physique [0]
		$situation = $pps[0]->getLastSituationPhysique();

		// Si le projet est déja lié à une situation il faut quand meme vérifier !
		$situationProjet = $projet->getSituationPhysique()->get();
		if ($situationProjet != null) {
			$pps2 = $situationProjet->getPersonnesPhysiques()->get();
			$temoin1 = true;
			foreach ($pps as $key1 => $elm1) {
				$temoin2 = false;
				foreach ($pps2 as $key2 => $elm2) {
					if ($elm1->getId() == $elm2->getId()) {
						$temoin2 = true;
						break ;
					}
				}
				if (!$temoin2) { // Si on a pas trouvé 
					$temoin1 = false;
					break ;
				}
			}
			if ($temoin1 && count($pps) == count($pps2)) {// Tout est okay
				/*
				$store->setDispatch("modal_message_box", [
					"content" => "beneficiaire/situation okay"
				]);
				*/
				return (1);
			}
			/*
			$store->setDispatch("modal_message_box", [
				"content" => "On a eu un changement de beneficiaire..."
			]);
			*/
		}

		// Si la situation du beneficiaire du projet est complete !
		if ($situation !== null && !$situation->getIsValid()->get()) // Si on en a et qu'elle est non complete
		{
			$projet->getSituationPhysique()->set($situation);
			$rt = $projet->commit();
			$store->addToState($projet);
			$store->setSelected($projet);

			$situation = $situation->cloneFromDb();
			$store->addToState($situation);
			$store->setSelected($situation, null, false);

/*
			$store->setDispatch("modal_message_box", [
				"content" => "Trouvé une situation non complete, on la link"
			]);
			*/
			return (1);
		}
		else if ($situation !== null && $situation->getIsValid()->get()) // Si on en a et qu'elle est complete
		{
			$situation = $situation->getNewCopy();
			$situation->removeCheck();
			$situation->commit();

			$projet->getSituationPhysique()->set($situation);
			$rt = $projet->commit();
			$store->addToState($projet);
			$store->setSelected($projet);

			$store->addToState($situation);
			$store->setSelected($situation, null, false);
			$store->setDispatch("modal_message_box", [
				"content" => "Trouvé une situation complete et crée un copie"
			]);
			return (1);
		}

		// Créaion d'une nouvelle situation
		$situation = new SituationPhysique();
		$situation->removeCheck();

		// On link cette situation à chacunes des personnes physiques du béneficiaire définit dans projet  !


		// Le problème est que si c'est une personne physique liée à un couple ! on va créer une nouvelles situation uniquement pour la personne physique du béneficiaire seul pluto que pour le couple !
		foreach ($pps as $pp)
			$rt = $situation->getPersonnesPhysiques()->set($pp);
		$rt = $situation->commit();
		foreach ($pps as $pp)
			$store->addToState($pp->cloneFromDb());
		if (!$rt)
		{
			$store->setDispatch("modal_message_box", [
				"content" => "L'insertion d'une nouvelle situation à échouée"
			]);
			return (false);
		}
		if (!$rt)
		{
			$store->setDispatch("modal_message_box", [
				"content" => "Impossible de linker la situation a la personne physique"
			]);
			return (false);
		}
		$store->addToState($situation);
		$projet->getSituationPhysique()->set($situation);
		$rt = $projet->commit();
		if (!$rt)
		{
			$store->setDispatch("modal_message_box", [
				"content" => "La situation n'a pas pu être linké"
			]);
			return (false);
		}
		$situation = $situation->cloneFromDb();
		$store->addToState($situation);
		$store->setSelected($situation, null, false);

		$store->addToState($projet);
		$store->setSelected($projet);
/*
		$store->setDispatch("modal_message_box", [
			"content" => "Création d'une nouvelle situation et linking !"
		]);
*/
		return (1);
	}

///////////////////////////////////////////

	public static function setJuridiqueVosInformations(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		$sit = null;
		if (!isset($datas['situation']))
		{
			$store->setDispatch("modal_message_box", [
				"content" => "Aucune donnée de situation de trouvée en base"
			]);
			$store->error();
		}
		else
			$sit = $datas['situation'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];
		$situation->getEtatCivil()->setConfig("notCheck", false);
		$situation->getRegimeMatrimonial()->setConfig("notCheck", false);
		$situation->getADesEnfants()->setConfig("notCheck", false);
		$situation->getNbrEnfants()->setConfig("notCheck", false);
		$situation->getEnfantsACharge()->setConfig("notCheck", false);
		$situation->getAutrePersonneCharge()->setConfig("notCheck", false);

		//if (isset($datas['formulaire']['value']) && $datas['formulaire']['value'] === false)
			//$sit['autre_personne_charge']['value'] = 0;

		$rt = $situation->setForGraphApi($sit, [
			"etat_civil",
			"regime_matrimonial",
			"a_des_enfants",
			"nbr_enfants",
			"enfants_a_charge",
			"autre_personne_charge",
		]);
		$store->setSelected($situation);
		if ($rt !== true) {
			$store->setSelected($rt);
			return (false);
		}
		if ($situation->commit() == false) {
			$store->setSelected($rt);
			return (false);
		}
		$store->addToState($situation);



		return (1);
	}

	public static function checkJuridiqueVosInformations($instances) {
		return (1);
	}

///////////////////////////////////////////

	public static function setJuridiquePersonnePhysique1(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		$sit = null;
		if (!isset($datas['situation']))
		{
			$store->setDispatch("modal_message_box", [
				"content" => "Aucune donnée de situation de trouvée en base"
			]);
			$store->error();
		}
		else
			$sit = $datas['situation'];

		if (!isset($datas['formulaire']['id']) || empty($datas['formulaire']['id']['value'])) {
			$store->setDispatch("modal_message_box", [
				"content" => "La requete est mal formatée"
			]);
			return (false);
		}
		$pp = PersonnePhysique::getById(intval($datas['formulaire']['id']['value']));
		if (empty($pp)) {
			$store->setDispatch("modal_message_box", [
				"content" => "La personne physique nesemble pas être trouvé en base de donnée"
			]);
		}
		$form = null;
		if (!isset($datas['formulaire']))
		{
			$store->setDispatch("modal_message_box", [
				"content" => "Aucune donnée de formulaire !"
			]);
			$store->error();
		}
		else
			$form = $datas['formulaire'];
		$pp->removeCheck();
		$pp->getCivilite()->setConfig("notCheck", false);
		$pp->getNom()->setConfig("notCheck", false);
		$pp->getPrenom()->setConfig("notCheck", false);
		$pp->getAdresse()->setConfig("notCheck", false);
		$pp->getNationalite()->setConfig("notCheck", false);
		$pp->getDateDeNaissance()->setConfig("notCheck", false);
		$pp->getPaysDeNaissance()->setConfig("notCheck", false);
		$pp->getCodePostalDeNaissance()->setConfig("notCheck", false);
		$pp->getLieuDeNaissance()->setConfig("notCheck", false);
		$pp->getCategorieProfessionnelle()->setConfig("notCheck", false);
		$pp->getDepartRetraite()->setConfig("notCheck", false);
		$pp->getCodeNaf()->setConfig("notCheck", false);

		$pp->getCivilite()->setConfig("canEmpty", false);
		$pp->getNom()->setConfig("canEmpty", false);
		$pp->getPrenom()->setConfig("canEmpty", false);
		$pp->getAdresse()->setConfig("canEmpty", false);
		$pp->getNationalite()->setConfig("canEmpty", false);
		$pp->getDateDeNaissance()->setConfig("canEmpty", false);
		$pp->getPaysDeNaissance()->setConfig("canEmpty", false);
		$pp->getCodePostalDeNaissance()->setConfig("canEmpty", false);
		$pp->getLieuDeNaissance()->setConfig("canEmpty", false);
		$pp->getCategorieProfessionnelle()->setConfig("canEmpty", false);
		$pp->getDepartRetraite()->setConfig("canEmpty", false);
		$pp->getCodeNaf()->setConfig("canEmpty", false);

		/*
		$pp->getUsPersonne()->setConfig("notCheck", false);
		$pp->getPolitiquementExpose()->setConfig("notCheck", false);
		$pp->getElementParticulier()->setConfig("notCheck", false);
		*/

		$toSet = [
			"civilite",
			"nom",
			"prenom",
			"nationalite",
			"date_de_n",
			"pays_de_naissance",
			"code_naissance",
			"lieu_de_n",
			"numeroRue",
			"extension",
			"type_voie",
			"voie",
			"complementAdresse",
			"pays",
			"codePostal",
			"ville",
			"categorie_professionelle",
			"depart_retraite",
			"code_naf"
		];

		if ($pp->getId() != $dh->lien_phy) {
			$toSet[] = 'mail';
			$pp->getMail()->setConfig("notCheck", false);
			$pp->getMail()->setConfig("canEmpty", false);
		}

		$rt = $pp->setForGraphApi($form, $toSet);
		if ($rt !== true)
		{
			$store->setSelected($rt, "PersonnePhysique");
			return (false);
		}
		$pp->commit();
		$store->addToState($pp);
		$store->setSelected($pp);

		return (1);
	}

	public static function checkJuridiquePersonnePhysique1($instances) {
		return (1);
	}
	public static function setJuridiquePersonnePhysique1Complement(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		$sit = null;
		if (!isset($datas['situation']))
		{
			$store->setDispatch("modal_message_box", [
				"content" => "Aucune donnée de situation de trouvée en base"
			]);
			$store->error();
		}
		else
			$sit = $datas['situation'];

		if (!isset($datas['formulaire']['id']) || empty($datas['formulaire']['id']['value'])) {
			$store->setDispatch("modal_message_box", [
				"content" => "La requete est mal formatée"
			]);
			return (false);
		}
		$pp = PersonnePhysique::getById(intval($datas['formulaire']['id']['value']));
		if (empty($pp)) {
			$store->setDispatch("modal_message_box", [
				"content" => "La personne physique nesemble pas être trouvé en base de donnée"
			]);
		}
		$form = null;
		if (!isset($datas['formulaire']))
		{
			$store->setDispatch("modal_message_box", [
				"content" => "Aucune donnée de formulaire !"
			]);
			$store->error();
		}
		else
			$form = $datas['formulaire'];
		//$pp->removeCheck();
		$pp->getUsPersonne()->setConfig("notCheck", false);
		$pp->getPolitiquementExpose()->setConfig("notCheck", false);
		$pp->getElementParticulier()->setConfig("notCheck", false);

		$pp->getUsPersonne()->setConfig("canEmpty", false);
		$pp->getPolitiquementExpose()->setConfig("canEmpty", false);

		$rt = $pp->setForGraphApi($form, [
			"us_person",
			"politiquement_expose",
			"element_particulier",
		]);
		if ($rt !== true)
		{
			$store->setSelected($rt, "PersonnePhysique");
			return (false);
		}
		$pp->commit();
		$store->addToState($pp);
		$store->setSelected($pp);

		// On vérifie si il y a une deuxieme personne physique
		// On récupère le béneficiaire puis on regarde si il y a une deuxieme perosnne physique !
		if (0)
			return (1);
		return (1);
	}

	public static function checkJuridiquePersonnePhysique1Complement($instances) {
		return (1);
	}

///////////////////////////////////////////

	public static function setJuridiquePersonnePhysique2(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		$sit = null;
		if (!isset($datas['situation']))
		{
			$store->setDispatch("modal_message_box", [
				"content" => "Aucune donnée de situation de trouvée en base"
			]);
			$store->error();
		}
		else
			$sit = $datas['situation'];

		if (!isset($datas['formulaire']['id']) || empty($datas['formulaire']['id']['value'])) {
			$store->setDispatch("modal_message_box", [
				"content" => "La requete est mal formatée"
			]);
			return (false);
		}
		$pp = PersonnePhysique::getById(intval($datas['formulaire']['id']['value']));
		if (empty($pp)) {
			$store->setDispatch("modal_message_box", [
				"content" => "La personne physique nesemble pas être trouvé en base de donnée"
			]);
		}
		$form = null;
		if (!isset($datas['formulaire']))
		{
			$store->setDispatch("modal_message_box", [
				"content" => "Aucune donnée de formulaire !"
			]);
			$store->error();
		}
		else
			$form = $datas['formulaire'];
		$pp->removeCheck();
		$pp->getCivilite()->setConfig("notCheck", false);
		$pp->getNom()->setConfig("notCheck", false);
		$pp->getPrenom()->setConfig("notCheck", false);
		$pp->getAdresse()->setConfig("notCheck", false);
		$pp->getNationalite()->setConfig("notCheck", false);
		$pp->getDateDeNaissance()->setConfig("notCheck", false);
		$pp->getPaysDeNaissance()->setConfig("notCheck", false);
		$pp->getCodePostalDeNaissance()->setConfig("notCheck", false);
		$pp->getLieuDeNaissance()->setConfig("notCheck", false);
		$pp->getCategorieProfessionnelle()->setConfig("notCheck", false);
		$pp->getDepartRetraite()->setConfig("notCheck", false);
		$pp->getCodeNaf()->setConfig("notCheck", false);
		$pp->getMail()->setConfig("notCheck", false);

		$pp->getCivilite()->setConfig("canEmpty", false);
		$pp->getNom()->setConfig("canEmpty", false);
		$pp->getPrenom()->setConfig("canEmpty", false);
		$pp->getAdresse()->setConfig("canEmpty", false);
		$pp->getNationalite()->setConfig("canEmpty", false);
		$pp->getDateDeNaissance()->setConfig("canEmpty", false);
		$pp->getPaysDeNaissance()->setConfig("canEmpty", false);
		$pp->getCodePostalDeNaissance()->setConfig("canEmpty", false);
		$pp->getLieuDeNaissance()->setConfig("canEmpty", false);
		$pp->getCategorieProfessionnelle()->setConfig("canEmpty", false);
		$pp->getDepartRetraite()->setConfig("canEmpty", false);
		$pp->getCodeNaf()->setConfig("canEmpty", false);
		$pp->getMail()->setConfig("canEmpty", false);

		$rt = $pp->setForGraphApi($form, [
			"civilite",
			"nom",
			"prenom",
			"nationalite",
			"date_de_n",
			"pays_de_naissance",
			"code_naissance",
			"lieu_de_n",
			"numeroRue",
			"extension",
			"type_voie",
			"voie",
			"complementAdresse",
			"pays",
			"codePostal",
			"ville",
			"categorie_professionelle",
			"depart_retraite",
			"code_naf",
			"mail"
		]);
		if ($rt !== true)
		{
			$store->setSelected($rt, "PersonnePhysique");
			return (false);
		}
		$pp->commit();
		$store->addToState($pp);
		$store->setSelected($pp);

		return (1);
	}

	public static function checkJuridiquePersonnePhysique2($instances) {
		return (1);
	}
	public static function setJuridiquePersonnePhysique2Complement(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		$sit = null;
		if (!isset($datas['situation']))
		{
			$store->setDispatch("modal_message_box", [
				"content" => "Aucune donnée de situation de trouvée en base"
			]);
			$store->error();
		}
		else
			$sit = $datas['situation'];

		if (!isset($datas['formulaire']['id']) || empty($datas['formulaire']['id']['value'])) {
			$store->setDispatch("modal_message_box", [
				"content" => "La requete est mal formatée"
			]);
			return (false);
		}
		$pp = PersonnePhysique::getById(intval($datas['formulaire']['id']['value']));
		if (empty($pp)) {
			$store->setDispatch("modal_message_box", [
				"content" => "La personne physique nesemble pas être trouvé en base de donnée"
			]);
		}
		$form = null;
		if (!isset($datas['formulaire']))
		{
			$store->setDispatch("modal_message_box", [
				"content" => "Aucune donnée de formulaire !"
			]);
			$store->error();
		}
		else
			$form = $datas['formulaire'];
		//$pp->removeCheck();
		$pp->getUsPersonne()->setConfig("notCheck", false);
		$pp->getPolitiquementExpose()->setConfig("notCheck", false);
		$pp->getElementParticulier()->setConfig("notCheck", false);

		$pp->getUsPersonne()->setConfig("canEmpty", false);
		$pp->getPolitiquementExpose()->setConfig("canEmpty", false);

		$rt = $pp->setForGraphApi($form, [
			"us_person",
			"politiquement_expose",
			"element_particulier",
		]);
		if ($rt !== true)
		{
			$store->setSelected($rt, "PersonnePhysique");
			return (false);
		}
		$pp->commit();
		$store->addToState($pp);
		$store->setSelected($pp);

		return (1);
	}

	public static function checkJuridiquePersonnePhysique2Complement($instances) {
		return (1);
	}

///////////////////////////////////////////

	public static function setFinanciereRevenus(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];

		if (!isset($datas['formulaire']['id']) || empty($datas['formulaire']['id']['value'])) {
			$store->setDispatch("modal_message_box", [
				"content" => "La requete est mal formatée"
			]);
			return (false);
		}
		$form = $datas['formulaire'];
		$situation->getRevenuSalaire()->setConfig("notCheck", false);
		$situation->getRevenuImmobilliers()->setConfig("notCheck", false);
		$situation->getRevenuMobilliers()->setConfig("notCheck", false);
		$situation->getRevenuAutres()->setConfig("notCheck", false);
		$situation->getRevenuAutresPrecision()->setConfig("notCheck", false);

		$rt = $situation->setForGraphApi($form, [
			"revenu_salaire",
			"revenu_immobilliers",
			"revenu_mobilliers",
			"revenu_autres",
			"revenu_autres_precision"
		]);
		if ($rt !== true)
		{
			$store->setSelected($rt, "SituationPhysique");
			return (false);
		}
		$situation->commit();
		$store->addToState($situation);
		$store->setSelected($situation);
		return (1);
	}

	public static function checkFinanciereRevenus($instances) {
		return (1);
	}

///////////////////////////////////////////

	public static function setFinanciereHabitation(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];

		if (!isset($datas['formulaire']['id']) || empty($datas['formulaire']['id']['value'])) {
			$store->setDispatch("modal_message_box", [
				"content" => "La requete est mal formatée"
			]);
			return (false);
		}
		$form = $datas['formulaire'];
		$situation->getHabitation()->setConfig("notCheck", false);

		$rt = $situation->setForGraphApi($form, [
			'habitation'
		]);
		if ($rt !== true)
		{
			$store->setSelected($rt, "SituationPhysique");
			return (false);
		}
		$situation->commit();
		$store->addToState($situation);
		$store->setSelected($situation);
		return (1);
	}

	public static function checkFinanciereHabitation($instances) {
		return (1);
	}

	public static function setFinanciereCharges(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];

		if (!isset($datas['formulaire']['id']) || empty($datas['formulaire']['id']['value'])) {
			$store->setDispatch("modal_message_box", [
				"content" => "La requete est mal formatée"
			]);
			return (false);
		}
		$form = $datas['formulaire'];
		$situation->getRemboursementMensuel()->setConfig("notCheck", false);
		$situation->getDureeRemboursementRestante()->setConfig("notCheck", false);
		$situation->getCreditResidenceSecondaire()->setConfig("notCheck", false);
		$situation->getCreditResidenceSecondaireDuree()->setConfig("notCheck", false);
		$situation->getCreditImmobilierLocatif()->setConfig("notCheck", false);
		$situation->getCreditImmobilierLocatifDuree()->setConfig("notCheck", false);
		$situation->getCreditScpi()->setConfig("notCheck", false);
		$situation->getCreditScpiDuree()->setConfig("notCheck", false);
		$situation->getCreditALaConsomation()->setConfig("notCheck", false);
		$situation->getCreditALaConsomationDuree()->setConfig("notCheck", false);
		$situation->getCreditAutres()->setConfig("notCheck", false);
		$situation->getCreditAutresDuree()->setConfig("notCheck", false);
		$situation->getAutresCharges()->setConfig("notCheck", false);
		$situation->getLoyer()->setConfig("notCheck", false);

		$data = $datas['formulaire'];
			if (
				$data['remboursement_mensuel']['value'] == 0 xor $data['duree_remboursement_restante']['value'] == 0 ||
				$data['credit_residence_secondaire']['value'] == 0 xor $data['credit_residence_secondaire_duree']['value'] == 0 ||
				$data['credit_immobilier_locatif']['value'] == 0 xor $data['credit_immobilier_locatif_duree']['value'] == 0 ||
				$data['credit_scpi']['value'] == 0 xor $data['credit_scpi_duree']['value'] == 0 ||
				$data['credit_a_la_consommation']['value'] == 0 xor $data['credit_a_la_consommation_duree']['value'] == 0 ||
				$data['credit_autres']['value'] == 0 xor $data['credit_autres_duree']['value'] == 0
			) {
				if ($action == 'next') {
					//$store->setDispatch("modal_message_box", [
						//"content" => "Si une charge est renseignée la durée correspondante l'est également !"
					//]);
				}
			}

		$rt = $situation->setForGraphApi($form, [
			'remboursement_mensuel',
			'duree_remboursement_restante',
			'loyer',
			'credit_residence_secondaire',
			'credit_residence_secondaire_duree',
			'credit_immobilier_locatif',
			'credit_immobilier_locatif_duree',
			'credit_scpi',
			'credit_scpi_duree',
			'credit_a_la_consommation',
			'credit_a_la_consommation_duree',
			'credit_autres',
			'credit_autres_duree',
			'autres_charges'
		]);
		if ($rt !== true)
		{
			$store->setSelected($rt, "SituationPhysique");
			return (false);
		}
		$situation->commit();
		$store->addToState($situation);
		$store->setSelected($situation);
		return (1);
	}

	public static function checkFinanciereCharges($instances) {
		return (1);
	}

///////////////////////////////////////////

	public static function setFiscaleDe(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];

		if (!isset($datas['formulaire']) || empty($datas['formulaire'])) {
			$store->setDispatch("modal_message_box", [
				"content" => "Veuillez compléter le formulaire"
			]);
			return (false);
		}
		$situation->getPaysResidenceFiscale()->setConfig("notCheck", false);


		$form = $datas['formulaire'];
		if ($form['en_france']['value'] === true)
			$form['situation']['pays_residence_fiscale']['value'] = "France";
		$rt = $situation->setForGraphApi($form['situation'], [
			'pays_residence_fiscale',
		]);
		if ($rt !== true)
		{
			$store->setSelected($rt, "SituationPhysique");
			return (false);
		}
		$situation->commit();
		$store->addToState($situation);
		$store->setSelected($situation);
		return (1);
	}

	public static function checkFiscaleDe($instances) {
		$projet = $instances['projet'];
		return (1);
	}

///////////////////////////////////////////

	public static function setFiscaleImpot(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];

		if (!isset($datas['formulaire']) || empty($datas['formulaire'])) {
			$store->setDispatch("modal_message_box", [
				"content" => "Veuillez compléter le formulaire"
			]);
			return (false);
		}
		$situation->getAssujettiImpotRevenu()->setConfig("notCheck", false);
		$situation->getImpotAnneePrecedente()->setConfig("notCheck", false);
		$situation->getTrancheMarginaleImposition()->setConfig("notCheck", false);
		$situation->getNombrePartFiscales()->setConfig("notCheck", false);
		$situation->getRegimeFoncier()->setConfig("notCheck", false);
		$situation->getDeficitFoncier()->setConfig("notCheck", false);

		
		$situation->getRevenuFiscaleReference()->setConfig("notCheck", false);

		$form = $datas['formulaire'];
		$rt = $situation->setForGraphApi($form, [
			'assujetti_impot_revenu',
			'impot_annee_precedente',
			'tranche_marginale_imposition',
			'nombre_parts_fiscales',
			'revenu_fiscale_reference',
			'regime_foncier',
			'deficit_foncier'
		]);
		if ($rt !== true)
		{
			$store->setSelected($rt, "SituationPhysique");
			return (false);
		}
		$situation->commit();
		$store->addToState($situation);
		$store->setSelected($situation);
		return (1);
	}

	public static function checkFiscaleImpot($instances) {
		$projet = $instances['projet'];
		return (1);
	}

///////////////////////////////////////////

	public static function setFiscaleIsf(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];

		if (!isset($datas['formulaire']) || empty($datas['formulaire'])) {
			$store->setDispatch("modal_message_box", [
				"content" => "Veuillez compléter le formulaire"
			]);
			return (false);
		}
		$situation->getImpotFortune()->setConfig("notCheck", false);
		$situation->getTrancheImpotFortune()->setConfig("notCheck", false);

		$form = $datas['formulaire'];
		$rt = $situation->setForGraphApi($form, [
			'impot_fortune',
			'tranche_impot_fortune',
		]);
		if ($rt !== true)
		{
		//var_dump($rt);
		//error();
			$store->setSelected($rt, "SituationPhysique");
			return (false);
		}
		$situation->commit();
		$store->addToState($situation);
		$store->setSelected($situation);
		return (1);
	}

	public static function checkFiscaleIsf($instances) {
		$projet = $instances['projet'];
		return (1);
	}

///////////////////////////////////////////

	public static function setPatrimoineSituation(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];

		if (!isset($datas['formulaire']) || empty($datas['formulaire'])) {
			$store->setDispatch("modal_message_box", [
				"content" => "Veuillez compléter le formulaire"
			]);
			return (false);
		}
		$situation->getEstimationPatrimoineGlobal()->setConfig("notCheck", false);

		$form = $datas['formulaire'];
		$rt = $situation->setForGraphApi($form, [
			'estimation_patrimoine_global',
		]);
		if ($rt !== true)
		{
			$store->setSelected($rt, "SituationPhysique");
			return (false);
		}
		$situation->commit();
		$store->addToState($situation);
		$store->setSelected($situation);
		return (1);
	}

	public static function checkPatrimoineSituation($instances) {
		$projet = $instances['projet'];
		return (1);
	}

///////////////////////////////////////////

	public static function setPatrimoineRepartition(&$instances, &$store, $datas, $dh, $action) {

		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];


		if (!isset($datas['formulaire']) || empty($datas['formulaire'])) {
			$store->setDispatch("modal_message_box", [
				"content" => "Veuillez compléter le formulaire"
			]);
			return (false);
		}
		$situation->getPatrimoineResidencePrincipale()->setConfig("notCheck", false);
		$situation->getPatrimoineAssuranceVie()->setConfig("notCheck", false);
		$situation->getPatrimoinePeaCompteTitre()->setConfig("notCheck", false);
		$situation->getPatrimoinePelCelCodeviLivret()->setConfig("notCheck", false);
		$situation->getPatrimoineResidenceSecondaire()->setConfig("notCheck", false);
		$situation->getPatrimoineImmobilierLocatif()->setConfig("notCheck", false);
		$situation->getPatrimoineEpargneRetraite()->setConfig("notCheck", false);
		$situation->getPatrimoineScpi()->setConfig("notCheck", false);
		$situation->getPatrimoineAutres()->setConfig("notCheck", false);

		$form = $datas['formulaire'];
		$rt = $situation->setForGraphApi($form, [
			'patrimoine_residence_principale',
			'patrimoine_assurance_vie',
			'patrimoine_pea_compte_titre',
			'patrimoine_pel_cel_codevi_livret',
			'patrimoine_residence_secondaire',
			'patrimoine_immobilier_locatif',
			'patrimoine_epargne_retraite',
			'patrimoine_scpi',
			'patrimoine_autres'
		]);
		if ($rt !== true)
		{
			$store->setSelected($rt, "SituationPhysique");
			return (false);
		}
		$situation->commit();
		$store->addToState($situation);
		$store->setSelected($situation);
		return (1);
		$projet = $instances['projet'];
		return (1);
	}

	public static function checkPatrimoineRepartition($instances) {
		$projet = $instances['projet'];
		return (1);
	}

///////////////////////////////////////////

	public static function setPatrimoineFuturePlacement(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];


		if (!isset($datas['formulaire']) || empty($datas['formulaire'])) {
			$store->setDispatch("modal_message_box", [
				"content" => "Veuillez compléter le formulaire"
			]);
			return (false);
		}
		$situation->getPatrimoinePartFuturPlacement()->setConfig("notCheck", false);

		$form = $datas['formulaire'];
		$rt = $situation->setForGraphApi($form, [
			'patrimoine_part_futur_placement',
		]);
		if ($rt !== true)
		{
			$store->setSelected($rt, "SituationPhysique");
			return (false);
		}
		$situation->commit();
		$store->addToState($situation);
		$store->setSelected($situation);
		return (1);
		$projet = $instances['projet'];
		return (1);
	}

	public static function checkPatrimoineFuturePlacement($instances) {
		$projet = $instances['projet'];
		return (1);
	}

	public static function setCheckProfilInvestisseur(&$instances, &$store, $datas, $dh, $action) {
		return (1);
	}

	public static function checkCheckProfilInvestisseur(&$instances, $store) {
		$projet = $instances['projet'];

		// On récupère les personnes physiques.
		$pps = $projet->getPersonnesPhysiques();
		if (empty($pps)) {
			$store->setDispatch("modal_message_box", [
				"content" => "Il y a eu un probleme !? vous ne pouvez actuellement pas continuer votre création de projet."
			]);
		}

		// On les vérifie une par une si elles on un profil complet et valide.
		$temoin = false;
		$ppProfil = null;
		foreach ($pps as $key => $pp) {
			$profils = $pp->getProfilInvestisseur()->get();

			if (empty($profils)) { // Dans ce cas ce pp n'a aucun profil valide
				$temoin = true;
				$ppProfil = $pp;
				break ;
			}

			$temoin2 = false;
			foreach ($profils as $key2 => $profil) {
				if ($profil->getIsPerime() === false && $profil->getIsComplete()->get() === true) {
					$profil->removeCheck();
					$instances['profil'] = $profil;
					$store->addToState($profil);
					$store->setSelected($profil);
					$temoin2 = true;
					break;
				}
			}
			if (!$temoin2) {
				$temoin = true;
				$ppProfil = $pp;
				break ;
			}
		}
		if ($temoin === false) {
			return (11);
		}
		$store->setSelected($ppProfil);
		$name = $ppProfil->getShortName();
		$profils = $pp->getProfilInvestisseur()->get();
		$profil = null;


		if (!empty($profils)) { // Dans ce cas on a des profils il faut voir si il y en a un incomplet
			foreach ($profils as $key2 => $profil) {
				if ($profil->getIsComplete()->get() !== true && $profil->getIsPerime() === false) {
					$profil->removeCheck();
					$instances['profil'] = $profil;
					$store->addToState($profil);
					$store->setSelected($profil);
					return (1);
				}
			}
		}
		$profil = new ProfilInvestisseur2();
		$profil->removeCheck();
		$profil->getPersonnePhysique()->setConfig("notCheck", false);
		$profil->getPersonnePhysique()->set($pp);
		$profil->commit();
		$instances['profil'] = $profil;
		$store->addToState($profil);
		$store->setSelected($profil);

		// Si on arrive ici c'est qu'il n'y a aucun profil valide et qu'il faut en créer un !
		$store->setDispatch("modal_message_box", [
			"config" => [
				"props" => [
					"title" => "Profil investisseur de $name",
					"html" => "Dans le cadre de la réglementation, il est obligatoire</br>de connaitre le profil investisseur de chaque bénéficiaire.</br></br>Vous allez compléter le profil investisseur de $name"
				]
			],
		]);

		return (1);
	}
	public static function setProfilInvestisseurRisque(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (!isset($instances['profil'])) {
			if (!isset($datas['selectedProfilInvestisseur'])) {
				$store->setDispatch("modal_message_box", [
					"content" => "Il y a un problème avec votre formulaire, nous vous prions de nous en excuser !"
				]);
				return (false); }
			$instances['profil'] = ProfilInvestisseur2::getById(intval($datas['selectedProfilInvestisseur']['id']['value']));
			$instances['profil']->removeCheck();
		}
		$profil = $instances['profil'];
		$profil->getNiveauRisque()->setConfig("notCheck", false);
		$form = $datas['formulaire'];
		$rt = $profil->setForGraphApi($form, [
			'niveau_risque',
		]);
		if ($rt !== true) {
			$store->setSelected($rt, "ProfilInvestisseur2");
			return (false);
		}
		$profil->commit();
		$store->addToState($profil);
		$store->setSelected($profil);
		return (1);
	}

	public static function checkProfilInvestisseurRisque($instances) {
		return (1);
	}

	public static function setProfilInvestisseurCompetences(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (!isset($instances['profil'])) {
			if (!isset($datas['selectedProfilInvestisseur'])) {
				$store->setDispatch("modal_message_box", [
					"content" => "Il y a un problème avec votre formulaire, nous vous prions de nous en excuser !"
				]);
				return (false);
			}
			$instances['profil'] = ProfilInvestisseur2::getById(intval($datas['selectedProfilInvestisseur']['id']['value']));
			$instances['profil']->removeCheck();
		}
		$profil = $instances['profil'];
		$profil->getCompetencesImmobilieres()->setConfig("notCheck", false);
		$form = $datas['formulaire'];
		$rt = $profil->setForGraphApi($form, [
			'competences_imobilieres',
		]);
		if ($rt !== true) {
			$store->setSelected($rt, "ProfilInvestisseur2");
			return (false);
		}
		$profil->commit();
		$store->addToState($profil);
		$store->setSelected($profil);
		return (1);
	}

	public static function checkProfilInvestisseurCompetences($instances) {
		return (1);
	}
	public static function setProfilInvestisseurCompetencesFinance(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (!isset($instances['profil'])) {
			if (!isset($datas['selectedProfilInvestisseur'])) {
				$store->setDispatch("modal_message_box", [
					"content" => "Il y a un problème avec votre formulaire, nous vous prions de nous en excuser !"
				]);
				return (false);
			}
			$instances['profil'] = ProfilInvestisseur2::getById(intval($datas['selectedProfilInvestisseur']['id']['value']));
			$instances['profil']->removeCheck();
		}
		$profil = $instances['profil'];
		$profil->getCompetencesFinancieres()->setConfig("notCheck", false);
		$form = $datas['formulaire'];
		$rt = $profil->setForGraphApi($form, [
			'competences_financieres',
		]);
		if ($rt !== true) {
			$store->setSelected($rt, "ProfilInvestisseur2");
			return (false);
		}
		$profil->commit();
		$store->addToState($profil);
		$store->setSelected($profil);
		return (1);
	}

	public static function checkProfilInvestisseurCompetencesFinance($instances) {
		return (1);
	}

	public static function setProfilInvestisseurMarcheImmobiliers(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (!isset($instances['profil'])) {
			if (!isset($datas['selectedProfilInvestisseur'])) {
				$store->setDispatch("modal_message_box", [
					"content" => "Il y a un problème avec votre formulaire, nous vous prions de nous en excuser !"
				]);
				return (false);
			}
			$instances['profil'] = ProfilInvestisseur2::getById(intval($datas['selectedProfilInvestisseur']['id']['value']));
			$instances['profil']->removeCheck();
		}
		$profil = $instances['profil'];
		$profil->getConnaissanceMarcheImbobilier()->setConfig("notCheck", false);
		$form = $datas['formulaire'];
		$rt = $profil->setForGraphApi($form, [
			'connaissance_marche_imbobilier',
		]);
		if ($rt !== true) {
			$store->setSelected($rt, "ProfilInvestisseur2");
			return (false);
		}
		$profil->commit();
		$store->addToState($profil);
		$store->setSelected($profil);
		return (1);
	}
	public static function checkProfilInvestisseurMarcheImmobiliers($instances) {
		return (1);
	}

	public static function setProfilInvestisseurSupportPlacement(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (!isset($instances['profil'])) {
			if (!isset($datas['selectedProfilInvestisseur'])) {
				$store->setDispatch("modal_message_box", [
					"content" => "Il y a un problème avec votre formulaire, nous vous prions de nous en excuser !"
				]);
				return (false);
			}
			$instances['profil'] = ProfilInvestisseur2::getById(intval($datas['selectedProfilInvestisseur']['id']['value']));
			$instances['profil']->removeCheck();
		}
		$profil = $instances['profil'];
		$profil->getConnaissancePlacementActions()->setConfig("notCheck", false);
		$profil->getConnaissancePlacementScpi()->setConfig("notCheck", false);
		$profil->getConnaissancePlacementAssuranceVie()->setConfig("notCheck", false);
		$profil->getConnaissancePlacementOpci()->setConfig("notCheck", false);
		$profil->getConnaissancePlacementObligations()->setConfig("notCheck", false);
		$profil->getConnaissancePlacementFcpiFipFcpr()->setConfig("notCheck", false);
		$profil->getConnaissancePlacementOpcvm()->setConfig("notCheck", false);
		$profil->getConnaissancePlacementCrowdfunding()->setConfig("notCheck", false);

		$form = $datas['formulaire'];
		$rt = $profil->setForGraphApi($form, [
			'connaissance_placement_actions',
			'connaissance_placement_scpi',
			'connaissance_placement_assurance_vie',
			'connaissance_placement_opci',
			'connaissance_placement_obligations',
			'connaissance_placement_fcpi_fip_fcpr',
			'connaissance_placement_opcvm',
			'connaissance_placement_crowdfunding'
		]);
		if ($rt !== true) {
			$store->setSelected($rt, "ProfilInvestisseur2");
			return (false);
		}
		$profil->commit();
		$store->addToState($profil);
		$store->setSelected($profil);
		return (1);
	}
	public static function checkProfilInvestisseurSupportPlacement($instances) {
		return (1);
	}

	public static function setProfilInvestisseurPlacementDetenus(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (!isset($instances['profil'])) {
			if (!isset($datas['selectedProfilInvestisseur'])) {
				$store->setDispatch("modal_message_box", [
					"content" => "Il y a un problème avec votre formulaire, nous vous prions de nous en excuser !"
				]);
				return (false);
			}
			$instances['profil'] = ProfilInvestisseur2::getById(intval($datas['selectedProfilInvestisseur']['id']['value']));
			$instances['profil']->removeCheck();
		}
		$profil = $instances['profil'];
		$profil->getDisposeActions()->setConfig("notCheck", false);
		$profil->getDisposeFcpiFipFcpr()->setConfig("notCheck", false);
		$profil->getDisposeOpcvm()->setConfig("notCheck", false);
		$profil->getDisposeAssuranceVie()->setConfig("notCheck", false);
		$profil->getDisposeObligations()->setConfig("notCheck", false);
		$profil->getDisposeScpi()->setConfig("notCheck", false);
		$profil->getDisposeOpci()->setConfig("notCheck", false);
		$profil->getDisposeLiquidite()->setConfig("notCheck", false);
		$profil->getDisposePea()->setConfig("notCheck", false);
		$profil->getDisposeImmobilierDirect()->setConfig("notCheck", false);
		$profil->getDisposeCrowdFunding()->setConfig("notCheck", false);

		$form = $datas['formulaire'];
		$cols = [
			'dispose_actions',
			'dispose_fcpi_fip_fcpr',
			'dispose_opcvm',
			'dispose_assurance_vie',
			'dispose_obligations',
			'dispose_scpi',
			'dispose_opci',
			'dispose_liquidite',
			'dispose_pea',
			'dispose_immobilier_direct',
			'dispose_crowdfunding'
		];
		$rt = $profil->setForGraphApi($form, $cols);
		if ($rt !== true) {
			$store->setSelected($rt, "ProfilInvestisseur2");
			return (false);
		}
		$profil->commit();
		$store->addToState($profil);
		$store->setSelected($profil);
		foreach ($cols as $elm) {
			if ( $datas['formulaire'][$elm]['value'])
				return (1);
		}
		return (2);
	}
	public static function checkProfilInvestisseurPlacementDetenus(&$instances, &$store) {
		$projet = $instances['projet'];
		if (!isset($instances['profil'])) {
			$profil =  $projet->getProfilInvestisseurIncomplet();
			if (empty($profil)) {
				$store->setDispatch("modal_message_box", [
					"content" => "Une erreur est survenue. Nous vous prions de bien vouloir nous en excuser."
				]);
				return (false);
			}
			$instances['profil'] = $profil;
			$instances['profil']->removeCheck();
		}
		$profil = $instances['profil'];
		if (
			$profil->getDisposeActions()->get() ||
			$profil->getDisposeFcpiFipFcpr()->get() ||
			$profil->getDisposeOpcvm()->get() ||
			$profil->getDisposeAssuranceVie()->get() ||
			$profil->getDisposeObligations()->get() ||
			$profil->getDisposeScpi()->get() ||
			$profil->getDisposeOpci()->get() ||
			$profil->getDisposeLiquidite()->get() ||
			$profil->getDisposePea()->get() ||
			$profil->getDisposeImmobilierDirect()->get() ||
			$profil->getDisposeCrowdFunding()->get()
		)
			return (1);
		return (2);
	}

	public static function setProfilInvestisseurModeGestion(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (!isset($instances['profil'])) {
			if (!isset($datas['selectedProfilInvestisseur'])) {
				$store->setDispatch("modal_message_box", [
					"content" => "Il y a un problème avec votre formulaire, nous vous prions de nous en excuser !"
				]);
				return (false);
			}
			$instances['profil'] = ProfilInvestisseur2::getById(intval($datas['selectedProfilInvestisseur']['id']['value']));
			$instances['profil']->removeCheck();
		}

		if (
			!$datas['formulaire']['gestion_directe']['value'] &&
			!$datas['formulaire']['gestion_conseiller']['value'] &&
			!$datas['formulaire']['gestion_sous_mandat']['value'] &&
			$action != 'previous'
		) {
			$store->setDispatch("modal_message_box", [
				"content" => "Veuillez préciser le(s) mode(s) de gestion de vos actifs"
			]);
			return (false);
		}


		$profil = $instances['profil'];
		$profil->getGestionDirecte()->setConfig("notCheck", false);
		$profil->getGestionConseiller()->setConfig("notCheck", false);
		$profil->getGestionSousMandat()->setConfig("notCheck", false);


		$form = $datas['formulaire'];
		$rt = $profil->setForGraphApi($form, [
			'gestion_directe',
			'gestion_conseiller',
			'gestion_sous_mandat'
		]);
		if ($rt !== true) {
			$store->setSelected($rt, "ProfilInvestisseur2");
			return (false);
		}
		$profil->commit();
		$store->addToState($profil);
		$store->setSelected($profil);
		return (1);
	}
	public static function checkProfilInvestisseurModeGestion($instances) {
		return (1);
	}

	public static function setProfilInvestisseurConnaissance(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (!isset($instances['profil'])) {
			if (!isset($datas['selectedProfilInvestisseur'])) {
				$store->setDispatch("modal_message_box", [
					"content" => "Il y a un problème avec votre formulaire, nous vous prions de nous en excuser !"
				]);
				return (false);
			}
			$instances['profil'] = ProfilInvestisseur2::getById(intval($datas['selectedProfilInvestisseur']['id']['value']));
			$instances['profil']->removeCheck();
		}
		$profil = $instances['profil'];
		$profil->getConnaissanceScpi()->setConfig("notCheck", false);

		$form = $datas['formulaire'];
		$rt = $profil->setForGraphApi($form, [
			'connaissance_scpi'
		]);
		if ($rt !== true) {
			$store->setSelected($rt, "ProfilInvestisseur2");
			return (false);
		}
		$profil->commit();
		$store->addToState($profil);
		$store->setSelected($profil);
		return (1);
	}
	public static function checkProfilInvestisseurConnaissance($instances) {
		return (1);
	}

	public static function setProfilInvestisseurSiJinvestis(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (!isset($instances['profil'])) {
			if (!isset($datas['selectedProfilInvestisseur'])) {
				$store->setDispatch("modal_message_box", [
					"content" => "Il y a un problème avec votre formulaire, nous vous prions de nous en excuser !"
				]);
				return (false);
			}
			$instances['profil'] = ProfilInvestisseur2::getById(intval($datas['selectedProfilInvestisseur']['id']['value']));
			$instances['profil']->removeCheck();
		}
		$profil = $instances['profil'];
		$profil->getSiJinvesti10000()->setConfig("notCheck", false);

		$form = $datas['formulaire'];
		$rt = $profil->setForGraphApi($form, [
			'si_jinvesti_10000'
		]);
		if ($rt !== true) {
			$store->setSelected($rt, "ProfilInvestisseur2");
			return (false);
		}
		$profil->commit();
		$store->addToState($profil);
		$store->setSelected($profil);
		return (1);
	}
	public static function checkProfilInvestisseurSiJinvestis($instances) {
		return (1);
	}

	public static function setProfilInvestisseurQuizScpi(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (!isset($instances['profil'])) {
			if (!isset($datas['selectedProfilInvestisseur'])) {
				$store->setDispatch("modal_message_box", [
					"content" => "Il y a un problème avec votre formulaire, nous vous prions de nous en excuser !"
				]);
				return (false);
			}
			$instances['profil'] = ProfilInvestisseur2::getById(intval($datas['selectedProfilInvestisseur']['id']['value']));
			$instances['profil']->removeCheck();
		}
		$profil = $instances['profil'];
		$profil->getQuiz()->setConfig("notCheck", false);

		$form = $datas['formulaire'];
		$rt = $profil->setForGraphApi($form, [
			'quiz'
		]);
		if ($rt !== true) {
			$store->setSelected($rt, "ProfilInvestisseur2");
			return (false);
		}
		$profil->commit();
		$store->addToState($profil);
		$store->setSelected($profil);
		return (1);
	}
	public static function checkProfilInvestisseurQuizScpi($instances) {
		return (1);
	}

	public static function setProfilInvestisseurEnd(&$instances, &$store, $datas, $dh, $action) {
		return (1);
	}
	public static function checkProfilInvestisseurEnd($instances, $store) {

		/*
		$projet = $instances['projet'];
		if (!isset($instances['profil'])) {
			if (!isset($datas['selectedProfilInvestisseur'])) {
				$store->setDispatch("modal_message_box", [
					"content" => "Il y a un problème avec votre formulaire, nous vous prions de nous en excuser !"
				]);
				return (false);
			}
			$instances['profil'] = ProfilInvestisseur2::getById(intval($datas['selectedProfilInvestisseur']['id']['value']));
			$instances['profil']->removeCheck();
		}
		$profil = $instances['profil'];
		$profil->getIsComplete()->setConfig("notCheck", false);
		$profil->getIsComplete()->set(true);
		$rt = $profil->commit();
		if ($rt !== true) {
			$store->setDispatch("modal_message_box", [
				"content" => "La validation du profil d'investisseur à échoué !"
			]);
		}
		$store->addToState($profil);
		$store->setSelected($profil);

		// On récupère les personnes physiques.
		$pps = $projet->getPersonnesPhysiques();

		
		// On les vérifie une par une si elles on un profil complet et valide.
		$temoin = false;
		$ppProfil = null;
		foreach ($pps as $key => $pp) {
			$profils = $pp->getProfilInvestisseur()->get();

			if (empty($profils)) { // Dans ce cas ce pp n'a aucun profil valide
				return (-9);
			}

			$temoin2 = false;
			foreach ($profils as $key2 => $profil) {
				if ($profil->getIsPerime() === false && $profil->getIsComplete()->get() === true) {
					$profil->removeCheck();
					$instances['profil'] = $profil;
					$store->addToState($profil);
					$store->setSelected($profil);
					$temoin2 = true;
					break;
				}
			}
			if (!$temoin2) {
				return (-9);
			}
		}
		*/
		return (1);
	}
	public static function setProfilInvestisseurNote(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (!isset($instances['profil'])) {
			if (!isset($datas['selectedProfilInvestisseur'])) {
				$store->setDispatch("modal_message_box", [
					"content" => "Il y a un problème avec votre formulaire, nous vous prions de nous en excuser !"
				]);
				return (false);
			}
			$instances['profil'] = ProfilInvestisseur2::getById(intval($datas['selectedProfilInvestisseur']['id']['value']));
			$instances['profil']->removeCheck();
		}
		$profil = $instances['profil'];



		$profil->getIsComplete()->setConfig("notCheck", false);
		$profil->getIsComplete()->set(true);
		$rt = $profil->commit();
		if ($rt !== true) {
			$store->setDispatch("modal_message_box", [
				"content" => "La validation du profil d'investisseur à échoué !"
			]);
		}
		$store->addToState($profil);
		$store->setSelected($profil);

		// On récupère les personnes physiques.
		$pps = $projet->getPersonnesPhysiques();





		// On les vérifie une par une si elles on un profil complet et valide.
		$temoin = false;
		$ppProfil = null;
		foreach ($pps as $key => $pp) {
			$profils = $pp->getProfilInvestisseur()->get();

			if (empty($profils)) { // Dans ce cas ce pp n'a aucun profil valide
				return (-11);
			}

			$temoin2 = false;
			foreach ($profils as $key2 => $profil) {
				if ($profil->getIsPerime() === false && $profil->getIsComplete()->get() === true) {
					$profil->removeCheck();
					$instances['profil'] = $profil;
					$store->addToState($profil);
					$store->setSelected($profil);
					$temoin2 = true;
					break;
				}
			}
			if (!$temoin2) {
				return (-11);
			}
		}
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];

		return (1);
	}

	public static function setProjetEnd(&$projet, &$situation) {
		$situation->getIsValid()->set(true);
		$situation->commit();
		$st2 = $situation->cloneFromDb();
		DevLogs::set(
			"situation:" + $situation->getIsValid()->get() + "-" + $st2->getIsValid()->get()
		, 1);
		$store->addToState($situation);
		$store->setSelected($situation);

		$projet->getEtatDuProjet()->set(0);
		DevLogs::set(
			"Projet:" + $projet->getEtatDuProjet()->get()
		, 1);
		$projet->commit();
	}

	public static function checkProfilInvestisseurNote(&$instances, &$store) {
		return (1);
	}

	public static function check(&$instances, &$store) {

	}

	public static function setFin(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];
		static::setProjetEnd($projet, $situation);
		return (false);
	}

/*
	public static function setProfilInvestisseur(&$instances, &$store, $datas, $dh, $action) {
		return (1);
	}
	public static function checkProfilInvestisseur($instances) {
		return (1);
	}
*/

	public static function checkCoherenceCommun(&$instances, &$store, $datas, $nbr) {

		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];
		if ($situation->checkCoherence($nbr))
			return (true);
		if (!empty($datas['nbr_incoherence']) && $datas['nbr_incoherence'] == $nbr) {
			$form = $datas['formulaire'];
			$situation->{"getPrecisionCoherence" . $nbr}()->setConfig('notCheck', false);
			$situation->{"getPrecisionCoherence" . $nbr}()->setConfig('canEmpty', false);
			$rt = $situation->setForGraphApi($form, [
				'precision_coherence_' . $nbr,
			]);
			if ($rt !== true)
			{
				$store->setSelected($rt, "SituationPhysique");
				$store->error();
			}
			$situation->commit();
			$store->setSelected($situation);
			return (true);
		}
		return (false);
	}

	public static function checkCoherence1(&$instances, &$store, $datas = null) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];
		if (self::checkCoherenceCommun($instances, $store, $datas, 1)) {
			return (1);
		}

		if (
			$situation->getADesEnfants()->get() !== true &&
			$projet->getObjectifs()->have(3)
		)
		{
			$store->setDispatch("set_incoherence", [
				"config" => [
					"havePrecision" => true,
					"haveModify" => true,
					"haveClose" => false,
				],
				"coherence_nbr" => 1,
				"button" => [
					"objectifs" => [
						"text" => 'MES OBJECTIFS',
						"action" => 'set_block',
						"payload" => [
							"component" => "component-projet-choixobjectif-noname"
						]
					],
					"enfants" => [
						"text" => 'MA SITUATION JURIDIQUE',
						"mutation" => 'modal_stack_pop'
					]
				],
				"html" => "
					<p>
						Vous avez indiqué que l’un de vos objectifs est de transmettre un capital à vos proches alors que vous n’avez pas d’enfant.
					</p>
				",
				"html2" => "
					<p>
						Que souhaitez-vous modifier ?
					</p>
				",
			]);
			return (false);
		}
		return (1);
	}

	public static function checkCoherence2(&$instances, &$store, $datas = null) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];
		if (self::checkCoherenceCommun($instances, $store, $datas, 2)) {
			return (1);
		}


		if (
			$projet->getCredit()->get() != 3 &&
			($situation->getTotalRevenus() * 0.33) <= $situation->getTotalCharges()
		)
		{
			$store->setDispatch("set_incoherence", [
				"config" => [
					"havePrecision" => true,
					"haveModify" => true,
					"haveClose" => false,
				],
				"coherence_nbr" => 2,
				"button" => [
					"revenus" => [
						"text" => "MES REVENUS",
						"action" => 'set_block',
						"payload" => [
							"component" => "component-projet-financiererevenus-noname"
						]
					],
					"charges" => [
						"text" => 'MES CHARGES',
						"mutation" => 'modal_stack_pop'
					],
					"origine" => [
						"text" => "L'ORIGINE DE MES FONDS",
						"action" => 'set_block',
						"payload" => [
							"component" => "component-projet-originefonds-incoherence-noname"
						]
					],
				],
				"html" => "
					<p>
						Au regard de votre taux d’endettement actuel, nous vous informons de la complexité de mettre en place un dossier de financement pour ce nouvel investissement
					</p>
				",
				"html2" => "
					<p>
						Que souhaitez-vous modifier ?
					</p>
				",
			]);
			return (false);
		}
		return (1);
	}

	public static function checkCoherence3(&$instances, &$store, $datas = null) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];
		if (self::checkCoherenceCommun($instances, $store, $datas, 3)) {
			return (1);
		}


		if (
			$projet->getOrigine()->get()['Épargne']['value'] > 0 &&
			($situation->getTotalRevenus() * 0.2) <= $situation->getTotalCharges()
		)
		{
			$store->setDispatch("set_incoherence", [
				"config" => [
					"havePrecision" => true,
					"haveModify" => true,
					"haveClose" => false,
				],
				"coherence_nbr" => 3,
				"button" => [
					"revenus" => [
						"text" => "MES REVENUS",
						"action" => 'set_block',
						"payload" => [
							"component" => "component-projet-financiererevenus-noname"
						]
					],
					"charges" => [
						"text" => 'MES CHARGES',
						"mutation" => 'modal_stack_pop'
					],
					"origine" => [
						"text" => "L'ORIGINE DE MES FONDS",
						"action" => 'set_block',
						"payload" => [
							"component" => "component-projet-originefonds-incoherence-noname"
						]
					],
				],
				"html" => "
					<p>
						Vous avez indiqué qu’une partie ou la totalité de l’origine des fonds du projet est le fruit de votre épargne alors que vos charges sont supérieures à 20% de vos revenus
					</p>
				",
				"html2" => "
					<p>
						Que souhaitez-vous modifier ?
					</p>
				",
			]);
			return (false);
		}
		return (1);
	}

	public static function checkCoherence4(&$instances, &$store, $datas = null) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];
		if (self::checkCoherenceCommun($instances, $store, $datas, 4)) {
			return (1);
		}

		if (
			$projet->getOrigine()->get()["Cessions d’actifs mobiliers"]['value'] > 0 &&
			$situation->getPatrimoinePeaCompteTitre()->get() == 0 &&
			$situation->getPatrimoineAssuranceVie()->get() == 0
		)
		{
			$store->setDispatch("set_incoherence", [
				"config" => [
					"havePrecision" => true,
					"haveModify" => true,
					"haveClose" => false,
				],
				"coherence_nbr" => 4,
				"button" => [
					"origine" => [
						"text" => "L'ORIGINE DE MES FONDS",
						"action" => 'set_block',
						"payload" => [
							"component" => "component-projet-originefonds-incoherence-noname"
						]
					],
					"patrimoine" => [
						"text" => 'MON PATRIMOINE',
						"mutation" => 'modal_stack_pop'
					],
				],
				"html" => "
					<p>
						Vous avez indiqué qu’une partie ou la totalité de l’origine des fonds du projet est le fruit de la vente d’un actif financier alors que vous indiquez ne pas avoir d’actif financiers
					</p>
				",
				"html2" => "
					<p>
						Que souhaitez-vous modifier ?
					</p>
				",
			]);
			return (false);
		}
		return (1);
	}

	public static function checkCoherence5(&$instances, &$store, $datas = null) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];
		if (self::checkCoherenceCommun($instances, $store, $datas, 5)) {
			return (1);
		}

		if (
			$projet->getOrigine()->get()["Cession d’actifs immobiliers"]['value'] > 0 &&
			$situation->getPatrimoineResidencePrincipale()->get() == 0 &&
			$situation->getPatrimoineResidenceSecondaire()->get() == 0 &&
			$situation->getPatrimoineImmobilierLocatif()->get() == 0 &&
			$situation->getPatrimoineScpi()->get() == 0
		)
		{
			$store->setDispatch("set_incoherence", [
				"config" => [
					"havePrecision" => true,
					"haveModify" => true,
					"haveClose" => false,
				],
				"coherence_nbr" => 5,
				"button" => [
					"origine" => [
						"text" => "L'ORIGINE DE MES FONDS",
						"action" => 'set_block',
						"payload" => [
							"component" => "component-projet-originefonds-incoherence-noname"
						]
					],
					"patrimoine" => [
						"text" => 'MON PATRIMOINE',
						"mutation" => 'modal_stack_pop'
					],
				],
				"html" => "
					<p>
						Vous avez indiqué qu’une partie ou la totalité de l’origine des fonds du projet est le fruit de la vente d’un actif immobilier alors que vous indiquez ne pas avoir d’actif immobilier
					</p>
				",
				"html2" => "
					<p>
						Que souhaitez-vous modifier ?
					</p>
				",
			]);
			return (false);
		}
		return (1);
	}

	public static function checkCoherence6(&$instances, &$store, $datas = null) {
		$projet = $instances['projet'];
		$sit = null;
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];

		$ben = $projet->getBeneficiaire()->get();

		
		//$pp = $situation->getPersonnesPhysiques()->get();
		$pp = $ben->getPersonnesPhysiques()->get()[0]->cloneFromDb();
		if (empty($pp))
		{
			$store->setDispatch("modal_message_box", [
				"content" => "Il y a un probleme, La situation n'est liée à aucune personne physique !"
			]);
		}
		if (self::checkCoherenceCommun($instances, $store, $datas, 6)) {
			if (count($ben->getPersonnesPhysiques()->get()) >= 2) {
				return (1);
			} else {
				return (4);
			}
		}

		//$pp = $pp[0];
		$naissance =  intval($pp->getDateDeNaissance()->get()->format('Y'));
		$retraite = $pp->getDepartRetraite()->get();

		//var_dump(intval($pp->getCategorieProfessionnelle()->get()['code_1']));
		//var_dump($naissance);
		//var_dump($retraite);

		if (
			intval($pp->getCategorieProfessionnelle()->get()['code_1']) != 7 &&
			($retraite - $naissance) < 52
		)
		{
			$store->setDispatch("set_incoherence", [
				"config" => [
					"havePrecision" => true,
					"haveModify" => false,
					"haveClose" => true,
				],
				"coherence_nbr" => 6,
				"button" => [
					"modif" => [
						"text" => '',
						"mutation" => 'modal_stack_pop'
					]
				],
				"html" => "
					<p>
						Vous avez indiqué que votre âge prévisionnel de départ à la retraite est inférieur à 52 ans
					</p>
				",
				"html2" => "
					<p>
						Que souhaitez-vous modifier ?
					</p>
				",
				//"title" => "titre 1"
			]);
			return (false);
		}
		else if (
			intval($pp->getCategorieProfessionnelle()->get()['code_1']) != 7 &&
			($retraite - $naissance) > 62
		)
		{
			$store->setDispatch("set_incoherence", [
				"config" => [
					"havePrecision" => true,
					"haveModify" => false,
					"haveClose" => true,
				],
				"coherence_nbr" => 6,
				"button" => [
					"modif" => [
						"text" => '',
						"mutation" => 'modal_stack_pop'
					]
				],
				"html" => "
					<p>
						Vous avez indiqué que votre âge prévisionnel de départ à la retraite est supérieur à 62 ans
					</p>
				",
				"html2" => "
					<p>
						Que souhaitez-vous modifier ?
					</p>
				",
				//"title" => "titre 1"
			]);
			return (false);
		}
			if (count($ben->getPersonnesPhysiques()->get()) >= 2) {
				return (1);
			} else {
				return (4);
			}
	}

	public static function checkCoherence6_2(&$instances, &$store, $datas = null) {
		$projet = $instances['projet'];
		$sit = null;
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];

		$ben = $projet->getBeneficiaire()->get();

		
		if (count($ben->getPersonnesPhysiques()->get()) < 2)
		{
			$store->setDispatch("modal_message_box", [
				"content" => "Il y a un probleme, vous ne pouvez pas saisir un second bénéficiaire !"
			]);
			return (false);
		}

		$pp = $ben->getPersonnesPhysiques()->get()[1]->cloneFromDb();
		if (empty($pp))
		{
			$store->setDispatch("modal_message_box", [
				"content" => "Il y a un probleme, La situation n'est liée à aucune personne physique !"
			]);
		}
		if (self::checkCoherenceCommun($instances, $store, $datas, 6)) {
			// TODO Checker si il y a une deuxieme personne Physique
			return (2);
		}

		//$pp = $pp[0];
		$naissance =  intval($pp->getDateDeNaissance()->get()->format('Y'));
		$retraite = $pp->getDepartRetraite()->get();

		//var_dump(intval($pp->getCategorieProfessionnelle()->get()['code_1']));
		//var_dump($naissance);
		//var_dump($retraite);

		if (
			intval($pp->getCategorieProfessionnelle()->get()['code_1']) != 7 &&
			($retraite - $naissance) < 52
		)
		{
			$store->setDispatch("set_incoherence", [
				"config" => [
					"havePrecision" => true,
					"haveModify" => false,
					"haveClose" => true,
				],
				"coherence_nbr" => 6,
				"button" => [
					"modif" => [
						"text" => '',
						"mutation" => 'modal_stack_pop'
					]
				],
				"html" => "
					<p>
						Vous avez indiqué que votre âge prévisionnel de départ à la retraite est inférieur à 52 ans
					</p>
				",
				"html2" => "
					<p>
						Que souhaitez-vous modifier ?
					</p>
				",
				//"title" => "titre 1"
			]);
			return (false);
		}
		else if (
			intval($pp->getCategorieProfessionnelle()->get()['code_1']) != 7 &&
			($retraite - $naissance) > 62
		)
		{
			$store->setDispatch("set_incoherence", [
				"config" => [
					"havePrecision" => true,
					"haveModify" => false,
					"haveClose" => true,
				],
				"coherence_nbr" => 6,
				"button" => [
					"modif" => [
						"text" => '',
						"mutation" => 'modal_stack_pop'
					]
				],
				"html" => "
					<p>
						Vous avez indiqué que votre âge prévisionnel de départ à la retraite est supérieur à 62 ans
					</p>
				",
				"html2" => "
					<p>
						Que souhaitez-vous modifier ?
					</p>
				",
				//"title" => "titre 1"
			]);
			return (false);
		}
		return (1);
	}

	public static function checkCoherence7(&$instances, &$store, $datas = null) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];
		if (self::checkCoherenceCommun($instances, $store, $datas, 7)) {
			return (1);
		}

		if (
			$situation->getRevenuSalaire()->get() == 0 &&
			$situation->getRevenuImmobilliers()->get() == 0 &&
			$situation->getRevenuMobilliers()->get() == 0 &&
			$situation->getRevenuAutres()->get() == 0
		)
		{
			$store->setDispatch("set_incoherence", [
				"config" => [
					"havePrecision" => true,
					"haveModify" => false,
					"haveClose" => true,
				],
				"coherence_nbr" => 7,
				"button" => [
					"modif" => [
						"text" => '',
						"mutation" => 'modal_stack_pop'
					]
				],
				"html" => "
					<p>
						Vous avez indiqué ne pas avoir de revenus
					</p>
				",
				"html2" => "
					<p>
						Que souhaitez-vous modifier ?
					</p>
				",
				//"title" => "titre 1"
			]);
			return (false);
		}
		return (1);
	}

	public static function checkCoherence8(&$instances, &$store, $datas = null) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];
		if (self::checkCoherenceCommun($instances, $store, $datas, 8)) {
			return (1);
		}

		if (
			$situation->getRevenuImmobilliers()->get() != 0 &&
			$situation->getPatrimoineImmobilierLocatif()->get() == 0 &&
			$situation->getPatrimoineScpi()->get() == 0
		)
		{
			$store->setDispatch("set_incoherence", [
				"config" => [
					"havePrecision" => true,
					"haveModify" => true,
					"haveClose" => false,
				],
				"coherence_nbr" => 8,
				"button" => [
					"revenus" => [
						"text" => "MES REVENUS",
						"action" => 'set_block',
						"payload" => [
							"component" => "component-projet-financiererevenus-noname"
						]
					],
					"patrimoine" => [
						"text" => 'MON PATRIMOINE',
						"mutation" => 'modal_stack_pop'
					],
				],
				"html" => "
					<p>
						Vous avez indiqué avoir des revenus immobiliers alors que nous n’avez pas d’immobilier locatif
					</p>
				",
				"html2" => "
					<p>
						Que souhaitez-vous modifier ?
					</p>
				",
			]);
			return (false);
		}
		return (1);
	}

	public static function checkCoherence9(&$instances, &$store, $datas = null) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];
		if (self::checkCoherenceCommun($instances, $store, $datas, 9)) {
			return (1);
		}

		if (
			$situation->getRevenuMobilliers()->get() != 0 &&
			$situation->getPatrimoineAssuranceVie()->get() == 0 &&
			$situation->getPatrimoinePeaCompteTitre()->get() == 0
		)
		{
			$store->setDispatch("set_incoherence", [
				"config" => [
					"havePrecision" => true,
					"haveModify" => true,
					"haveClose" => false,
				],
				"coherence_nbr" => 9,
				"button" => [
					"revenus" => [
						"text" => "MES REVENUS",
						"action" => 'set_block',
						"payload" => [
							"component" => "component-projet-financiererevenus-noname"
						]
					],
					"patrimoine" => [
						"text" => 'MON PATRIMOINE',
						"mutation" => 'modal_stack_pop'
					],
				],
				"html" => "
					<p>
						Vous avez indiqué avoir des revenus mobiliers alors que nous n’avez pas d’actif financier
					</p>
				",
				"html2" => "
					<p>
						Que souhaitez-vous modifier ?
					</p>
				",
			]);
			return (false);
		}
		return (1);
	}
	public static function checkCoherence10(&$instances, &$store, $datas = null) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];
		if (self::checkCoherenceCommun($instances, $store, $datas, 10)) {
			return (1);
		}

		if (
			$situation->getHabitation()->get() == 1 &&
			$situation->getCreditImmobilierLocatif()->get() != 0
		)
		{
			$store->setDispatch("set_incoherence", [
				"config" => [
					"havePrecision" => true,
					"haveModify" => false,
					"haveClose" => true,
				],
				"coherence_nbr" => 10,
				"button" => [
					"modif" => [
						"text" => '',
						"mutation" => 'modal_stack_pop'
					]
				],
				"html" => "
					<p>
						Vous avez indiqué avoir un loyer à payer alors que vous êtes propriétaire de votre résidence principale
					</p>
				",
				"html2" => "
					<p>
						Que souhaitez-vous modifier ?
					</p>
				",
				//"title" => "titre 1"
			]);
			return (false);
		}
		return (1);
	}
	public static function checkCoherence11(&$instances, &$store, $datas = null) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];
		if (self::checkCoherenceCommun($instances, $store, $datas, 11)) {
			return (1);
		}
		if (
			$projet->getObjectifs()->have(7) &&
			(
				$situation->getAssujettiImpotRevenu()->get() != true ||
				$situation->getTrancheMarginaleImposition()->get() == 1
			)
		)
		{
			$store->setDispatch("set_incoherence", [
				"config" => [
					"havePrecision" => true,
					"haveModify" => true,
					"haveClose" => false,
				],
				"coherence_nbr" => 11,
				"button" => [
					"objectifs" => [
						"text" => 'MES OBJECTIFS',
						"action" => 'set_block',
						"payload" => [
							"component" => "component-projet-choixobjectif-noname"
						]
					],
					"enfants" => [
						"text" => "MA DÉCLARATION D'IMPOSITION",
						"mutation" => 'modal_stack_pop'
					]
				],
				"html" => "
					<p>
						Au regard de votre tranche marginale d’imposition et votre objectif de défiscalisation, nous vous informons de l’incohérence entre votre situation fiscale et votre objectif d’investissement
					</p>
				",
				"html2" => "
					<p>
						Que souhaitez-vous modifier ?
					</p>
				",
				//"title" => "titre 1"
			]);
			return (false);
		}
		return (1);
	}

	public static function checkCoherence12(&$instances, &$store, $datas = null) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];
		if (self::checkCoherenceCommun($instances, $store, $datas, 12)) {
			return (1);
		}
		if (
			$situation->getTotalPatrimoine() >= 1300000 &&
			$situation->getImpotFortune()->get() != true
		)
		{
			$store->setDispatch("set_incoherence", [
				"config" => [
					"havePrecision" => true,
					"haveModify" => true,
					"haveClose" => false,
				],
				"coherence_nbr" => 12,
				"button" => [
					"isf" => [
						"text" => 'MA DÉCLARATION ISF',
						"action" => 'set_block',
						"payload" => [
							"component" => "component-projet-fiscaleisf-noname"
						]
					],
					"enfants" => [
						"text" => "MA DÉCLARATION D'IMPOSITION",
						"mutation" => 'modal_stack_pop'
					]
				],
				"html" => "
					<p>
						Vous avez indiqué avoir patrimoine immobilier avec une valeur supérieure à 1,3 millions alors que vous n’êtes pas assujetti à l’impôt sur la fortune immobilière
					</p>
				",
				"html2" => "
					<p>
						Que souhaitez-vous modifier ?
					</p>
				",
				//"title" => "titre 1"
			]);
			return (false);
		}
		return (1);
	}

	public static function checkCoherence13(&$instances, &$store, $datas = null) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];
		if (self::checkCoherenceCommun($instances, $store, $datas, 13)) {
			return (1);
		}

		if (
			$situation->getRemboursementMensuel()->get() != 0 &&
			$situation->getPatrimoineResidencePrincipale()->get() == 0
		)
		{
			$store->setDispatch("set_incoherence", [
				"config" => [
					"havePrecision" => true,
					"haveModify" => true,
					"haveClose" => false,
				],
				"coherence_nbr" => 13,
				"button" => [
					"charges" => [
						"text" => "MES CHARGES",
						"action" => 'set_block',
						"payload" => [
							"component" => "component-projet-financierecharges-noname"
						]
					],
					"patrimoine" => [
						"text" => 'MON PATRIMOINE',
						"mutation" => 'modal_stack_pop'
					],
				],
				"html" => "
					<p>
						Vous avez indiqué avoir des échéances de crédit à rembourser pour votre résidence principale alors que vous n’êtes propriétaire de votre résidence principale
					</p>
				",
				"html2" => "
					<p>
						Que souhaitez-vous modifier ?
					</p>
				",
			]);
			return (false);
		}
		return (1);
	}

	public static function checkCoherence14(&$instances, &$store, $datas = null) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];
		if (self::checkCoherenceCommun($instances, $store, $datas, 14)) {
			return (1);
		}

		if (
			$situation->getCreditResidenceSecondaire()->get() != 0 &&
			$situation->getPatrimoineResidenceSecondaire()->get() == 0
		)
		{
			$store->setDispatch("set_incoherence", [
				"config" => [
					"havePrecision" => true,
					"haveModify" => true,
					"haveClose" => false,
				],
				"coherence_nbr" => 14,
				"button" => [
					"charges" => [
						"text" => "MES CHARGES",
						"action" => 'set_block',
						"payload" => [
							"component" => "component-projet-financierecharges-noname"
						]
					],
					"patrimoine" => [
						"text" => 'MON PATRIMOINE',
						"mutation" => 'modal_stack_pop'
					],
				],
				"html" => "
					<p>
						Vous avez indiqué avoir des échéances de crédit à rembourser pour votre résidence secondaire alors que vous n’êtes propriétaire d’une résidence secondaire
					</p>
				",
				"html2" => "
					<p>
						Que souhaitez-vous modifier ?
					</p>
				",
			]);
			return (false);
		}
		return (1);
	}

	public static function checkCoherence15(&$instances, &$store, $datas = null) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];
		if (self::checkCoherenceCommun($instances, $store, $datas, 15)) {
			return (1);
		}

		if (
			$situation->getCreditImmobilierLocatif()->get() != 0 &&
			$situation->getPatrimoineImmobilierLocatif()->get() == 0
		)
		{
			$store->setDispatch("set_incoherence", [
				"config" => [
					"havePrecision" => true,
					"haveModify" => true,
					"haveClose" => false,
				],
				"coherence_nbr" => 15,
				"button" => [
					"charges" => [
						"text" => "MES CHARGES",
						"action" => 'set_block',
						"payload" => [
							"component" => "component-projet-financierecharges-noname"
						]
					],
					"patrimoine" => [
						"text" => 'MON PATRIMOINE',
						"mutation" => 'modal_stack_pop'
					],
				],
				"html" => "
					<p>
						Vous avez indiqué avoir des échéances de crédit à rembourser pour votre immobilier locatif alors que vous n’êtes propriétaire d’immobilier locatif
					</p>
				",
				"html2" => "
					<p>
						Que souhaitez-vous modifier ?
					</p>
				",
			]);
			return (false);
		}
		return (1);
	}

	public static function checkCoherence16(&$instances, &$store, $datas = null) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];
		if (self::checkCoherenceCommun($instances, $store, $datas, 16)) {
			return (1);
		}

		$residence = $situation->getPaysResidenceFiscale()->get();
		$pays = Pays2::getFromKeyValue('nom_fr_fr', $residence);
		if (empty($pays)) {
			$store->setDispatch("modal_message_box", [
				"content" => "Désolé, une erreur est survenue !"
			]);
			$store->error();
		}

		if (
			$pays[0]->getGafi()->get() ||
			$pays[0]->getMoscovici()->get() ||
			$pays[0]->getNonCoop()->get()
		)
		{
			$store->setDispatch("modal_message_box", [
				"content" => "Désolé, nous sommes dans l’incapacité de vous accompagner au regard de votre pays de résidence"
			]);
			return (false);
		}
		return (1);
	}

	public static function checkCoherence18(&$instances, &$store, $datas = null) {
		$projet = $instances['projet'];
		if (!isset($instances['situation']))
		{
			$instances['situation'] = $projet->getSituationPhysique()->get();
			if ($instances['situation'])
				$instances['situation']->removeCheck();
		}
		$situation = $instances['situation'];
		if (self::checkCoherenceCommun($instances, $store, $datas, 18)) {
			return (1);
		}

		$residence = $situation->getPaysResidenceFiscale()->get();
		$pays = Pays2::getFromKeyValue('nom_fr_fr', $residence);
		if (empty($pays)) {
			$store->setDispatch("modal_message_box", [
				"content" => "Désolé, une erreur est survenue !"
			]);
			$store->error();
		}

		if (
			$pays[0]->getGafi()->get() ||
			$pays[0]->getMoscovici()->get() ||
			$pays[0]->getNonCoop()->get()
		)
		{
			$store->setDispatch("modal_message_box", [
				"content" => "Désolé, nous sommes dans l’incapacité de vous accompagner au regard de votre pays de résidence"
			]);
			return (false);
		}
		return (1);
	}
}
