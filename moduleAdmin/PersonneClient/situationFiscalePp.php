<form action="?p=<?=$GLOBALS['GET']['p']?>&client=<?=$GLOBALS['GET']['client']?>&onglet=PERSONNES" method="post" accept-charset="utf-8">
	<table class="situationFiscalePp" border="1">
		<tr>
			<th colspan="2">
				<div class="enteteTableDetail">Situation Fiscale</div>
			</th>
		</tr>
		<tr class="Locker">
			<td colspan="2">
				<img class="closed" ondblclick="enabledPersonnePhysiqueModification();" src="<?=$this->getPath()?>img/Lock_closed.png" alt="" />
				<img class="open" ondblclick="enabledPersonnePhysiqueModification();" src="<?=$this->getPath()?>img/Lock_open.png" alt="" />
			</td>
		</tr>
		<tr>
			<th>Date de situation</th>
			<td><input class="dateFinValiditePp" type="date" name="dateFinValiditePp" id="" value="" /></td>
		</tr>
		<tr>
			<th>Date de fin de validite</th>
			<td><input class="dateFinValiditePp" type="date" name="dateFinValiditePp" id="" value="" /></td>
		</tr>
		<tr>
			<th>Resident fiscale en france</th>
			<td><input class="dateFinValiditePp" type="date" name="dateFinValiditePp" id="" value="" /></td>
		</tr>
		<tr>
			<th>Tranche marginale d'imposition</th>
			<td><input class="trancheMarginaleImpositionPp" type="text" name="trancheMarginaleImpositionPp" id="" value="" /></td>
		</tr>
	</table>
</form>
