<?php
$prenom = "Missing information";
$nom = $prenom;
$telephone = $prenom;
$login = $prenom;
if (!empty($this->dh->getConseiller())) {
	$conseiller = $this->dh->getConseiller();
	//$prenom = $this->dh->getConseiller()->getPersonnePhysique()->getFirstName();
	//$nom = $this->dh->getConseiller()->getPersonnePhysique()->getName();
	//$telephone = $this->dh->getConseiller()->getPersonnePhysique()->getPhoneFixe();
	//$login = $this->dh->getConseiller()->getLogin();
}
?>
<div class="BarreBas">
	<div class="blockInfo">
		<span class="blockInfoCons">
		Coordonnées de votre conseiller :
		</span>
		<span>
			<?=$conseiller->getShortName()?>
		</span>
		<span>
			<img src="<?=$this->getPath()?>img/Phone-bleuclair.png" alt="" />
			<?= get_display_num(
				$conseiller->getPersonnePhysique()->getPhoneFixe(),
				$conseiller->getPersonnePhysique()->getIndicatifPhoneFixe()
			)?>
		</span>
		<span>
			<img src="<?=$this->getPath()?>img/Email-bleuclair.png" alt="" /> <?=$conseiller->getLogin()?>
		</span>
	</div>
</div>
