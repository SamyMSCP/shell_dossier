<?php
$prenom = "Missing information";
$nom = $prenom;
$telephone = $prenom;
$login = $prenom;
if (!empty($this->dh->getConseiller())) {
	$conseiller = $this->dh->getConseiller();
}
?>
<div class="barre-footer container-fluid">
	<div class="row">
		<div class="col-xs-12 text-center">
			<span class="orange">Une question ?</span>
			<?=$conseiller->getShortName()?>, votre conseiller MeilleureSCPI.com, est joignable au
			<span class="orange">
				<a href="tel://<?=$conseiller->getPersonnePhysique()->getIndicatifPhoneFixe()?><?=$conseiller->getPersonnePhysique()->getPhoneFixe() ?>">
					<?= get_display_num( $conseiller->getPersonnePhysique()->getPhoneFixe(), $conseiller->getPersonnePhysique()->getIndicatifPhoneFixe()) ?>
				</a>
			</span> ou par
			<span class="orange"><a href="#">email</a></span>
		</div>
	</div>
</div>
