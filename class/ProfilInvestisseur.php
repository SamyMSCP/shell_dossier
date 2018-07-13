<?php
require_once("core/Database.php");
require_once("core/Table.php");
require_once("core/DocumentTrait.php");
require_once("Dh.php");

class ProfilInvestisseur extends Table
{
	/*
	id
	id_Pp
	date_creation
	niveau_risque
	competences_imobilieres
	competences_financieres
	connaissance_marche_imbobilier
	connaissance_scpi
	resultat_questionnaire
	connaissance_placement_actions
	connaissance_placement_scpi
	connaissance_placement_assurance_vie
	connaissance_placement_opci
	connaissance_placement_obligations
	connaissance_placement_fcpi_fip_fcpr
	connaissance_placement_opcvm
	quiz
	*/
	protected static		$_name = "PROFIL INVESTISSEUR";
	protected static		$_primary_key = "id";

	public static $_typeProfil = array(
		0 => array(
			"color" => "rgb(120, 165, 191)",
			"min" => 0,
			"max" => 5,
			"needCheck" => true,
			"niveau" => "CONNAISSANCE INEXISTANTE",
			"profil" => "PROFIL PRUDENT OU SÉCURITAIRE",
			"description" => "Vous êtes un investisseur novice et vous avez une expérience très reduite des investissements.Vous souhaitez protéger votre capital en favorisant la sécurité de vos placements au détriment du potentiel de rendement."
		),
		1 => array(
			"color" => "rgb(90, 145, 177)",
			"min" => 5,
			"max" => 10,
			"needCheck" => true,
			"niveau" => "DÉBUTANT",
			"profil" => "PROFIL MODÉRÉ",
			"description" => "Vous êtes un investisseur débutant et vous avez une expérience reduite des investissements.Vous souhaitez favoriser la sécurité de vos placements tout en autorisant un certain niveau de risque pour augmenter légèrement votre rendement potentiel."
		),
		2 => array(
			"color" => "rgb(61, 124, 163)",
			"min" => 10,
			"max" => 15,
			"needCheck" => false,
			"niveau" => "CONNAISANCE INTERMÉDIAIRE",
			"profil" => "PROFIL EQUILIBRÉ",
			"description" => "Vous avez une expérience intermédiaire des investissement. Vous cherchez un juste équilibre entre des investissements bénéficiant d'un bon potentiel de rendement et des placements tolérant de maintenir le risque de votre portefeuille à un niveau modéré."
		),
		3 => array(
			"color" => "rgb(31, 104, 149)",
			"min" => 15,
			"max" => 19,
			"needCheck" => false,
			"niveau" => "CONNAISSANCE CONFIRMÉ",
			"profil" => "PROFIL DYNAMIQUE",
			"description" => "Vous êtes un investisseur avisé et êtes relativement expérimenté. Vous souhaitez vous procurer un potentiel de rendement élevé sur vos placements tout en abaissant en partie les variabilités des marchés."
		),
		4 => array(
			"color" => "rgb(2, 84, 135)",
			"min" => 19,
			"max" => 20.1,
			"needCheck" => false,
			"niveau" => "CONNAISSANCE ÉLEVÉE",
			"profil" => "PROFIL OFFENSIF",
			"description" => "Vous êtes un investisseur très avisé et êtes un investisseur très expérimenté. Vous souhaitez améliorer le potentiel de rendement sur vos placements en autorisant pour cela des fluctuations importantes sur les valeurs de vos placements."
		)
	);

	public static $_listReponses = array(
		0 => "Oui",
		1 => "Non",
		2 => "Ne sais pas"
	);

	public static $_listPicto = array(
		0 => '<i class="fa fa-thumbs-up" aria-hidden="true"></i>',
		1 => '<i class="fa fa-thumbs-down" aria-hidden="true"></i>',
		2 => '<i class="fa fa-ban" aria-hidden="true"></i>'
	);
	
	public static		$_correction480 = "Si vous investissez, 10 000 € dans une SCPI qui a un TDVM de 4,8%, vos revenus seront en moyenne de 480 €. Le TDVM (Taux de Distribution sur Valeur de Marché) : c’est le rapport entre le dividende versé au titre de l’année n (en pleine jouissance) et le prix moyen de la part au titre de l’année n.";

