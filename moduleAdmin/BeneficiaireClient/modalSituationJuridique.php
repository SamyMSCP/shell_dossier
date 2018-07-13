<div class="BlockSituation2">
	<div class="ListeSituation ListeSituationJuridique">
		<ul>
		</ul>
	</div>
	<div class="TableauSituation TableauSituationJuridique">
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
					<th>Regime matrimoniale</th>
					<td><input type="text" class= "regimeMat" name="regimeMat" id="" value="" /></td>
				</tr>
				<tr>
					<th>Nombre d'enfant a charge</th>
					<td><input type="number" class= "NbrEnfantCharge" name="NbrEnfantCharge" id="" value="" /></td>
				</tr>
				<tr>
					<th>Nombre de personnes a charge</th>
					<td>
						<input type="number" class= "NbrPersonnesCharge" name="NbrPersonnesCharge" id="" value="" />
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
						<input type="hidden" class="idSituation" name="idSituation" value="" />
						<input type="hidden" class="idSituationJuridique" name="idSituationJuridique" value="" />
						<input type="submit" class="submitSituationJuridique" name="addNewSituationJuridique" value="Ajouter" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
