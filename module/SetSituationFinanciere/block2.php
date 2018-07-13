<div class="contenu" style="flex:2;">
	<div class="form-group" style="margin-top: 50px;">
		<label class="labelForm control-label" for="habitation">Vous êtes : </label>
		<div class="inputForm radioCol" style="margin-top: -6px;">
			<label class="radio-inline" for="habitation-0">
			<input type="radio" name="habitation" id="habitation-0" value="1" <?=(isset($this->SituationFinanciere) && $this->SituationFinanciere->getHabitation() == 1) ? "checked" : "" ?>><span></span>Propriétaire de votre résidence principale
			</label> 
			<label class="radio-inline" for="habitation-1">
				<input type="radio" name="habitation" id="habitation-1" value="2" <?=(isset($this->SituationFinanciere) && $this->SituationFinanciere->getHabitation() == 2) ? "checked" : "" ?>><span></span>Locataire
			</label> 
			<label class="radio-inline" for="habitation-2" >
				<input type="radio" name="habitation" id="habitation-2" value="3"<?=(isset($this->SituationFinanciere) && $this->SituationFinanciere->getHabitation() == 3) ? "checked" : "" ?>><span></span>Hébergé à titre gratuit
			</label> 
		</div>
	</div>


	<table class="table empOther tableRepartition tableCharge">
		<thead>
			<tr>
				<th>Vos charges</th>
				<th colspan="2">Montant de vos charges mensuelles</th>
				<th>Durée restante en mois</th>
			</tr>
			<tr>
				<th></th>
				<th>par mois</th>
				<th>soit par an</th>
				<th></th>
			</tr>
		</thead>
		<tbody>


			<tr class="forCreditResidencePrincipale forRepCharges">
				<td>Crédit résidence principale</td>
				<td>
					<input value="<?=(isset($this->SituationFinanciere)) ? $this->SituationFinanciere->getRemboursementMensuel() : "0" ?>" min="0" id="remboursement_mensuel" name="remboursement_mensuel" placeholder="Montant de vos remboursements mensuels" type="number" required><span>€</span>
				</td>
				<td>
					<span id="total_remboursement_mensuel">Annuel</span>
				</td>
				<td>
					<input value="<?=(isset($this->SituationFinanciere)) ? $this->SituationFinanciere->getDureeRemboursementRestante() : "0" ?>" min="0" id="duree_remboursement_restante" name="duree_remboursement_restante" placeholder="Durée restante" type="number" required>
				</td>
			</tr>


			<tr class="forLoyerResidencePrincipale forRepCharges">
				<td>Loyer résidence principale</td>
				<td>
					<input value="<?=(isset($this->SituationFinanciere)) ? $this->SituationFinanciere->getMontantLoyer() : "0" ?>" value="" min="0" id="loyer_montant" name="loyer_montant" placeholder="Montant de vos remboursements mensuels" type="number" required><span>€</span>
				</td>
				<td>
					<span id="total_loyer_montant">Annuel</span>
				</td>
				<td>
					<input disabled style="border:none;">
				</td>
			</tr>


			<tr class="forRepCharges">
				<td>Crédit résidence secondaire</td>
				<td>
					<input value="<?=(isset($this->SituationFinanciere)) ? $this->SituationFinanciere->getMontantResidence() : "0" ?>"  min="0" type="number" value="0" id="residance_montant" name="residance_montant"><span>€</span>
				</td>
				<td>
					<span id="total_residance_montant">Annuel</span>
				</td>
				<td><input value="<?=(isset($this->SituationFinanciere)) ? $this->SituationFinanciere->getDureeResidence() : "0" ?>"   min="0" type="number" value="0" id="residance_duree" name="residance_duree"></td>
			</tr>


			<tr class="forRepCharges">
				<td>Crédit immobilier locatif</td>
				<td>
					<input value="<?=(isset($this->SituationFinanciere)) ? $this->SituationFinanciere->getMontantLocatif() : "0" ?>"   min="0" type="number" value="0" id="locatif_montant" name="locatif_montant"><span>€</span>
				</td>
				<td>
					<span id="total_locatif_montant">Annuel</span>
				</td>
				<td><input value="<?=(isset($this->SituationFinanciere)) ? $this->SituationFinanciere->getDureeLocatif() : "0" ?>"  min="0"  type="number" value="0" id="locatif_duree" name="locatif_duree"></td>
			</tr>

			<tr class="forRepCharges">
				<td>Crédit SCPI</td>
				<td>
				   <input value="<?=(isset($this->SituationFinanciere)) ? $this->SituationFinanciere->getMontanScpi() : "0" ?>"  min="0"  type="number" value="0" id="scpi_montant" name="scpi_montant"><span>€</span>
				</td>
				<td>
					<span id="total_scpi_montant">Annuel</span>
				</td>
				<td><input value="<?=(isset($this->SituationFinanciere)) ? $this->SituationFinanciere->getDureeScpi() : "0" ?>"  min="0"  type="number" value="0" id="scpi_duree" name="scpi_duree"></td>
			</tr>


			<tr class="forRepCharges">
				<td>Crédit à la consommation</td>
				<td>
				   <input value="<?=(isset($this->SituationFinanciere)) ? $this->SituationFinanciere->getMontantConsommation() : "0" ?>"  min="0"  type="number" value="0" id="consommation_montant" name="consommation_montant"><span>€</span>
				</td>
				<td>
					<span id="total_consommation_montant">Annuel</span>
				</td>
				<td><input  value="<?=(isset($this->SituationFinanciere)) ? $this->SituationFinanciere->getDureeConsommation() : "0" ?>"  min="0"  type="number" value="0" id="consommation_duree" name="consommation_duree"></td>
			</tr>


			<tr class="forRepCharges">
				<td>Autres credits</td>
				<td>
				   <input value="<?=(isset($this->SituationFinanciere)) ? $this->SituationFinanciere->getMontantAutres2() : "0" ?>"  min="0"  type="number" value="0" id="autres_remboursement_montant" name="autres_remboursement_montant"><span>€</span>
				</td>
				<td>
					<span id="total_autres_remboursement_montant">Annuel</span>
				</td>
				<td><input value="<?=(isset($this->SituationFinanciere)) ? $this->SituationFinanciere->getDureeAutres2() : "0" ?>"  min="0"  type="number" value="0" id="autres_remboursement_duree" name="autres_remboursement_duree"></td>
			</tr>


            <tr class="forRepCharges">
                <td>Autres charges</td>
                <td>
                    <input value="<?=(isset($this->SituationFinanciere)) ? $this->SituationFinanciere->getAutresCharges() : "0" ?>"  min="0"  type="number" value="0" id="autres_charges" name="autres_charges"><span>€</span>
                </td>
                <td>
                    <span id="total_autres_charges">Annuel</span>
                </td>
                <td></td>
            </tr>


			<tr>
				<td>Total</td>
				<td style="text-align: right;padding-right: 18px;">
					<span id="totalTmp1"></span>
					<span>&nbsp;&nbsp;€</span>
				</td>
				<td>
					<span id="total_totalTmp1">Annuel</span>
				</td>
				<td></td>
			</tr>


		</tbody>
	</table>
</div>
<div class="contenu contenuRepartition" style="flex:1;">
	<div class='forRepartinion'>
		<canvas id="repartition_charges"></canvas>
	</div>
</div>