	public static		$_listQuestions = array(
			0 => array(
				"title" => "Connaissez-vous les modalités de passage des ordres en part de SCPI ?",
				"correction" => 
					"Il existe deux formes de SCPI :<br />
					- Les SCPI à capital fixe : un capital plafond est inscrit dans les statuts. La société de gestion augmente progressivement le capital de la SCPI jusqu’à atteindre ce capital plafond. Entre chaque augmentation, le capital reste fixe. On peut donc souscrire :<br />
					<ul>
						<li>
							sur le marché primaire lors d’augmentation de capital et de l’émission de nouvelles parts; (le prix est déterminé par la société de gestion) vous souscrivez avec un bulletin de souscription
						</li>
						<li>
							sur le marché secondaire, ce marché est organisé et permet de déterminer le prix de vente. (le prix est déterminé selon l'offre et la demande) vous souscrivez avec un mandat d'achat de parts
						</li>
					</ul>
					<br />
					Les SCPI à capital variable : il n’y a pas de marché secondaire ce qui permet (sauf cas exceptionnel) de souscrire de manière permanente. Le prix de souscription est alors défini par la société de gestion vous souscrivez avec un bulletin de souscription",
				"online" => true,
				"response" => array(
					0 => 1,		// Oui
					1 => 0		// Non
				)
			),
			1 => array(
				"title" => "Connaissez-vous les risques liés aux investissements en parts de SCPI ?",
				"correction" =>
					"La SCPI en tant qu’investissement immobilier peut présenter certains risques : perte de valeur et/ou absence de rendement. Cependant la répartition géographique (région parisienne, Province) et la diversification dans la typologie d’immobilier (bureaux, commerces, activités...) permet de limiter et d’atténuer ces risques. <br />
					La défaillance de la société de gestion qui gère la SCPI. Les sociétés de gestion sont agréées et contrôlées par l’Autorité des Marchés Financiers. Cependant si une société de gestion venait à défaillir, la gestion de la SCPI serait transférée, selon la loi, à une autre société de gestion agréée par l’Autorité des Marchés Financiers..<br />
					Le capital n’est pas garanti <br />
					La responsabilité financière des porteurs est limitée aux apports au capital. <br />
					La revente des parts n’est pas garantie, elle peut donc varier en fonction de l’évolution du marché de l’immobilier et des parts de SCPI. La réglementation du marché secondaire organise la liquidité des parts.",
				"online" => true,
				"response" => array(
					0 => 1,		// Oui
					1 => 0		// Non
				)
			),
			2 => array(
				"title" => "La SCPI est un placement garanti.",
				"correction" => "Le capital de la SCPI n'est pas garanti. Il en est de même pour les dividendes qui peuvent augmenter et dimuner en fonction du contexte du marché immobilier.",
				"online" => true,
				"response" => array(
					0 => 0,		// Oui
					1 => 2,		// Non
					2 => 0		// Ne se prononce pas
				)
			),
			3 => array(
				"title" => "La rentabilité d’un placement en immobilier dépend de la qualité des locataires et de la localisation des actifs.",
				"correction" => "La rentabilité dépend de la qualité de l'emplacement et de la qualité du locataire.",
				"online" => true,
				"response" => array(
					0 => 1,		// Oui
					1 => 0,		// Non
					2 => 0		// Ne se prononce pas
				)
			),
			4 => array(
				"title" => "La société de gestion peut acheter tous les actifs immobiliers qu’elle souhaite sans respecter la politique d’investissement de la SCPI.",
				"correction" => "La société de gestion doit respecter la politique d'investissement précisée dans la note d'informations et les statuts de la SCPI.",
				"online" => true,
				"response" => array(
					0 => 0,		// Oui
					1 => 1,		// Non
					2 => 0		// Ne se prononce pas
				)
			),
			5 => array(
				"title" => "La revente des parts d’une SCPI de rendement est possible.",
				"correction" =>
					"La liquidité des parts se fait selon la forme juridique de la SCPI :<br />
					- Pour les SCPI à capital variable :<br />
					L’associé fait une demande de remboursement de la part à la valeur de retrait (définie par la société de gestion). La demande est acceptée seulement si une contrepartie souhaite souscrire, sinon la société de gestion peut être amenée à créer un fonds de remboursement destiné éventuellement à satisfaire les demandes de retrait. Ce fonds de remboursement peut être constitué à partir de cession d’actifs immobiliers.<br />
					- Pour les SCPI à capital fixe :<br />
					Le marché secondaire est organisé depuis la loi du 9 juillet 2001, des «confrontations» ont lieu tout au long de l’année et un carnet d’ordres recense l’ensemble des ordres d’achat et de vente. Le marché secondaire des parts de SCPI répond ainsi aux lois de l'offre et de la demande. L’acquisition de parts de SCPI à capital fixe sur le marché secondaire est soumise aux droits d’enregistrement.",
				"online" => true,
				"response" => array(
					0 => 1,		// Oui
					1 => 0,		// Non
					2 => 0		// Ne se prononce pas
				)
			),
			6 => array(
				"title" => "La SCPI est un placement investi quasi exclusivement en immobilier.",
				"correction" => "La SCPI est une société civile de placement immobilier. Elle investit quasi exclusivement en immobilier d’entreprise (commerces, bureaux, logistiques, santé, hôtels) pour les SCPI de rendement et en habitations pour le SCPI Fiscales. Je vous joins le guide de la SCPI qui vous permettra d’étoffer vos connaissances en SCPI.",
				"online" => true,
				"response" => array(
					0 => 1,		// Oui
					1 => 0,		// Non
					2 => 0		// Ne se prononce pas
				)
			),
			7 => array(
				"title" => "Le placement en parts de SCPI est un placement à court terme.",
				"correction" => "Le placement en parts de SCPI doit être sur le long terme minimum 8 années pour les SCPI de rendement et 15 ans pour les SCPI Fiscales.",
				"online" => true,
				"response" => array(
					0 => 0,		// Oui
					1 => 1,		// Non
					2 => 0		// Ne se prononce pas
				)
			),
			8 => array(
				"title" => "La liquidité du placement en SCPI fiscale est très limitée.",
				"correction" => "La liquidité du placement est très limitée. L'avantage fiscal, composante importante de la rentabilité du placement ne peut être transmis, les possibilités de revente seront donc très réduites sauf à des prix fortement décotés. La SCPI ne garantit pas la revente des parts.",
				"online" => true,
				"response" => array(
					0 => 1,		// Oui
					1 => 0,		// Non
					2 => 0		// Ne se prononce pas
				)
			),
			9 => array(
				"title" => "L’investissement en SCPI fiscale doit s’envisager sur une période généralement inférieure à 15 ans.",
				"correction" => "Un investissement en parts de SCPI fiscales doit s'envisager sur une période de 15 ans minimum : c'est la durée au terme de laquelle la SCPI sera dissoute, et l'associé récupérera le capital investi.",
				"online" => true,
				"response" => array(
					0 => 0,		// Oui
					1 => 1,		// Non
					2 => 0		// Ne se prononce pas
				)
			),
			10 => array(
				"title" => "L’avantage fiscal d’une SCPI fiscal est transmissible.",
				"correction" => "L'avantage fiscal d’une SCPI fiscale n'est pas transmissible.",
				"online" => true,
				"response" => array(
					0 => 0,		// Oui
					1 => 1,		// Non
					2 => 0		// Ne se prononce pas
				)
			),
			11 => array(
				"title" => "La SCPI est un investissement immobilier. Acceptez-vous d’envisager ce placement sur le long terme (supérieur à 10 ans) pour les SCPI de rendement?",
				"correction" => "Un investissement en SCPI est pour une durée d’investissement long terme minimum 8 années pour les SCPI de rendement et 15 ans généralement pour les SCPI Fiscales. ",
				"online" => true,
				"response" => array(
					0 => 1,		// Oui
					1 => 0		// Non
				)
			),
			12 => array(
				"title" => "Dans le cas d'un investissement immobilier avec une stratégie d'investissement au-delà de la zone euro, le capital et les revenus peuvent varier également en fonction du cours des devises. Acceptez-vous de prendre un risque lié à la variation du cours des devises ?",
				"correction" => "Le versement des dividendes n’est pas garanti et peut évoluer à la hausse comme à la baisse en raison de la variation des marchés immobiliers et cours des devises, des conditions de location des
				immeubles (notamment niveau des loyers, taux de vacance).",
				"online" => true,
				"response" => array(
					0 => 2,		// Oui
					1 => 0,		// Non
					2 => 0		// Ne se prononce pas
				)
			)
		);

	public static function insertNew($id_Pp, $risque, $immo, $finan, $connaissance, $connaissanceScpi, $typePlacementAction, $typePlacementAssuranceVie, $typePlacementObligations, $typePlacementOPCVM, $typePlacementScpi, $typePlacementOPCI, $typePlacementFCPI, $quiz, $score)
	{
		$req = "INSERT INTO `PROFIL INVESTISSEUR` 
			(
				id_Pp,
				date_creation,
				niveau_risque,
				competences_imobilieres,
				competences_financieres,
				connaissance_marche_imbobilier,
				connaissance_scpi,
				connaissance_placement_actions,
				connaissance_placement_assurance_vie,
				connaissance_placement_obligations,
				connaissance_placement_opcvm,
				connaissance_placement_scpi,
				connaissance_placement_opci,
				connaissance_placement_fcpi_fip_fcpr,
				quiz,
				resultat_questionnaire,
				status
			)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)";
		$data = array(
			$id_Pp,
			time(),
			$risque,
			$immo,
			$finan,
			$connaissance,
			$connaissanceScpi,
			$typePlacementAction,
			$typePlacementAssuranceVie,
			$typePlacementObligations,
			$typePlacementOPCVM,
			$typePlacementScpi,
			$typePlacementOPCI,
			$typePlacementFCPI,
			$quiz,
			$score
		);
		return Database::prepareInsertNoSecurity(static::$_db, $req, $data);
	}

