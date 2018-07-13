<?=$this->Nav?>
<div class="containerPerso">
	<h1>Notification Crm</h1>
	<?php
	if ($this->collaborateur->getType() == "prospecteur")
	{
		?>
		<div class="trait"></div>
		<h3>Voici la liste des clients n'ayant pas le status "ko" et pas de tache Crm non plus</h3>
		<ul>
		<?php
		foreach ($this->collaborateur->getMyClientNotHaveCrm() as $key => $elm) {
			?>
				<li>
					<a href="?p=EditionClient&client=<?=$elm->id_dh?>" target="_blank"><?=$elm->getShortName()?></a>
				</li>
			<?php
		}
		?>
		</ul>
		<?php
	}
	?>
	<div class="trait"></div>
	<div>
		<?=$this->ModuleNotificationsCrm?>
	</div>
</div>
<?=$this->MessageBox?>
