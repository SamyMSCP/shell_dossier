<div class="BlockSituation2">
	<div class="ListeSituation ListeSituationFinanciere">
		<ul>
		</ul>
	</div>
	<div class="TableauSituation TableauSituationFinanciere">
		<form action="?p=<?=$GLOBALS['GET']['p']?>&client=<?=$GLOBALS['GET']['client']?>&onglet=BENEFICIAIRE" method="post" accept-charset="utf-8">
			<table border="1">
				<tr>
					<th>Date de situation</th>
					<td><input type="date" class= "dateSituation" name="dateSituation" id="" value="" /></td>
				</tr>
				<tr>
					<th>Date de fin de situation</th>
					<td><input type="date" class= "dateFinSituation" name="dateFinSituation" id="" value="" /></td>
				</tr>
				<tr>
					<th>Revenus professionnels</th>
					<td><input type="number" class= "revenuProfessionnels" name="revenuProfessionnels" id="" value="" /></td>
				</tr>
				<tr>
					<th>Revenus Immobiliers</th>
					<td><input type="number" class= "revenuImmobiliers" name="revenuImmobiliers" id="" value="" /></td>
				</tr>
				<tr>
					<th>Revenus mobiliers</th>
					<td><input type="number" class= "revenuMobiliers" name="revenuMobiliers" id="" value="" /></td>
				</tr>
				<tr>
					<th>Revenus Autres</th>
					<td><input type="number" class= "revenuAutres" name="revenuAutres" id="" value="" /></td>
				</tr>
				<tr>
					<th>Remboursement mensuels</th>
					<td><input type="number" class= "remboursementMensuel" name="remboursementMensuel" id="" value="" /></td>
				</tr>
				<tr>
					<th>Duree de remboursement restant</th>
					<td><input type="number" class= "dureeRemboursementRestante" name="dureeRemboursementRestante" id="" value="" /></td>
				</tr>
				<tr>
					<th>Nature autres emprunts</th>
					<td><input type="text" class= "natureAutresEmprunts" name="natureAutresEmprunts" id="" value="" /></td>
				</tr>
				<tr>
					<th>Montant autres emprunts</th>
					<td><input type="number" class= "montantAutresEmprunts" name="montantAutresEmprunts" id="" value="" /></td>
				</tr>
				<tr>
					<th>Duree autres emprunts</th>
					<td><input type="number" class= "dureeAutresEmprunts" name="dureeAutresEmprunts" id="" value="" /></td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
						<input type="hidden" class="idSituation" name="idSituation" value="" />
						<input type="hidden" class="idSituationFinanciere" name="idSituationFinanciere" value="" />
						<input type="submit" class="submitSituationFinanciere" name="addNewSituationFinanciere" value="Ajouter" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
