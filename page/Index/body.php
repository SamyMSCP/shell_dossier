<?php
if (!empty($GLOBALS['GET']['token']) && $GLOBALS['GET']['token'] == "MeilleureSCPI.com")
	$msg = "A une prochaine sur MeilleureSCPI.com ^^";
if (onIE())
{
	?>
	<div class="modal fade modal_ie" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" data-backdrop="static" data-keyboard="false" >
		<div class="modal-dialog">
			<div class="modal-content" style="background-color:#EBEBEB;">
				<div class="modal-header">
					<h4 style="text-align:center;color: #1781e0;">MeilleureSCPI.com<h4>
				</div>
				<div class="traitOrange"></div>
				<div class="modal-body">
					<p>Bonjour et bienvenue sur le compte client meilleureSCPI.com</p>
					<p>Vous utilisez actuellement Microsoft Internet Explorer. Celui ci n'etant plus maintenu. La navigation à été désactivée.</p>
					<p>Vous pouvez utiliser un autre navigateur :
					<ul>
						<li>Google Chrome</li>
						<li>Microsoft Edge</li>
						<li>Mozilla Firefox</li>
						<li>Opera</li>
						<li>Apple Safari</li>
					</ul>
				</p>
			</div>
		</div>
	</div>
</div>
<?php
}
if (!empty($msg)) {
?>
	<div class="modal fade modal_push_info" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog">
			<div class="modal-content" style="margin-top: 20vh;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 style="text-align: center;">MeilleureSCPI.com - Information<h4>
				</div>
				<div class="traitOrange"></div>
				<div class="modal-body">
					<p style="text-align: center;color:#505050;"><?php echo $msg;?></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn-mscpi" data-dismiss="modal">Fermer</button>
				</div>
			</div>
		</div>
	</div>
<?php
}
?>
<?=$this->Connexion?>
<?=$this->mentions?>
<?=$this->contact?>
<?=$this->cq?>
<?php Notif::getAll(); ?>
