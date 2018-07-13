<div class="footer-module">
	<div class="footer-title">
		<i class="fa fa-info-circle" aria-hidden="true"></i><!--ICON IS HERE-->
		<span>AVERTISSEMENTS</span>
	</div>
	<div class="moduleContent">
<?php
	
	$prenom = "Missing information";
	$nom = $prenom;
	$telephone = $prenom;
	$login = $prenom;
	if (!empty($this->dh->getConseiller())) {
		$prenom = $this->dh->getConseiller()->getPersonnePhysique()->getFirstName();
		$nom = $this->dh->getConseiller()->getPersonnePhysique()->getName();
		$telephone = $this->dh->getConseiller()->getPersonnePhysique()->getPhoneFixe();
		$login = $this->dh->getConseiller()->getLogin();
	}

?>
		<div class="footerMention">
			<a id="mention-risque"></a>
			<p>
				La SCPI comporte des risques de pertes en capital, de liquidité. Il s'agit d'un placement long-terme.

				<br />
				<br />
				Toutes les informations et données financières relatives aux SCPI sont données à  titre indicatif, même si elles ont été établie à partir de sources sérieuses et réputées fiables. Elle ne saurait constituer de la part de MEILLEURESCPI.com ni une offre d'achat, de vente ou de souscription de prodtuis financiers et ne peut être assimilée à une incitation ou recommandation à opérer sur les valeurs visées. Pour toute information, merci de vous rapprocher de votre conseiller ou de la société de gestion pour vos souscriptions.

				<br />
				<br />
				MEILLEURESCPI.com décline toute responsabilité dans l'utilisation qui pourrait être faite de ces informations et des conséquences qui pourraient en découler, notamment de toute décision prise sur la base des informations contenues sur le site.

				<br />
				<br />
				Il est strictement interdit de publier, rediffuser, retransmettre ou reproduire les informations et données financières contenues dans ce site dans le but de les transmettre à un tiers. Toute reproduction ou plus généralement toute exploitation non autorisée des informations et données financières engage la responsabilité de l'utilisateur et peut entraîner des poursuites judiciaires fondées notamment sur une action en contrefaçon.
				<br />
				<br />
				Il est notamment interdit d'utiliser tout moyen de récupération automatique (programme informatique) pour recueillir les données présentes sur MEILLEURESCPI.com. Toute tentative de récupération automatique entraînera immédiatement le dépôt d'une plainte.
			</p>
		</div>
	</div>
</div>