	public function scoreTable($id_Pp, $risque, $immo, $finan, $connaissance, $connaissanceScpi, $typePlacementAction, $typePlacementAssuranceVie, $typePlacementObligations, $typePlacementOPCVM, $typePlacementScpi, $typePlacementOPCI, $typePlacementFCPI, $profil) {
		$rt = 0;
		$rt += ($risque - 1);
		$rt += ($immo);
		$rt += ($finan);
		$rt += ($connaissance - 1);
		$rt += ($connaissanceScpi - 1);
		$rt += ($typePlacementAction * 0.5) + ($typePlacementAssuranceVie * 0.5) + ($typePlacementObligations * 0.5) + ($typePlacementOPCVM * 0.5) + $typePlacementScpi + ($typePlacementOPCI * 0.5) + ($typePlacementFCPI * 0.5);
		foreach($profil as $key => $elm)
		{
			$rt += self::$_listQuestions[$key]['response'][$elm];
		}
		return ($rt);
	}
	public function getDateCreation() {
		$rt = new DateTime();
		$rt = $rt->setTimestamp($this->date_creation);
		return ($rt);
	}
	public static function getFromPp($id_Pp) {
		return (parent::getFromKeyValue("id_Pp", $id_Pp));
	}
	public static function getLastFromPp($id_Pp) {
		$req = "SELECT * FROM `" . self::$_name . "` WHERE id_Pp = ? ORDER BY date_creation DESC LIMIT 1";
		$data = array($id_Pp);
		$rt = Database::prepare(static::$_db, $req, $data, 'ProfilInvestisseur');
		if (count($rt))
			return ($rt[0]);
		else
			return (null);
	}
	public function getScore() {
		return ($this->resultat_questionnaire);
	}
	public function getProfil() {
		$rt = null;
		foreach (self::$_typeProfil as $key => $elm)
		{
			if ($this->getScore() < $elm['max'])
				return ($elm);
		}
	}
	public function isValide() {
		return (time() < ($this->getDateCreation()->getTimestamp() + TIME_SITUATION_VALID) && $this->getStatus() >= 2);
		return (true);
	}
	public function getPp() {
		return (Pp::getFromId($this->id_Pp)[0]);
	}
	public function getStatus() {
		return ($this->status);
	}
	public function getForStore() {
		$rt = clone $this;
		$rt->details = $this->getProfil();
		//$rt->profArray = unserialize($this->quiz);
		return ($rt);
	}
	public function getQuizArray() {
		$rt = unserialize($this->quiz);
		return ($rt);
	}
	public function getSiJinvesti() {
		return ($this->si_jinvesti_10000);
	}
	public function getForMail() {
		ob_start();
		include('profilForMail.php');
		$rt = ob_get_contents();
		ob_end_clean();
		return ($rt);
	}
	public function sendByMailToPp() {
		$msg = $this->getForMail();
		$Pp = Pp::getFromId($this->id_Pp)[0];
		$dh = $Pp->getDh();
		$currentDh = Dh::getCurrent();
		if (!empty($currentDh))
			$id_dh = $currentDh->id_dh;
		else
			$id_dh = 0;
		MailSender::sendToPp($Pp, "Récapitulatif profil investisseur", $msg);
		$profil = $this->getProfil();
		$params = [
			"Personne physique" => $Pp->getShortName(),
			"note" => $this->getScore(),
			"niveau" => $profil['niveau'],
			"profil" => $profil['profil'],
			"description" => $profil['description']
		];
		Logger::setNew("Envoi d'un récapitulatif profil investisseur", $id_dh, $dh->id_dh, $params);
	}
}
