<div class="modal fade modalPreventionProfil" tabindex="-1" role="dialog" aria-labelledby="modalPreventionProfil" id="modalPreventionProfil">
	<div class="modal-dialog modal-sm preventionCapital" role="document">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img style="height:30px;" src="<?=$this->getPath()?>img/Close-Jaune.svg" alt="" /></button>
			<h3>Profil investisseur de <?=$this->Pp->getShortName()?></h3>
			<p>Dans le cadre de la réglementation, il est obligatoire de connaitre le profil investisseur de chaque bénéficiaire. <br />
			<br />
			Vous allez compléter le profil investisseur de <?=$this->Pp->getShortName()?>
			</p>
			<div class="lstButton">
				<div data-dismiss="modal" class="btnCapital" style="text-align: center;">Fermer</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
	$('#modalPreventionProfil').modal('show');
</script>
<?php
if (isset($GLOBALS['GET']['projet']))
{
	?>
	<form id="setProjectForm" method="post">
	<?php
}
else if (isset($GLOBALS['GET']['Pp']))
{
	?>
	<form id="setProjectForm" method="post" action="?p=<?=$GLOBALS['GET']['p']?>&Pp=<?=$GLOBALS['GET']['Pp']?>">
	<?php
}
else
{
	Notif::set('ResetProfil', "La requete n'est pas valide");
	header('Location: ?p=ListeProjets');
	exit();
}
?>
	<?php
	include("block1.php");
	include("block2.php");
	include("block3.php");
	include("block4.php");

//// Les nouveaux blocks ////////////
	include("block6.php");
	include("block7.php");
	include("block5.php");
//	include("block8.php");

/////////////////////////////////////
	include("block9.php");
	?>
	<input type="hidden" name="id_Pp" id="" value="<?=$this->Pp->id_phs?>" />
	<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
	<input type="hidden" name="action" id="" value="setNewProfilInvestisseur" />
</form>
<button  id="sendBtn" class="tosend">VALIDER CETTE ETAPE</button>

