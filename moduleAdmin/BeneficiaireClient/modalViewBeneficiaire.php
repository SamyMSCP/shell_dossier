<div class="modal fade modalViewBeneficiaire" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modalViewBeneficiaireContour">
		<div class="modal-content modalViewBeneficiaireContent">
			<div class="modalViewBeneficiaireBntClose" data-dismiss="modal" aria-label="Close">
				<img src="<?=$this->getPath()?>img/Close-Jaune.svg" alt="" />
			</div>
			<div class="modalViewBeneficiaireTitre">
				<h2 >M. ET MME ROUSSEAU</h2>
				<img src="<?=$this->getPath()?>img/" alt="" />
			</div>
			<div class="traitDonneurModalViewBeneficiaire"></div>


			<div class="modalViewBeneficiaireBlockPp">
			</div>


			<div class="ongletsBoutons2">
				<ul>
					<li class="onglets2Btn BtnProjet" onclick="showInOnglet2('Projet')">PROJET</li>
					<li class="onglets2Btn BtnSituation" onclick="showInOnglet2('Situation')">SITUATION</li>
				</ul>
			</div>

			<div class="blockOnglet2">
				<div class="modalViewBeneficiaireBlockBeneficiaire onglets2 BlockProjet">
					<div class="modalViewBeneficiaireProjet">
						<h3>PROJETS</h3>
					</div>
					<div class="traitDonneurModalViewBeneficiairePp"></div>
					<div class="modalViewBeneficiaireBlockProjets"></div>
				</div>

				<div class="modalViewBeneficiaireBlockBeneficiaire onglets2 BlockSituation">
					<div class="modalViewBeneficiaireProjet">
						<h3>SITUATION JURIDIQUE</h3>
					</div>
					<div class="traitDonneurModalViewBeneficiairePp"></div>
					<?php
						include("modalSituationJuridique.php");
					?>
					<div class="modalViewBeneficiaireProjet">
						<h3>SITUATION FINANCIERE</h3>
					</div>
					<div class="traitDonneurModalViewBeneficiairePp"></div>
					<?php
						include("modalSituationFinanciere.php");
					?>
					<div class="modalViewBeneficiaireProjet">
						<h3>SITUATION FISCALE</h3>
					</div>
					<div class="traitDonneurModalViewBeneficiairePp"></div>
					<?php
						include("modalSituationFiscale.php");
					?>
					<div class="modalViewBeneficiaireProjet">
						<h3>SITUATION PATRIMONIALE</h3>
					</div>
					<div class="traitDonneurModalViewBeneficiairePp"></div>
					<?php
						include("modalSituationPatrimoniale.php");
					?>
				</div>

			</div>
		</div>
	</div>
</div>
<?php
include('modalViewBeneficiaireBlockPp.php');
include('modalViewBeneficiaireBlockProject.php');
include('modalViewBeneficiaireBlockProjectNew.php');
?>
