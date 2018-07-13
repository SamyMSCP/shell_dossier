<div class="BlockSituation2">
	<div class="ListeSituation ListeSituationPatrimoniale">
		<ul>
		</ul>
	</div>
	<div class="TableauSituation TableauSituationPatrimoniale">
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
					<th>Fourchette montant patrimoine</th>
					<td><input type="number" class= "fourchetteMontantPatrimoine" name="fourchetteMontantPatrimoine" id="" value="" /></td>
				</tr>
				<tr>
					<th>Repartition Patrimoine</th>
					<td><input type="text" class="repartitionPatrimoine" name="repartitionPatrimoine" id="" value="" /></td>
				</tr>
				<tr>
					<th>Future placements</th>
					<td><input type="checkbox" class= "futurPlacement" name="futurPlacement" id="" value="" /></td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
						<input type="hidden" class="idSituation" name="idSituation" value="" />
						<input type="hidden" class="idSituationPatrimoniale" name="idSituationPatrimoniale" value="" />
						<input type="submit" class="submitSituationPatrimoniale" name="addNewSituationPatrimoniale" value="Ajouter" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
