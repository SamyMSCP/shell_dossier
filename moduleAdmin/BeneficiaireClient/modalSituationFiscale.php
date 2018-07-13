<div class="BlockSituation2">
	<div class="ListeSituation ListeSituationFiscale">
		<ul>
		</ul>
	</div>
	<div class="TableauSituation TableauSituationFiscale">
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
					<th>resident en france</th>
					<td><input type="checkbox" class= "residentFrance" name="residentFrance" id="" value="" /></td>
				</tr>
				<tr>
					<th>Taux marginal d'imposition</th>
					<td><input type="number" class= "tauxMarginalImposition" name="tauxMarginalImposition" id="" value="" /></td>
				</tr>
				<tr>
					<th>Impots sur l'annee precedente</th>
					<td><input type="number" class= "impotsAnneePrecedente" name="impotsAnneePrecedente" id="" value="" /></td>
				</tr>
				<tr>
					<th>Nombre de parts fiscales</th>
					<td>
						<input type="number" class= "nbrPartsFiscales" name="nbrPartsFiscales" id="" value="" />
					</td>
				</tr>
				<tr>
					<th>Tranche ISF</th>
					<td>
						<input type="number" class= "trancheIsf" name="trancheIsf" id="" value="" />
					</td>
				</tr>
				<tr>
					<th>Montant impots ISF</th>
					<td>
						<input type="number" class= "montantIsf" name="montantIsf" id="" value="" />
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
						<input type="hidden" class="idSituation" name="idSituation" value="" />
						<input type="hidden" class="idSituationFiscale" name="idSituationFiscale" value="" />
						<input type="submit" class="submitSituationFiscale" name="addNewSituationFiscale" value="Ajouter" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
