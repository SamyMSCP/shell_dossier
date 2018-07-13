<div class="newBeneficiaire">
	<form action="?p=<?=$GLOBALS['GET']['p']?>&client=<?=$GLOBALS['GET']['client']?>&onglet=BENEFICIAIRE" method="post" accept-charset="utf-8">
		<table border="1">
			<tr>
				<th colspan="2">
					<div class="enteteTableDetail">Nouveau Beneficiaire</div>
				</th>
			</tr>
			<tr>
				<th>Type de beneficiaire</th>
				<td>
					<select onchange="redrawBeneficiaireNewForm();" class="formTypeBeneficiaire" name="formTypeBeneficiaire" id="">
						<option value="Pp">Personne Physiques</option>
						<option value="Pm">Personne Morale</option>
					</select>
				</td>
			</tr>
			<tr class="forPpBeneficiaire">
				<th>Form personne physique</th>
				<td>
					<select onchange="redrawBeneficiaireNewForm();" class="formBeneficiairePp" name="formBeneficiairePp" id="">
						<option value="seul">Personne seule</option>
						<option value="couple">Couple</option>
					</select>
				</td>
			</tr>
			<tr class="forPpBeneficiaire forBeneficiaireSeule">
				<th>Personne physique</th>
				<td>
					<select onchange="redrawBeneficiaireNewForm();" class="formTypeBeneficiairePpSeul" name="formTypeBeneficiairePpSeul" id="">
					<?php
						foreach ($this->Pp as $key => $elm) {
								if (count($elm->getBeneficiaireSeul()))
									continue;
							?>
								<option value="<?=$elm->id_phs?>"><?=$elm->getFirstName()?> <?=strtoupper($elm->getName())?></option>
							<?php
						}
						?>
						<option value="new">Nouvel personne physique</option>
					</select>
				</td>
			</tr>
			<tr class="forPpBeneficiaire forBeneficiaireSeule newPpSeul">
				<th>Civilite de la nouvelle personne</th>
				<td>
					<select class="formBeneficiairePp" name="formBeneficiaireSeulCivilite" id="">
						<option value="Monsieur">Monsieur</option>
						<option value="Madame">Madame</option>
					</select>
				</td>
			</tr>
			<tr class="forPpBeneficiaire forBeneficiaireSeule newPpSeul">
				<th>Prenom de la nouvelle personne</th>
				<td>
					<input type="text" name="formBeneficiaireSeulPrenom" id="" value="" />
				</td>
			</tr>
			<tr class="forPpBeneficiaire forBeneficiaireSeule newPpSeul">
				<th>Nom de la nouvelle personne</th>
				<td>
					<input type="text" name="formBeneficiaireSeulNom" id="" value="" />
				</td>
			</tr>
			<tr class="forPpBeneficiaire forBeneficiaireSeule newPpSeul">
				<th>Mail de la nouvelle personne</th>
				<td>
					<input type="email" name="formBeneficiaireSeulMail" id="" value="" />
				</td>
			</tr>
			<tr class="forPpBeneficiaire forBeneficiaireSeule newPpSeul">
				<th>Type de lien avec cette nouvelle personne</th>
				<td>
					<select class="formBeneficiairePp" name="formBeneficiaireSeulTypeLien" id="">
						<option value="epou">Mon epou</option>
						<option value="parent">Un parent</option>
						<option value="ami">Un ami</option>
					</select>
				</td>
			</tr>
			<tr class="forPpBeneficiaire forBeneficiaireCouple">
				<th>Membre du couple 1</th>
				<td>
					<select onchange="redrawBeneficiaireNewForm();" class="formTypeBeneficiairePpCouple1" name="formTypeBeneficiairePpCouple1" id="">
					<?php
						foreach ($this->Pp as $key => $elm) {
							if (count($elm->getBeneficiaireCouple()))
								continue;
							?>
								<option value="<?=$elm->id_phs?>"><?=$elm->getFirstName()?> <?=strtoupper($elm->getName())?></option>
							<?php
						}
						?>
						<option value="new">Nouvel personne physique</option>
					</select>
				</td>
			</tr>
			<tr class="forPpBeneficiaire forBeneficiaireSeule newPpCouple1">
				<th>Civilite de la nouvelle personne</th>
				<td>
					<select class="formBeneficiairePp" name="formBeneficiaireCouple1Civilite" id="">
						<option value="Monsieur">Monsieur</option>
						<option value="Madame">Madame</option>
					</select>
				</td>
			</tr>
			<tr class="forPpBeneficiaire forBeneficiaireSeule newPpCouple1">
				<th>Prenom de la nouvelle personne</th>
				<td>
					<input type="text" name="formBeneficiaireCouple1Prenom" id="" value="" />
				</td>
			</tr>
			<tr class="forPpBeneficiaire forBeneficiaireSeule newPpCouple1">
				<th>Nom de la nouvelle personne</th>
				<td>
					<input type="text" name="formBeneficiaireCouple1Nom" id="" value="" />
				</td>
			</tr>
			<tr class="forPpBeneficiaire forBeneficiaireSeule newPpCouple1">
				<th>Mail de la nouvelle personne</th>
				<td>
					<input type="email" name="formBeneficiaireCouple1Mail" id="" value="" />
				</td>
			</tr>
			<tr class="forPpBeneficiaire forBeneficiaireSeule newPpCouple1">
				<th>Type de lien avec cette nouvelle personne</th>
				<td>
					<select class="formBeneficiairePp" name="formBeneficiaireCouple1TypeLien" id="">
						<option value="epou">Epoux</option>
						<option value="parent">Un parent</option>
						<option value="ami">Un ami</option>
					</select>
				</td>
			</tr>
			<tr class="forPpBeneficiaire forBeneficiaireCouple">
				<th>Membre du couple 2</th>
				<td>
					<select onchange="redrawBeneficiaireNewForm();" class="formTypeBeneficiairePpCouple2" name="formTypeBeneficiairePpCouple2" id="">
					<?php
						foreach ($this->Pp as $key => $elm) {
							if (count($elm->getBeneficiaireCouple()))
								continue;
							?>
							<option value="<?=$elm->id_phs?>"><?=$elm->getFirstName()?> <?=strtoupper($elm->getName())?></option>
							<?php
						}
						?>
						<option value="new">Nouvel personne physique</option>
					</select>
				</td>
			</tr>
			<tr class="forPpBeneficiaire forBeneficiaireCouple newPpCouple2">
				<th>Civilite de la nouvelle personne</th>
				<td>
					<select class="formBeneficiairePp" name="formBeneficiaireCouple2Civilite" id="">
						<option value="Monsieur">Monsieur</option>
						<option value="Madame">Madame</option>
					</select>
				</td>
			</tr>
			<tr class="forPpBeneficiaire forBeneficiaireCouple newPpCouple2">
				<th>Prenom de la nouvelle personne</th>
				<td>
					<input type="text" name="formBeneficiaireCouple2Prenom" id="" value="" />
				</td>
			</tr>
			<tr class="forPpBeneficiaire forBeneficiaireCouple newPpCouple2">
				<th>Nom de la nouvelle personne</th>
				<td>
					<input type="text" name="formBeneficiaireCouple2Nom" id="" value="" />
				</td>
			</tr>
			<tr class="forPpBeneficiaire forBeneficiaireCouple newPpCouple2">
				<th>Mail de la nouvelle personne</th>
				<td>
					<input type="email" name="formBeneficiaireCouple2Mail" id="" value="" />
				</td>
			</tr>
			<tr class="forPpBeneficiaire forBeneficiaireCouple newPpCouple2">
				<th>Type de lien avec cette nouvelle personne</th>
				<td>
					<select class="formBeneficiairePp" name="formBeneficiaireCouple2TypeLien" id="">
						<option value="epou">Mon epou</option>
						<option value="parent">Un parent</option>
						<option value="ami">Un ami</option>
					</select>
				</td>
			</tr>
			<tr class="forPmBeneficiaire">
				<th>Pour quelle personne morale ?</th>
				<td>
					<select onchange="redrawBeneficiaireNewForm();" class="formBeneficiairePm" name="formBeneficiairePm" id="">
						<?php
						foreach ($this->Pm as $key => $elm) {
							?>
							<option value="<?=$elm->id_pm?>"><?=$elm->getDenominationSociale()?></option>
							<?php
						}
						?>
						<option value="new">Nouvelle personne morale</option>
					</select>
				</td>
			</tr>
			<tr class="forPmBeneficiaire forPmBeneficiaireNew">
				<th>Denomination sociale</th>
				<td>
					<input type="text" name="formBeneficiaireMoraleDenomination" id="" value="" />
				</td>
			</tr>
			<tr class="BtnSubmit" >
				<input type="hidden" class="tokenCsrfPp" name="token" id="token" value="<?=$_SESSION['csrf'][0]?>"/>
				<input type="hidden" class="idClient" name="idClient" id="" value="<?=$GLOBALS['GET']['client']?>" />
				<th colspan="2"><input class="submitPersonnePhysique" type="submit" name="action" id="" value="Ajouter un nouveau beneficiaire" /></th>
			</tr>
		</table>
	</form>
	<span onclick="showBeneficiaireList();" class="BtnReturnPersonne">Retour</span>
</div>

