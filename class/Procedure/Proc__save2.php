<?php
class ProcedureCreationProjet extends Procedure {

	// À chaque étape il doit être définit une méthode.
	protected static $_steps = [
			// A1
			[
				'name' =>"ProjetChoixBeneficiaire",
				'page' => 'CreationProjet',
				'isBack' => false
			],
			// A2
			[
				'name' =>"ProjetChoixObjectif",
				'page' => 'CreationProjet',
				'isBack' => false
			],
			// A3
			[
				'name' =>"ProjetMontant",
				'page' => 'CreationProjet',
				'isBack' => false
			],
			/*
			[
				'name' =>"ProjetCredit",
				'page' => 'CreationProjet'
			],
			*/
			// A4
			[
				'name' =>"ProjetOrigineFonds",
				'page' => 'CreationProjet',
				'isBack' => false
			],
//////////////////////////////////////////////////////////////////////////
			// A5
			[
				'name' =>"ProjetAccompagnementInvestissement",
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
				'page' => 'SituationJuridique',
				'isBack' => false
			],

			[
				'name' =>"Coherence6",
				'page' => 'SituationJuridique',
				'isBack' => true
			],

			// B3
			[
				'name' =>"JuridiquePersonnePhysique2",
				'page' => 'SituationJuridique',
				'isBack' => false,
				'notBack' => true
			],

//////////////////////////////////////////////////////////////////////////
			// C1
			[
				'name' =>"FinanciereRevenus",
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
				'name' =>"FinanciereCharges",
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
				'page' => 'SituationFiscale',
				'isBack' => false
			],

			[
				'name' =>"Coherence16",
				'page' => 'SituationFiscale',
				'isBack' => true
			],

			// D2
			[
				'name' =>"FiscaleImpot",
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
				'page' => 'SituationFiscale',
				'isBack' => false
			],

//////////////////////////////////////////////////////////////////////////
			// E1
			[
				'name' =>"PatrimoineSituation",
				'page' => 'SituationPatrimoniale',
				'isBack' => false
			],
			// E2
			[
				'name' =>"PatrimoineRepartition",
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
				'page' => 'ProfilInvestisseur',
				'isBack' => false
			],

			[
				'name' =>"ProfilInvestisseurCompetences",
				'page' => 'ProfilInvestisseur',
				'isBack' => false
			],

			[
				'name' =>"ProfilInvestisseurMarcheImmobiliers",
				'page' => 'ProfilInvestisseur',
				'isBack' => false
			],

			[
				'name' =>"ProfilInvestisseurSupportPlacement",
				'page' => 'ProfilInvestisseur',
				'isBack' => false
			],

			[
				'name' =>"ProfilInvestisseurPlacementDetenus",
				'page' => 'ProfilInvestisseur',
				'isBack' => false
			],

			[
				'name' =>"ProfilInvestisseurModeGestion",
				'page' => 'ProfilInvestisseur',
				'isBack' => false
			],

			[
				'name' =>"ProfilInvestisseurConnaissance",
				'page' => 'ProfilInvestisseur',
				'isBack' => false
			],

			[
				'name' =>"ProfilInvestisseurQuizScpi",
				'page' => 'ProfilInvestisseur',
				'isBack' => false
			],

			[
				'name' =>"ProfilInvestisseurEnd",
				'page' => 'ProfilInvestisseur',
				'isBack' =>true 
			],

//////////////////////////////////////////////////////////////////////////
			[
				'name' =>"Fin",
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
		foreach (self::$_steps as $key => $currentStatut)
		{
			if ($currentStatut['name'] == ("Coherence" . $nbr_incoherence))
			{
				//$instances['projet']->getStatutParcourClient()->set($currentStatut['name']);
				//$instances['projet']->commit();
				//$store->setSelected($instances['projet']);
				$nm = "Coherence" . $nbr_incoherence;
				$count = self::{"check" . $nm}($instances, $store, $datas, $dh);
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
				if ($currentStatut['isBack'] == false)
				{
					$instances['projet']->getStatutParcourClient()->set($currentStatut['name']);
					$instances['projet']->commit();
					$store->addToState($instances['projet']);
					$store->setSelected($instances['projet']);
				}
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
		foreach (self::$_steps as $key => $currentStatut)
		{
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
				$count = self::{"set" . $name}($instances, $store, $datas, $dh, "next");
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
		foreach (self::$_steps as $key => $currentStatut)
		{
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
						{
							$store->error();
						}
						$count += $rt;
					}
					$instances['projet']->getStatutParcourClient()->set(self::$_steps[$key + $count]['name']);
				}
				
				$instances['projet']->commit();
				$store->addToState($instances['projet']);
				$store->setSelected($instances['projet']);
				$store->success();
			}
			else if ( $datas['projet']['statut_parcour_client']['value'] == $currentStatut['name'] )
			{
				$instances['projet']->getStatutParcourClient()->set(self::$_steps[$key]['name']);
				$instances['projet']->commit();
				$store->addToState($instances['projet']);
				$store->setSelected($instances['projet']);
				$store->success();
			}
			else
			{
				$rt = self::{"check" . $currentStatut['name']}($instances, $store);
				if ($currentStatut['isBack'] == false)
					$instances['projet']->getStatutParcourClient()->set($currentStatut['name']);
				if (!$rt)
				{
					$instances['projet']->commit();
					$store->addToState($instances['projet']);
					$store->setSelected($instances['projet']);
					$store->error();
				}
			}
		}
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
		if ($bf == null)
		{
			$bf = new Beneficiaire2();
			$bf->getTypeBeneficiaire()->set('seul');
			$bf->getDonneurDOrdre()->set($dh);
			$bf->getPersonnesPhysiques()->set($pp);
			$bf->getTypeRelation()->set('DonneurDOrdre');
			$store->setSelected($bf);
			if ($bf->commit() == false)
				return (false);
			$store->addToState($bf);
			$store->addToState($pp->cloneFromDb());
		}

		if (isset($form['beneficiaire']) && intval($form['beneficiaire']['id']['value']) > 0)
		//if (isset($form['beneficiaire']))
		{
			//var_dump($form['beneficiaire']);
			//error('df');
			$bf = Beneficiaire2::getById(intval($form['beneficiaire']['id']['value']));
		}
		else if ($selectedBox === 0)  { // Moi seul
			// On récupère sa personne physique
			// On a rien `faire ici
		}
		else if ($selectedBox === 11)  { // Mon Couple et moi même
			$bf = null;
			if ($form['PersonnePhysique']['id']['value'] != 0)
			{
				$pp2 = PersonnePhysique::getById($form['PersonnePhysique']['id']['value']);
				$pp2->removeCheck();
				$pp2->getCivilite()->setConfig("notCheck", false);
				$pp2->getNom()->setConfig("notCheck", false);
				$pp2->getPrenom()->setConfig("notCheck", false);
			}
			else
			{
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

			$bfs = $pp2->getBeneficiaires()->get();
			foreach ($bfs as $key => $elm) {
				if ($elm->getTypeBeneficiaire()->get() == 'seul')
					$bf = $elm;
			}
			if ($bf == null)
			{
				$bf = new Beneficiaire2();
				$bf->getTypeBeneficiaire()->set('seul');
				$bf->getTypeRelation()->set('conjoint');
				$bf->getDonneurDOrdre()->set($dh);
				$bf->getPersonnesPhysiques()->set($pp2);
				$store->setSelected($bf);
				if ($bf->commit() == false)
					return (false);
				$store->addToState($bf);
				$store->addToState($pp2->cloneFromDb());
			}

			$bf = null;
			// On récupère sa personne physique
			$bfs = $pp->getBeneficiaires()->get();
			foreach ($bfs as $key => $elm) {
				if ($elm->getTypeBeneficiaire()->get() == 'couple')
					$bf = $elm;
			}
			if ($bf == null)
			{
				$bf = new Beneficiaire2();
				$bf->getTypeBeneficiaire()->set('couple');
				$bf->getTypeRelation()->set('couple');
				$bf->getDonneurDOrdre()->set($dh);
				$bf->getPersonnesPhysiques()->set($pp);
				$bf->getPersonnesPhysiques()->set($pp2);
				$store->setSelected($bf);
				if ($bf->commit() == false)
					return (false);
				$store->addToState($bf);
				$store->addToState($pp->cloneFromDb());
				$store->addToState($pp2->cloneFromDb());
			}
		}
		else if ($selectedBox === 12)  { // Mon Conjoin
			$bf = null;

			// TODO Vérifier que le ppDh n'a pas déjà un beneficiaire couple

			$ppDh = $dh->getMyPersonnePhysique()->get();
			$benDh = $ppDh->getBeneficiaires()->get();
			$dhHaveCouple = false;
			$dhHaveSeul = false;
			$conjoinHaveSeul = false;
			$pp2 = null;
			foreach ($benDh as $key => $elm) {
				if ($elm->getTypeBeneficiaire()->get() == "couple")
				{
					$dhHaveCouple = true;
					foreach ($elm->getPersonnesPhysiques() as $key2 => $elm2) {
						if ($elm2->getId() != $dh->lien_phy)
							$pp2 = $elm2;
					}
				}
				else if ($elm->getTypeBeneficiaire()->get() == "seul")
					$dhHaveSeul = true;
			}

			if (!$dhHaveCouple)
			{
				// Création d'une personne physique si besoins ou alors récupération.
				if ($form['PersonnePhysique']['id']['value'] != 0)
				{
					$pp2 = PersonnePhysique::getById(intval($form['PersonnePhysique']['id']['value']));

					$pp2->removeCheck();
					$pp2->getCivilite()->setConfig("notCheck", false);
					$pp2->getNom()->setConfig("notCheck", false);
					$pp2->getPrenom()->setConfig("notCheck", false);

				}
				else
				{
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
				foreach ($bfs as $key => $elm) {
					if ($elm->getTypeBeneficiaire()->get() == 'couple')
						$bf = $elm;
				}
				if ($bf == null)
				{
					$bf = new Beneficiaire2();
					$bf->getTypeBeneficiaire()->set('couple');
					$bf->getTypeRelation()->set('couple');
					$bf->getDonneurDOrdre()->set($dh);
					$bf->getPersonnesPhysiques()->set($pp);
					$bf->getPersonnesPhysiques()->set($pp2);
					$store->setSelected($bf);
					//echo "beforeCommit\n";
					if ($bf->commit() == false)
						return (false);
					$store->addToState($bf);
					$store->addToState($pp->cloneFromDb());
					$store->addToState($pp2->cloneFromDb());
				}
			}

			var_dump($pp2);
			exit();
			if (!$dhHaveSeul)
			{
				$bf = null;
				$bfs = $pp2->getBeneficiaires()->get();
				foreach ($bfs as $key => $elm) {
					if ($elm->getTypeBeneficiaire()->get() == 'seul')
						$bf = $elm;
				}
				if ($bf == null)
				{
					$bf = new Beneficiaire2();
					$bf->getTypeBeneficiaire()->set('seul');
					$bf->getTypeRelation()->set('conjoint');
					$bf->getDonneurDOrdre()->set($dh);
					$bf->getPersonnesPhysiques()->set($pp2);
					$store->setSelected($bf);
					if ($bf->commit() == false)
						return (false);
					$store->addToState($bf);
					$store->addToState($pp2->cloneFromDb());
				}
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

		$projet->getBeneficiaire()->set($bf);
		$projet->getConseiller()->set($dh->getConseiller()->get());

		if ($projet->commit() == false)
			return (false);
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
		$rt = $projet->setForGraphApi($form, [
			'objectifs',
			'objectif_autre'
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

/*
	public static function setProjetCredit(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		$projet->getCredit()->setConfig("notCheck", false);
		$rt = $projet->setForGraphApi($form);
		if ($rt !== true)
		{
			$store->setSelected($rt, "Projet2");
			return (false);
		}
		return (true);
	}

	public static function checkProjetCredit($instances) {
		$projet = $instances['projet'];
		return (true);
	}
*/
///////////////////////////////////////////

	public static function setProjetAccompagnementInvestissement(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (isset($datas['formulaire']))
			$form = $datas['formulaire'];
		else
			$form = [];
		$projet->getAccompagneInvestissement()->setConfig("notCheck", false);
		$rt = $projet->setForGraphApi($form, ['accompagne_investissement']);
		if ($rt !== true)
		{
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

	public static function setProjetOrigineFonds(&$instances, &$store, $datas, $dh, $action) {
		$projet = $instances['projet'];
		if (isset($datas['formulaire']))
			$form = $datas['formulaire'];
		else
			$form = [];
		$projet->getOrigine()->setConfig("notCheck", false);
		$rt = $projet->setForGraphApi($form, ["origine"]);
		if ($rt !== true)
		{
			$store->setSelected($rt, "Projet2");
			return (false);
		}
		$origine = $projet->getOrigine()->get();
		if ($action == "next" &&
			$origine['Crédit']['enabled'] == false
		) {
			
			return (2);
			$projet->commit();
			$store->addToState($projet);
			$store->setSelected($projet);
			$store->success();
		}
		return (1);
	}

	public static function checkProjetOrigineFonds($instances) {
		$projet = $instances['projet'];
		$origine = $projet->getOrigine()->get();
		if ( $origine['Crédit']['enabled'] == false)
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
		
		// Je pense que ce truc ne sert à rien !
		/*
		if (!empty($projet->getSituationPhysique()->get())) {
			$projet->getSituationPhysique()->set(null);
		}
		*/

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
		$situation->getEnfantsACharge()->setConfig("notCheck", false);
		$situation->getAutrePersonneCharge()->setConfig("notCheck", false);
		if (isset($datas['formulaire']['value']) && $datas['formulaire']['value'] === false)
			$sit['autre_personne_charge']['value'] = 0;
		$rt = $situation->setForGraphApi($sit, [
			"etat_civil",
			"regime_matrimonial",
			"a_des_enfants",
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
		$pp->getUsPersonne()->setConfig("notCheck", false);
		$pp->getPolitiquementExpose()->setConfig("notCheck", false);
		$pp->getCategorieProfessionnelle()->setConfig("notCheck", false);
		$pp->getDepartRetraite()->setConfig("notCheck", false);
		$pp->getElementParticulier()->setConfig("notCheck", false);
		$pp->getCodeNaf()->setConfig("notCheck", false);

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
			"us_person",
			"politiquement_expose",
			"categorie_professionelle",
			"depart_retraite",
			"element_particulier",
			"code_naf"
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
		if (0)
			return (1);
		return (1);
	}

	public static function checkJuridiquePersonnePhysique1($instances) {
		return (1);
	}

///////////////////////////////////////////

	public static function setJuridiquePersonnePhysique2(&$instances, &$store, $datas, $dh, $action) {
		// TODO Faire le code qui insère une seconde personne physique.
		return (1);
	}

	public static function checkJuridiquePersonnePhysique2($instances) {
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
		$situation->getHabitation()->setConfig("notCheck", false);
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
			'habitation',
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

		$form = $datas['formulaire'];
		$rt = $situation->setForGraphApi($form, [
			'assujetti_impot_revenu',
			'impot_annee_precedente',
			'tranche_marginale_imposition',
			'nombre_parts_fiscales',
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
					/*
					$name = $pp->getShortName();
					$store->setDispatch("modal_message_box", [
						"content" => "On a trouvé un profil complet pour $name"
					]);
					*/
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
			/*
			$store->setDispatch("modal_message_box", [
				"content" => "Toutes les personnes physiques de ce projet ont profil d'investisseur valide => on passe à la suite"
			]);
			*/
			return (10);
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
				return (false);
			}
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
		$profil->getCompetencesFinancieres()->setConfig("notCheck", false);
		$form = $datas['formulaire'];
		$rt = $profil->setForGraphApi($form, [
			'competences_imobilieres',
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
	public static function checkProfilInvestisseurCompetences($instances) {
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
		$rt = $profil->setForGraphApi($form, [
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
	public static function checkProfilInvestisseurPlacementDetenus($instances) {
		return (1);
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

	public static function setProfilInvestisseurQuizScpi(&$instances, &$store, $datas, $dh, $action) {
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
		$store->setDispatch("modal_message_box", [
			"content" => "Ce profil investisseur est complet, maintenant il faut encore voir si il y en a d'autres !"
		]);
*/
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
					/*
					$name = $pp->getShortName();
					$store->setDispatch("modal_message_box", [
						"content" => "On a trouvé un profil complet pour $name"
					]);*/
					break;
				}
			}
			if (!$temoin2) {
				return (-9);
			}
		}
		return (1);
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
			$projet->getOrigine()->get()['Crédit']['enabled'] == true &&
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
							"component" => "component-projet-originefonds-noname"
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
			$projet->getOrigine()->get()['Épargne']['enabled'] == true &&
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
							"component" => "component-projet-originefonds-noname"
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
			$projet->getOrigine()->get()["Cessions d’actifs mobiliers"]['enabled'] == true &&
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
							"component" => "component-projet-originefonds-noname"
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
			$projet->getOrigine()->get()["Cession d’actifs immobiliers"]['enabled'] == true &&
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
							"component" => "component-projet-originefonds-noname"
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

		$pp = $situation->getPersonnesPhysiques()->get();
		if (empty($pp))
		{
			$store->setDispatch("modal_message_box", [
				"content" => "Il y a un probleme, La situation n'est liée à aucune personne physique !"
			]);
		}
		if (self::checkCoherenceCommun($instances, $store, $datas, 6)) {
			// TODO Checker si une deuxieme personne Physique
			return (2);
		}

		$pp = $pp[0];
		$naissance =  intval($pp->getDateDeNaissance()->get()->format('Y'));
		$retraite = $pp->getDepartRetraite()->get();
		if (($retraite - $naissance) < 52)
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
		else if (($retraite - $naissance) > 67)
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
						Vous avez indiqué que votre âge prévisionnel de départ à la retraite est supérieur à 67 ans
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
		// TODO Vérifier si il y a une deuxieme personne physique !
		return (2);
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
}
