<div class="blockSituation blockSelected">
	<div class="titleBlockSituation">
		VOS INFORMATIONS PERSONNELLES
	</div>
	<div class="contentBlockSituation">
		<div class="contenuOut">
			<form action="?p=<?=$GLOBALS['GET']['p']?>" method="post" accept-charset="utf-8" id="formNewUser">
				<div class="contenu">
					<div class="form-group">
						<label class="labelForm control-label" for="civilite">Civilité</label>
						<div class="inputForm">
							<div class="arrSelect" style="border : 1px solid #ccC !important;" id="selectCiv">
								<select id="civilite" name="civilite" class="form-control" onclick="checkCiviliter()">

									<option
										<?= ($this->state == 2 && isset($_POST['civilite']) && $_POST['civilite'] == "Monsieur") ? "selected" : "" ?>
										value="Monsieur"
									>
										Monsieur
									</option>

									<option
										<?= ($this->state == 2 && isset($_POST['civilite']) && $_POST['civilite'] == "Madame") ? "selected" : "" ?>
										value="Madame"
										>
										Madame
									</option>
								</select>
							</div>
							<img  id="civiliteValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:none;"/>
						</div>
					</div>

					<div class="form-group">
						<label class="labelForm control-label" for="nom">Nom</label>
						<div class="inputForm">
							<input
								<?= ($this->state == 2 && isset($_POST['nom'])) ? "value='" . $_POST['nom'] . "'" : "" ?>
								id="nom"
								name="nom"
								type="text"
								maxlength="42"
								placeholder="Nom"
								class="form-control input-md"
								required
							>
							<img id="nomValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
						</div>
					</div>

					<div class="form-group">
						<label class="labelForm control-label" for="prenom">Prénom</label>
						<div class="inputForm">
							<input
								<?= ($this->state == 2 && isset($_POST['prenom'])) ? "value='" . $_POST['prenom'] . "'" : "" ?>
								id="prenom"
								name="prenom"
								maxlength="42"
								type="text"
								placeholder="Prénom"
								class="form-control input-md"
								required
							>
							<img id="prenomValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
						</div>
					</div>

					<div class="form-group"> <label class="labelForm control-label" for="indicatif">Indicatif téléphonique</label>  
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
					<label style="text-align: right; display: none; margin-top:-20px;padding-right:20px; " id="numex"  for="num">Ex : +33 6 45 45 45 45</label>

					<div class="form-group">
						<label class="labelForm control-label" for="mail">Email</label>  
						<div class="inputForm">
							<input
								<?= ($this->state == 2 && isset($_POST['mail'])) ? "value='" . $_POST['mail'] . "'" : "" ?>
								id="mail"
								name="mail"
								type="text"
								maxlength="128"
								placeholder="Email"
								class="form-control input-md"
								required
							>
							<img id="mailValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
						</div>
					</div>









					<div class="form-group">
						<label class="labelForm control-label" for="pass">Saisissez un mot de passe</label>  
						<div class="inputForm">
							<input class="form-control input-md" required maxlength="42" type="password" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Mot de passe non conforme' : ''); if(this.checkValidity()) form.pass2.pattern = this.value;"  pattern="^(?=.*\d)(?=.*[a-z])(?=.{8,42})(?=.*[A-Z])(?!.*\s).*$" name="pass" id="pass">
							<img id="mailValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
						</div>
					</div>
					<div class="msgErr">
						<p style="font-style:italic; color:#ccc;">
							Le format du mot de passe doit respecter les critères suivants :
						</p>
						<p class="pass_erreur1">
							8 caractères sont nécessaires.
						</p>
						<p class="pass_erreur2">
							Une majuscule est manquante.
						</p>
						<p class="pass_erreur3">
							Une minuscule est manquante.
						</p>
						<p class="pass_erreur4">
							Un chiffre est manquant.
						</p>
					</div>

					<div class="form-group">
						<label class="labelForm control-label" for="pass2">Confirmez le mot de passe</label>  
						<div class="inputForm">
							<input class="form-control input-md" required="1" maxlength="42" type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.{8,42})(?=.*[A-Z])(?!.*\s).*$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Les mots de passe ne correspondent' : '');"  name="pass2" id="pass2">
							<img id="mailValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
						</div>
					</div>
					<div class="msgErr2">
						<p class="erreur5">Les mots de passes doivent être identiques</p>
					</div>

					<div class="form-group">
						<label class="labelForm control-label">Etes-vous un robot ?</label>  
						<div class="inputForm">
							<div class="g-recaptcha" data-sitekey="6LdQvwwUAAAAANOARBZ0WDlYRZ5A0XkfgAxxG8Sn"></div>
						</div>
					</div>
			


					<div class="form-group" id="firstValidation">
						<div class="inputForm">
							<label for="__check" class="radio-inline" style="text-align:left; flex:none;" >
								<input type="checkbox" name="fil" required="" id="__check" value="42"<?php if (!empty($_COOKIE['fil'])) echo "checked"?>>
								<span></span>
								Je reconnais avoir pris connaissance de la 
								<a href="Download.php?idDocument=<?=$this->linkFIL[0]->id?>" target="_blank" style="color: #01528A;font-weight:900;text-decoration:underline;">Fiche d'informations légales de MeilleureSCPI.com</a>
							</label>
						</div>
					</div>

					<div class="form-group">
						<div class="inputForm">
							<label for="__check2" class="radio-inline" style="text-align:left; flex:none;" >
								<input
									type="checkbox"
									style="height:14px;width:14px;"
									name="CGU"
									id="__check2"
									value="42"
									required=""
								>
								<span></span>
								Je reconnais avoir pris connaissance des
								<a href="Download.php?idDocument=<?=$this->linkCGU[0]->id?>" target="_blank" style="color: #01528A;font-weight:900;text-decoration:underline;">Conditions générales d'utilisation</a>
							</label>
						</div>
					</div>
			<?php
			/*
					<div class="form-group" id="firstValidation">
						<div class="inputForm">
							<label
								onclick="showModal1OneTime()"
								class="radio-inline"
								for="__check"
								style="text-align:left; flex:none;"
							>
								<input type="checkbox" name="fil" required="" id="__check" value="42"<?php if (!empty($_COOKIE['fil'])) echo "checked"?>>
								<span></span>
								Je reconnais avoir pris connaissance de la 
								<a onclick="mydisplaymodal()" id="pushmodal" data-toggle="modal" data-target="#myModal" style="color: #01528A;font-weight:900;text-decoration:underline;">Fiche d'informations légales de MeilleureSCPI.com</a>
							</label>
						</div>
					</div>

					<div class="form-group">
						<div class="inputForm">
							<label 
								onclick="showModal2OneTime()"
								class="radio-inline"
								for="__check2"
								style="text-align:left; flex:none;"
							>
								<input
									type="checkbox"
									style="height:14px;width:14px;"
									name="CGU"
									id="__check2"
									value="42"
									<?php if (!empty($_COOKIE['fil'])) echo "checked"?>
									required=""
								>
								<span></span>
								Je reconnais avoir pris connaissance des
								<a onclick="mydisplaymodal2()" id="pushmodal2" data-toggle="modal" data-target="#myModal2" style="color: #01528A;font-weight:900;text-decoration:underline;">Conditions générales d'utilisation</a>
							</label>
						</div>
					</div>
					*/
					?>

					<div class="outButton">
						<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
						<button id="sendForm" class="btn-mscpi" onClick="check_read(event); $('#loading').css('display', 'flex'); " >
							CRÉER MON COMPTE
						</button>
						<button
							onClick="event.preventDefault()"
							id="sendFormInactive"
							class="btn-mscpi"
							style="background-color: white;
								color: #ccc;
								border: 1px solid #ccc;"
							>
							CRÉER MON COMPTE
						</button>
					</div>


				</div>
			</form>
		</div>
	</div>
</div>

<?php
//include("modale.php");
