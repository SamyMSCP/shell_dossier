<?=$this->Loading?>
<?=$this->Nav2?>
<?= $this->ToolTip?>
<?= $this->NotNow?>
<?php
if ($dh->getPersonnePhysique()->getPhone() == "-")
	echo $this->ForceSetPhone;
?>
<?=  $this->AdressePostaleComponent?>
<div id="appBadges" class="containerPerso">
	<?= $this->MonCompte?>

    <div  class="blockTitle">
        <h1 style="margin-right: auto; margin-left: auto">BADGES</h1>
    </div>
    <div class="barre_bleu" style="margin-right: auto; margin-left: auto"></div>

    <div class="blockTitle">
        <span>Géographie</span>
    </div>
    <div class="barre_bleu"></div>
    <div class="block_list">
        <div class="element">
            <img v-if="selectedTransaction.haveParis" src="<?=$this->getPath()?>img/paris.jpg" />
            <img v-else style="opacity:0.2;" src="<?=$this->getPath()?>img/paris.jpg" />
            <div class="masque">
                <span>Badge Paris</span>
            </div>
            <div><h3>Paris</h3></div>
        </div>
        <div class="element">
            <img v-if="selectedTransaction.haveIdF" src="<?=$this->getPath()?>img/ile_de_france.png" />
            <img v-else style="opacity:0.2;" src="<?=$this->getPath()?>img/ile_de_france.png" />
            <div class="masque">
                <span>Badge Ile-de-France</span>
            </div>
            <div><h3>Ile-de-France</h3></div>
        </div>

        <div class="element">
            <img v-if="selectedTransaction.haveRegion" src="<?=$this->getPath()?>img/region.png" />
            <img v-else style="opacity:0.2;" src="<?=$this->getPath()?>img/region.png" />
            <div class="masque">
                <span>Badge Région</span>
            </div>
            <div><h3>Région</h3></div>
        </div>

        <div class="element">
            <img v-if="selectedTransaction.haveEtranger" src="<?=$this->getPath()?>img/europe.png" />
            <img v-else style="opacity:0.2;" src="<?=$this->getPath()?>img/europe.png" />
            <div class="masque">
                <span>Badge Etranger</span>
            </div>
            <div><h3>Etranger</h3></div>
        </div>

        <div class="element">
            <img v-if="selectedTransaction.haveGlobeTrotters" src="<?=$this->getPath()?>img/globe_trotter.png" />
            <img v-else style="opacity:0.2;" src="<?=$this->getPath()?>img/globe_trotter.png" />
            <div class="masque">
                <span>Badge Globe Trotters</span>
            </div>
            <div><h3>Globe Trotters</h3></div>
        </div>

    </div>

    <div class="blockTitle">
        <span>Type de scpi </span>
    </div>
    <div class="barre_bleu"></div>
    <div class="block_list">
        <div class="element">
            <img v-if="selectedTransaction.haveScpiRendement" src="<?=$this->getPath()?>img/scpi_de_rendement.png" />
            <img v-else style="opacity:0.2;" src="<?=$this->getPath()?>img/scpi_de_rendement.png" />
            <div class="masque">
                <span>Badge scpi de rendement</span>
            </div>
            <div><h3>Scpi de rendement</h3></div>

        </div>


        <div class="element">
            <img v-if="selectedTransaction.haveScpiFiscal" src="<?=$this->getPath()?>img/scpi_fiscale.png" />
            <img v-else style="opacity:0.2;" src="<?=$this->getPath()?>img/scpi_fiscale.png" />
            <div class="masque">
                <span>Badge scpi fiscale</span>
            </div>
            <div><h3>Scpi fiscale</h3></div>
        </div>

        <div class="element">
            <img v-if="selectedTransaction.haveInvestissementDivers" src="<?=$this->getPath()?>img/investissement_diversifie.png" />
            <img v-else style="opacity:0.2;" src="<?=$this->getPath()?>img/investissement_diversifie.png" />
            <div class="masque">
                <span>Badge investissement diversifié</span>
            </div>
            <div><h3>Investissement diversifié</h3></div>
        </div>

    </div>
    <div class="blockTitle">
        <span>Catégorie de scpi</span>
    </div>
    <div class="barre_bleu"></div>
    <div class="block_list">
        <div class="element">
            <img v-if="selectedTransaction.haveSpecialiste" src="<?=$this->getPath()?>img/allo_docteur.png" />
            <img v-else style="opacity:0.2;" src="<?=$this->getPath()?>img/allo_docteur.png" />
            <div class="masque">
                <span>Badge specialiste</span>
            </div>
            <div><h3>Specialiste</h3></div>
        </div>

        <div class="element">
            <img v-if="selectedTransaction.haveCommerce" src="<?=$this->getPath()?>img/super_commercant.png" />
            <img v-else style="opacity:0.2;" src="<?=$this->getPath()?>img/super_commercant.png" />
            <div class="masque">
                <span>Badge Retail</span>
            </div>
            <div><h3>Retail</h3></div>
        </div>

        <div class="element">
            <img v-if="selectedTransaction.haveBureau" src="<?=$this->getPath()?>img/homme_affaire.png" />
            <img v-else style="opacity:0.2;" src="<?=$this->getPath()?>img/homme_affaire.png" />
            <div class="masque">
                <span>Badge Business</span>
            </div>
            <div><h3>Business</h3></div>
        </div>

        <div class="element">
            <img v-if="selectedTransaction.haveAguerri" src="<?=$this->getPath()?>img/epargnant_agueri.png" />
            <img v-else style="opacity:0.2;" src="<?=$this->getPath()?>img/epargnant_agueri.png" />
            <div class="masque">
                <span>Badge epargant aguerri</span>
            </div>
            <div><h3>Epargant aguerri</h3></div>
        </div>


    </div>
    <div class="blockTitle">
        <span>Type de propriétaire </span>
    </div>
    <div class="barre_bleu"></div>
    <div class="block_list">
        <div class="element">
            <img v-if="selectedTransaction.havePleine" src="<?=$this->getPath()?>img/pleine_propriete.png" />
            <img v-else style="opacity:0.2;" src="<?=$this->getPath()?>img/pleine_propriete.png" />
            <div class="masque">
                <span>Badge pleine propriété</span>
            </div>
            <div><h3>Pleine propriété</h3></div>
        </div>

        <div class="element">
            <img v-if="selectedTransaction.haveNue" src="<?=$this->getPath()?>img/nue_propriete.png" />
            <img v-else style="opacity:0.2;" src="<?=$this->getPath()?>img/nue_propriete.png" />
            <div class="masque">
                <span>Badge nue propriété</span>
            </div>
            <div><h3>Nue propriété</h3></div>
        </div>

        <div class="element">
            <img v-if="selectedTransaction.haveUsu" src="<?=$this->getPath()?>img/usufruit.png" />
            <img v-else style="opacity:0.2;" src="<?=$this->getPath()?>img/usufruit.png" />
            <div class="masque">
                <span>Badge usufruit</span>
            </div>
            <div><h3>Usufruit</h3></div>
        </div>

        <div class="element">
            <img v-if="selectedTransaction.havePropComplet" src="<?=$this->getPath()?>img/globe_trotter.png" />
            <img v-else style="opacity:0.2;" src="<?=$this->getPath()?>img/globe_trotter.png" />
            <div class="masque">
                <span>Badge propriété complet</span>
            </div>
            <div><h3>Propriété complet</h3></div>
        </div>


    </div>
    <div class="blockTitle">
        <span>Nombre de scpi</span>
    </div>
    <div class="barre_bleu"></div>
    <div class="block_list">

        <div class="element">
            <img v-if="selectedTransaction.haveDebutant" src="<?=$this->getPath()?>img/debutant.png" />
            <img v-else style="opacity:0.2;" src="<?=$this->getPath()?>img/debutant.png" />
            <div class="masque">
                <span>Badge débutant</span>
            </div>
            <div><h3>Débutant</h3></div>
        </div>

        <div class="element">
            <img v-if="selectedTransaction.haveAmateur" src="<?=$this->getPath()?>img/amateur.png" />
            <img v-else style="opacity:0.2;" src="<?=$this->getPath()?>img/amateur.png" />
            <div class="masque">
                <span>Badge amateur</span>
            </div>
            <div><h3>Amateur</h3></div>
        </div>

        <div class="element">
            <img v-if="selectedTransaction.haveSemiPro" src="<?=$this->getPath()?>img/semi_pro.png" />
            <img v-else style="opacity:0.2;" src="<?=$this->getPath()?>img/semi_pro.png" />
            <div class="masque">
                <span>Badge semi-pro</span>
            </div>
            <div><h3>Semi-pro</h3></div>
        </div>

        <div class="element">
            <img v-if="selectedTransaction.havePro" src="<?=$this->getPath()?>img/semi_pro.png" />
            <img v-else style="opacity:0.2;" src="<?=$this->getPath()?>img/semi_pro.png" />
            <div class="masque">
                <span>Badge professionel</span>
            </div>
            <div><h3>Professionel</h3></div>
        </div>

        <div class="element">
            <img v-if="selectedTransaction.haveExpert" src="<?=$this->getPath()?>img/expert.png" />
            <img v-else style="opacity:0.2;" src="<?=$this->getPath()?>img/expert.png" />
            <div class="masque">
                <span>Badge expert</span>
            </div>
            <div><h3>Expert</h3></div>
        </div>


    </div>

    <div class="blockTitle">
        <span>Autre</span>
    </div>
    <div class="barre_bleu"></div>
    <div class="block_list">
        <div class="element">
            <img v-if="selectedTransaction.haveBonEleve" src="<?=$this->getPath()?>img/bon_eleve.png" />
            <img v-else style="opacity:0.2;" src="<?=$this->getPath()?>img/bon_eleve.png" />
            <div class="masque">
                <span>Badge bon élève</span>
            </div>
            <div><h3>Bon élève</h3></div>
        </div>

        <div class="element">
            <img v-if="selectedTransaction.haveAssocieFondateur" src="<?=$this->getPath()?>img/associe_fondateur.png" />
            <img v-else style="opacity:0.2;" src="<?=$this->getPath()?>img/associe_fondateur.png" />
            <div class="masque">
                <span>Badge associé fondateur</span>
            </div>
            <div><h3>Associé fondateur</h3></div>
        </div>
    </div>
</div>
<br><br><br><br><br><br><br><br><br>
<?=$this->ModuleBarre?>
<div id="appBadges">
	<msg-box></msg-box>
</div>
