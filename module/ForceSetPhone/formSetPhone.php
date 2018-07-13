<div class="modal fade" id="phoneRenseignement" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document" style="max-width: 740px;">
		<div class="modal-content" style="background-color:#EBEBEB;">
			<div class="modal-header">
				<h4 class="modal-title">Renseignement de votre numéro de téléphone</h4>
			</div>
			<div class="traitOrange"></div>
			<div class="modal-body">
				<p style="text-align: center;">Bonjour et bienvenue sur le compte client MeilleureSCPI.com <br />
				Nous vous prions de bien vouloir renseigner votre numéro de téléphone mobile.</p>

				<?php
				if (
					$_SESSION['setPhoneStep'] == 4
				)
				{
					?>
					<p style="text-align: center;color:red;">
						Une erreur est survenu lors de l'envoi du sms de validation
					</p>
					<?php
				}
				?>

				<div class="form-change-phone">
					<form id="formSetPhone" action="?p=<?=$GLOBALS['GET']['p']?>" method="post" accept-charset="utf-8">

						<div class="form-group">
							<label class="labelForm control-label" for="indicatif">Indicatif téléphonique</label>  
							<div class="inputForm">
								<div class="arrSelect" style="border : 1px solid #ccC !important;" id="selectInd">
									<select
										id="countries_phone1"
										name="pays"
										class="form-control bfh-countries"
										data-country='FR' onclick="checkIndication()"
									>
										<?php
											include("indicatif.php");
										?>
									</select>
								</div>
								<img src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" id="indicatifValide" style="display:none;"/>
							</div>
						</div>

						<div class="form-group">
							<label class="labelForm control-label" for="num">Téléphone Portable</label>
							<div class="inputForm">
								<input
									name="num"
									id="num"
									type="text"
									onclick="$('#numex').css('display', 'block');"
									class="form-control bfh-phone"
									data-country="countries_phone1"
									required
									>
								<img src="<?=$this->getPath()?>img/CP-Valide.svg"/>
							</div>
						</div>
						<label style="text-align: right; display: none;" id="numex"  for="num">Ex : +33 6 45 45 45 45</label>
						<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
						<input type="hidden" name="action" value="setPhone" />
					</form>
					<div class="align-btn-center">
						<button id="sendForm" onClick="sendForm(event)" class="btn-mscpi">Valider</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
