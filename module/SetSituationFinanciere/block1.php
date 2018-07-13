<div class="contenu" style="flex:2;">
	<table class="table tableRepartition tableRevenu">
		<thead>
			<tr>
				<th>Vos revenus</th>
				<th colspan="2">Montant de vos revenus</th>
			</tr>
			<tr>
				<th></th>
				<th>par mois</th>
				<th>soit par an</th>
			</tr>
		</thead>
		<tbody>
			<tr  class="forRepRevenu">
				<td>Revenus (Salaires, retraites, pensions...)</td>
				<td>
					<input min="0" id="revenu_professionnels" name="revenu_professionnels" placeholder="-" type="number" required value="<?=(isset($this->SituationFinanciere)) ? $this->SituationFinanciere->getRevenuProfessionnels() : "0" ?>">
					<span>€</span>
				</td>
				<td>
					<span id="total_revenu_professionnels"></span>
				</td>
			</tr>
			<tr class="forRepRevenu">
				<td>Revenus immobiliers</td>
				<td>
					<input  min="0" id="revenu_immobiliers" name="revenu_immobiliers" placeholder="-" type="number" required value="<?=(isset($this->SituationFinanciere)) ? $this->SituationFinanciere->getRevenuImmobiliers() : "0" ?>">
					<span>€</span>
				</td>
				<td>
					<span id="total_revenu_immobiliers"></span>
				</td>
			</tr>
			</tr>
			<tr class="forRepRevenu">
				<td>Revenus mobiliers</td>
				<td>
					<input  min="0" id="revenu_mobiliers" name="revenu_mobiliers" placeholder="-" type="number" required value="<?=(isset($this->SituationFinanciere)) ? $this->SituationFinanciere->getRevenuMobiliers() : "0" ?>">
					<span>€</span>
				</td>
				<td>
					<span id="total_revenu_mobiliers"></span>
				</td>
			</tr>
			<tr class="forRepRevenu">
				<td>Autres</td>
				<td>
					<input min="0" onkeyup="checkAutresRev()" id="revenu_autres" name="revenu_autres" placeholder="-" type="number" value="<?=(isset($this->SituationFinanciere)) ? $this->SituationFinanciere->getRevenuAutres() : "0" ?>">
					<span>€</span>
				</td>
				<td>
					<span id="total_revenu_autres"></span>
				</td>
			</tr>
			<tr class="natAutre">
				<td>Précisez la nature</td>
				<td>
					<input id="nature_revenu_autres" name="nature_revenu_autres" type="text" placeholder="" value="<?=(isset($this->SituationFinanciere)) ? $this->SituationFinanciere->getNatureRevenuAutres() : "" ?>">
				</td>
				<td>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="height:px;"></td>
			</tr>
			<tr class="ShowTotal">
				<td>Total</td>
				<td style="text-align:right;">
					<div id="totalTmp" class="input-md" style="display:inline;"></div>
					<span style="margin-left:18px;">€</span>
				</td>
				<td>
					<span id="total_revenu_annuels"></span>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<div class="contenu contenuRepartition"  style="flex:1;">
	<div class='forRepartinion'>
		<canvas id="repartition_revenu"></canvas>
	</div>
</div>

