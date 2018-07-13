<h3>Outils prospecteurs</h3>
<div class="Btn">
	<form id="formToggleKo" action="?p=EditionClient&client=<?=$GLOBALS['GET']['client']?>" method="post" accept-charset="utf-8">
		<input type="hidden" name="token" id="token" value="<?=$_SESSION['csrf'][0]?>"/>
		<input type="hidden" name="action" value="toogleKo"/>
	</form>
	<button
		onclick="toggleKo()"
		<?php
		if (!$this->dh->isKo())
		{
			?>
			class="notComplete"
			<?php
		}
		else
		{
			?>
			<?php
		}
		?>
	>
		KO
	</button>
</div>
