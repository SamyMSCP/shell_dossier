<div class='vueModuleProjet'>
	<?= ComponentModalStack::getHtmlTag("noname") ?>

	<?php
		if (ENABLE_DEVTOOLS)
			echo $this->DevTools;
	?>
</div>
<?= $this->ModuleComponentManager ?>
