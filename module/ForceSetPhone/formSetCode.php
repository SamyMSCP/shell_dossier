<div class="modal fade" id="phoneRenseignement" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document" style="max-width: 740px;">
		<div class="modal-content" style="background-color:#EBEBEB;">
			<div class="modal-header">
				<h4 class="modal-title">Validation de votre numéro de téléphone</h4>
			</div>
			<div class="traitOrange"></div>
			<div class="modal-body">

				<p style="text-align: center;">
					Un code de validation à été envoyé par sms au numéro suivant : <?=$_SESSION['setPhoneTmp']['num']?> <br />
					Veuillez le renseigner dans le champ ci-dessous pour le valider.
				</p>

				<?php
				if (
					$_SESSION['setPhoneStep'] == 5
				)
				{
					?>
					<p style="text-align: center;color:red;">
						Le code renseigné n'est pas valide
					</p>
					<?php
				}
				?>

				<div class="form-change-phone">
					<form id="formSetPhone" action="?p=<?=$GLOBALS['GET']['p']?>" method="post" accept-charset="utf-8">

						<div class="form-group">
							<label class="labelForm control-label" for="num">Code : </label>
							<div class="inputForm" style="width: 77px !important;">
								<input
									name="code"
									id="code"
									class="form-control"
									type="text"
									required
									maxlength="6"
									>
								<img src="<?=$this->getPath()?>img/CP-Valide.svg"/>
							</div>
						</div>
						<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
						<input type="hidden" name="action" value="setCode" />
					</form>
					<div style="width:100%; text-align:center;">
						<span onClick="resetPhone()" id="linkToResetPhone">Vous n'avez pas recu le code ?</span>
						<?php
						/*
							MsgBox :
								Merci de patienter quelques instants pour la reception du sms.
								Nous vous avons adressé le SMS à ce numéro : [num] si le numéro n'est pas le bon vous pouvez le changer en cliquant ici:]
						*/
						?>
					</div>
					<div class="align-btn-center">
						<button id="sendForm" onClick="sendForm(event)" class="btn-mscpi">Valider</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
