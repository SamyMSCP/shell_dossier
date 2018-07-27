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
<div class="barre-footer">
    <div class="question">
        Une question ?
    </div>
    <div class="john">
        <?=$conseiller->getShortName()?>, votre conseiller MeilleureSCPI.com, est joignable au
    </div>
    <div class="numeros">

        <?=  $conseiller->getPersonnePhysique()->getPhoneFixe()?>

       </div>
    <div class="oupar">
        ou par
    </div>
    <div class="email">

        <a  style="color: #ff9f1c" href="mailto:<?=$conseiller->getLogin()?>"><?=$conseiller->getLogin()?></a>
    </div>
</div>


