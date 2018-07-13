<form action="?p=<?=$GLOBALS['GET']['p']?>&client=<?=$GLOBALS['GET']['client']?>&onglet=PERSONNES" method="post" accept-charset="utf-8">
	<table class="situationFiscalePp" border="1">
		<tr>
			<th colspan="2">
				<div class="enteteTableDetail">Situation Juridique</div>
			</th>
		</tr>
		<tr class="Locker">
			<td colspan="2">
				<img class="closed" ondblclick="enabledPersonnePhysiqueModification();" src="<?=$this->getPath()?>img/Lock_closed.png" alt="" />
				<img class="open" ondblclick="enabledPersonnePhysiqueModification();" src="<?=$this->getPath()?>img/Lock_open.png" alt="" />
			</td>
		</tr>
		<tr>
			<th>Date de Situation</th>
			<td><input class="dateFinValiditePp" type="date" name="dateFinValiditePp" id="" value="" /></td>
		</tr>
		<tr>
			<th>Regime matrimonial</th>
			<td><input class="trancheMarginaleImpositionPp" type="text" name="trancheMarginaleImpositionPp" id="" value="" /></td>
		</tr>
		<tr>
			<th>Nombre d'enfant a charge</th>
			<td><input class="dateFinValiditePp" type="date" name="dateFinValiditePp" id="" value="" /></td>
		</tr>
		<tr>
			<th>Nombre d'autres personnes a charge</th>
			<td><input class="dateFinValiditePp" type="date" name="dateFinValiditePp" id="" value="" /></td>
		</tr>
	</table>
</form>
