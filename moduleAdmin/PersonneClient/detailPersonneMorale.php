<div class="personnesClientDetail formMorale">
	<form action="?p=<?=$GLOBALS['GET']['p']?>&client=<?=$GLOBALS['GET']['client']?>&onglet=PERSONNES" method="post" accept-charset="utf-8">
		<table border="1">
			<tr class="Locker">
				<td colspan="2">
					<img class="closed" ondblclick="enabledPersonneMoralModification();" src="<?=$this->getPath()?>img/Lock_closed.png" alt="" />
					<img class="open" ondblclick="enabledPersonneMoralModification();" src="<?=$this->getPath()?>img/Lock_open.png" alt="" />
				</td>
			</tr>
			<tr>
				<th>Denomination sociale</th>
				<td><input class="social" type="text" name="denomination_sociale" id="" value="" min="1" required="1"/></td>
			</tr>
			<tr>
				<th>Date d'immatriculation</th>
				<td><input class="date_immatri" type="date" name="date_immatri" id="" value="<?=date("Y-m-d");?>" required="1"/></td>
			</tr>
			<tr>
				<th>RCS</th>
				<td><input class="rcs" type="text" name="RCS" id="" value="" required="1"/></td>
			</tr>
			<tr>
				<th>Forme juridique</th>
				<td><input class="juridique" type="text" name="forme_juridique" id="" value="" required="1"/></td>
			</tr>
			<tr>
				<th>Siret</th>
				<td><input class="siret" type="text" name="siret" id="" value="" pattern="[0-9]{3}[ \.\-]?[0-9]{3}[ \.\-]?[0-9]{3}[ \.\-]?[0-9]{5}" title="syntaxe : 333 333 333 55555
				ou : 333.333.333.55555
				ou : 333-333-333-55555" required="1"/></td>
			</tr>
			<tr class="BtnSubmit">
				<input type="hidden" class="tokenCsrfPm" name="token" id="token" value="<?=$_SESSION['csrf'][0]?>"/>
				<input type="hidden" class="idClient" name="idClient" id="" value="<?=$GLOBALS['GET']['client']?>" />
				<input type="hidden"class="idPersonneMorale" name="idPersonneMorale" id="" value="" />
				<th colspan="2"><input class="submitPersonneMorale" type="submit" name="action" id="" value="Ajouter une personne morale" /></th>
			</tr>
		</table>
	</form>
	<span onclick="showPersonneTable();" class="BtnReturnPersonne">Retour</span>
</div>
