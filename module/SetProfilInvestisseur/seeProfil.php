<div class="resultatProfil">
	<div class="animProfil">
		<img src="<?=$this->getPath()?>img/bar.png" alt="" />
		<div class="animProfilCursor">
			<svg width="64px" height="172px" xmlns="http://www.w3.org/2000/svg">
				<path id="cursorAnim" d="M 0,140 l 12,-120 a12,12 10 1,1 40,0 l 12,120" stroke="<?=$this->profil['color']?>" stroke-width="0" fill="rgb(120, 165, 191)" />
			</svg>

			<div class="circle" style="border-color:rgb(120, 165, 191);background-image:url(<?=$this->getPath()?>img/Merci-6-BleuMS.svg);"></div>
		</div>
	</div>
	<div class="profilResult">
		<span style="color:<?=$this->profil['color']?>">VOUS AVEZ OBTENU UN RESULTAT ENTRE <?=$this->profil['min']?> ET <?=number_format($this->profil['max'], 0)?></span>
	</div>
	<div class="">
		<span style="color:<?=$this->profil['color']?>"><?=$this->profil['niveau']?></span>
	</div>
	<div class="profil" style="border-color:<?=$this->profil['color']?>;">
		<span style="color:<?=$this->profil['color']?>;"><?=$this->profil['profil']?></span>
	</div>
	<div class="profilDescription">
		<span style="color:<?=$this->profil['color']?>"><?=$this->profil['description']?></span>
	</div>
	<?php
	if ($this->profilInstance->getScore() < 10)
	{
		?>
		<form  method="post" accept-charset="utf-8">
			<div class="checkers">
				<span>N’hésitez pas à relire le guide de la SCPI pour parfaire vos connaissances.</span>
				<div class="radio radioResult">
					<label class="radio-inline" for="estimation">
						<input class="inputThirdBlock" type="checkbox" name="estimation" id="estimation" value="1" required><span></span>
						Si vous estimez que vous avez une expérience suffisante dans l’investissement de parts de SCPI, merci de bien vouloir cocher cette case. Toutefois MeilleureSCPI.com vous met en garde sur le fait que ce produit pourrait ne pas être adapté à votre profil.
					</label> 
				</div>
				<span>Vous avez noté que :</span>
				<div class="radio radioResult">
					<label class="radio-inline" for="note">
						<input class="inputThirdBlock" type="checkbox" name="note" id="note" value="1" required><span></span>
						L’investissement en parts de SCPI s’inscrit dans le cadre d’un investissement long terme.
						En SCPI, le capital n’est pas garanti et les performances passées ne préjugent en rien des performances futures.
					</label>
				</div>
				<span id="msgAlertSending">Veuillez cocher les cases ci dessus pour passer à la suite.</span>
			</div>
			<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
			<div class="profilBtn">
				<?php
				if (isset($this->haveSecond) && $this->haveSecond == true)
				{
					?>
					<button type="submit" name="action" value="addProfil">PASSER A L'ÉTAPE SUIVANTE</button>
					<?php
				}
				else
				{
					?>
					<button type="submit" name="action" value="addProfil">VALIDER POUR DÉMARRER VOTRE PROJET</button>
					<?php

				}
				?>
			</div>
		</form>
		<?php
	}
	else
	{
		?>
		<div class="profilBtn">
			<form id="formResult" method="post" accept-charset="utf-8">
				<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
				<?php
				if (isset($this->haveSecond) && $this->haveSecond == true)
				{
					?>
					<button type="submit" name="action" value="addProfil">PASSER A L'ÉTAPE SUIVANTE</button>
					<?php
				}
				else
				{
					?>
					<button type="submit" name="action" value="addProfil">VALIDER POUR DÉMARRER VOTRE PROJET</button>
					<?php

				}
				?>
			</form>
		</div>
		<?php
	}
	?>
	<div class="profilComplement" style="border-color:<?=$this->profil['color']?>;background-color: white;">
		<span style="font-size: 14px;color:<?=$this->profil['color']?>">Conformément à la réglementation applicable issue de la directive Européenne n° 2004/38 sur les marchés d'instruments financiers (MIF), vous avez été classé(e)(s) dans la catégorie des clients : NON PROFESSIONNELS. Vous disposez néanmoins de la possibilité de demander un changement de classification en client PROFESSIONNEL par l'envoi d'un courrier recommandé avec accusé de réception à la société de gestion et sous réserve d'acceptation de cette demande qui aurait pour conséquence de réduire votre niveau de protection et d'information.</span>
	</div>
</div>
