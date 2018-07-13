<div class="infoClient">
	<div class="premierPanneau">
		<img src="<?=$this->getPath()?>img/Gender_Homme.png" alt="" />
		<div class="trait"></div>
	</div>
	<div class="deuxiemePanneau">
		<span class="civilite"><?=strtoupper(htmlspecialchars($this->dh->getPersonnePhysique()->getCivilite()))?></span><br />
		<span class="firstName"><?=ucfirst(htmlspecialchars($this->dh->getPersonnePhysique()->getFirstName()))?></span><br />
		<span class="Name"><?=strtoupper(htmlspecialchars($this->dh->getPersonnePhysique()->getName()))?></span><br />
		<span class="phone"><?=htmlspecialchars($this->dh->getPersonnePhysique()->getPhone())?></span><br />
		<span class="phone"><?=htmlspecialchars($this->dh->getPersonnePhysique()->getPhoneFixe())?></span><br />
		<span class="mail">
			<a href="mailto:<?=htmlspecialchars($this->dh->getPersonnePhysique()->getMail())?>">
				<?=htmlspecialchars($this->dh->getPersonnePhysique()->getMail())?>
			</a>
			
		</span><br />
	</div>
	<div class="troisiemePanneau">
		Dernier contact <br />
		Prochain contact <br />
		Dernière connexion <br />
		Type d'utilisateur <br />
		Conseiller <br />
	</div>
	<div class="quatriemePanneau">
		<div class="vueCrmShow">
			<crm-last-date></crm-last-date><br />
			<crm-next-date></crm-next-date><br />
		</div>
		<?php
		/*
		if (!empty($crm[0]->date_r)) {
			?>
			<?=$crm[0]->getCrmDate()?><br />
			<?=$crm[0]->getCrmDatef()?><br />
			<?php
		}
		else
		{
			?>
			CRM vide <br />
			CRM vide <br />
			<?php
		}
		*/
		if (!empty($connexion))
			echo $connexion->getDate()->format("d/m/Y H:i:s");
		else
			echo "Pas de connexion";
		?>
		<br />
		<?=$this->dh->getType()?>
		<br />
		<?php
		if ($this->dh->conseiller == 1)
		{
			echo $this->dh->getConseiller()->getShortName() . " [yoda]";
		}
		else if ($this->dh->conseiller == -1)
		{
			echo "[yoda]";
		}
		else if ($this->collaborateur->type == "yoda" || $this->collaborateur->type == "assistant" || $this->collaborateur->type == "prospecteur" || $this->collaborateur->type == "backoffice" || $this->collaborateur->id_dh == $this->dh->conseiller)
		{
			?>
			<select id="changeConseiller" class="noBorder">
			<?php
				foreach (Dh::getConseillers() as $elm){
					?>
					<option value="<?=$elm->id_dh?>" <?=($elm->id_dh == $this->dh->conseiller) ? "selected" : " "?>>
						<?=$elm->getPersonnePhysique()->getFirstName()?> <?=$elm->getPersonnePhysique()->getName()?>
					</option>
					<?php
				}
				?>
			</select>
			<div>
				<button id="btnChangeConseiller" class='btn-mscpi'>Enregistrer</button>
			</div>
			<?php
		}
		else
		{
			?>
			<?=$this->dh->getConseiller()->getShortName()?>
			<?php
		}
		?>
		<br />
	</div>
	<?php
	if ($this->canBeOriginContact)
	{
		?>
		<div>
			<button onclick="changeDhToOrigineContact()" class="btn-mscpi">Passer ce compte en origine de contact</button>
		</div>
		<?php
	}
	?>
	<?php
	if ($this->canBeProspect)
	{
		?>
		<div>
			<button onclick="changeDhToProspect()" class="btn-mscpi">Passer ce compte en prospect</button>
		</div>
		<?php
	}
	?>
</div>
