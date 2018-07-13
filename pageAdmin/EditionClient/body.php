<?=$this->Loading?>
<?=$this->Nav?>
<?=$this->ToolTip?>
<?=$this->MessageBox?>
<div class="containerPerso">
	<?php
	if (isset($GLOBALS['GET']['client']))
	{
		?>
		<div class="blockTop">
			<div style="position:relative;">
			</div>
			<?= $this->InformationsClient?>
			<?php
			if ($this->collaborateur->getType() != "prospecteur")
				echo $this->tableauDeBordClient;
			?>
			<?=$this->Validate?>
		</div>
		<div class="blockmiddle">
			<?=$this->OngletsClients?>
		</div>
		<?php
	}
	else
	{
		echo "Il y a un probleme avec votre Url";
	}
	?>
</div>

<?php
if ($this->collaborateur->getType() != "prospecteur")
{
	?>
	<div id="transac">
		<transaction></transaction>
	</div>
	<div id="appEditionClient">
		<document-modal></document-modal>
		<see-profil></see-profil>
	</div>
	<?php
}
?>
<?=$this->ModuleProjetStore?>
<?=$this->ListeDeroulante?>
