<form action="?p=<?=$GLOBALS['GET']['p']?>" method="post" accept-charset="utf-8">
	<?php
	?>
	<h4>Vous avez des parts dans <br /><?=$this->scpiBefore->name?><br />qui a ete absorbee par <br /><?=$this->scpiAfter->name?></h4>
	<ul>
		<li>
			Vous deteniez <?=$this->trans[0]->getNbrPart()?> parts.<br />
			Le ratio de l'absorption etant de <?=$this->Absorption->before_nbr_part?>/<?=$this->Absorption->after_nbr_part?><br />
			Qu'avez vous fait avec les <?=$this->trans[0]->getCompletionAbsorption()?>
			<input type="number" name="id_transaction" id="" value="<?=$this->trans[0]->id?>" /><br />
			<input type="hidden" name="id_transaction" id="" value="<?=$this->trans[0]->id?>" />
		</li>
	</ul>
	<input type="submit" name="submit" id="" value="validateAbsorption" />
</form>
