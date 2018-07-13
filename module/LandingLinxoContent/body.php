<div class="container-fluid container-landing-content">
	<div class="row filter">
		<div class="hidden-xs col-sm-5 col-md-6 col-lg-7 left-data">
			<div class="row">
				<div class="col-xs-12 text-pres">
					Suivez l'évolution<br>
					de vos SCPI avec
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<img src="<?= $this->getPath() ?>res/logo-mc-scpi.svg"
						 class="logo-mc-scpi">
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-7 col-md-6 col-lg-5 container-form-spacing">
			<div class="form-part text-center">
				<div class="form-content">
					<h4 class="text-uppercase text-center">
						Je crée un compte gratuitement
					</h4>
					<div class="line"></div>
					<div class="container-fluid form-content">
						<form  action="?p=<?=$GLOBALS['GET']['p']?>" method="post" accept-charset="utf-8" id="formNewUser">
<!--						<form  action="?p=CreationCompte" method="post" accept-charset="utf-8" id="formNewUser">-->
							<div class="row" style="padding-bottom: 15px;">
								<div class="col-sm-12">
									<div class="col-sm-12">
										<input id="civilite-madame" type="radio" v-model="personne.civilite" value="Madame" class=""/>
										<label for="civilite-madame">Madame</label>
										<input id="civilite-monsieur" type="radio" v-model="personne.civilite" value="Monsieur" class=""/>
										<label for="civilite-monsieur">Monsieur</label>
									</div>


								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group has-feedback" :class="(prenomIsValid) ? 'has-success' : ((personne.prenom !== '') ? 'has-error' : '')">
									<input
										<?= ($this->state == 2 && isset($_POST['prenom'])) ? "value='" . $_POST['prenom'] . "'" : "" ?>
										   id="prenom"
										   name="prenom"
										   maxlength="42"
										   type="text"
										   placeholder="Prénom"
										   v-model="personne.prenom"
										   class="form-control input-md"
										   required/>
										<span class="glyphicon glyphicon-ok form-control-feedback" v-if="prenomIsValid && personne.prenom !== ''"></span>
										<span class="glyphicon glyphicon-remove form-control-feedback" v-else-if="personne.prenom !== ''"></span>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group has-feedback" :class="(nomIsValid) ? 'has-success' : ((personne.nom !== '') ? 'has-error' : '')">
										<input <?= ($this->state == 2 && isset($_POST['nom'])) ? "value='" . $_POST['nom'] . "'" : "" ?>
												id="nom"
												name="nom"
												type="text"
												maxlength="42"
												placeholder="Nom"
												class="form-control input-md"
												v-model="personne.nom"
												required/>
										<span class="glyphicon glyphicon-ok form-control-feedback" v-if="nomIsValid && personne.nom !== ''"></span>
										<span class="glyphicon glyphicon-remove form-control-feedback" v-else-if="personne.nom !== ''"></span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group has-feedback" :class="(mailIsValid) ? 'has-success' : ((personne.email !== '') ? 'has-error' : '')">
										<input
												id="mail"
												name="mail"
												type="text"
												maxlength="128"
												placeholder="Email"
												v-model="personne.email"
												class="form-control input-md"
												required/>
										<span class="glyphicon glyphicon-ok form-control-feedback" v-if="mailIsValid && personne.email !== ''"></span>
										<span class="glyphicon glyphicon-remove form-control-feedback" v-else-if="(personne.email !== '')"></span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<select
											id="countries_phone1"
											name="pays"
											class="form-control bfh-countries"
											data-country='FR' v-model="indic"
									>
										<?php
										include("../../page/CreationCompte/indicatif.php");
										?>
									</select>
								</div>
								<div class="col-sm-6">
									<div class="form-group has-feedback" :class="(numIsValid) ? 'has-success' : 'has-error'">
									<input
											name="num"
											id="num"
											type="text"
											onclick="$('#numex').css('display', 'block');"
											class="form-control bfh-phone"
											data-country="countries_phone1"
											required
											v-model="personne.phone"
										   placeholder="T&eacute;l&eacute;phone portable*"/>
										<span class="glyphicon glyphicon-ok form-control-feedback" v-if="numIsValid"></span>
										<span class="glyphicon glyphicon-remove form-control-feedback" v-else></span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group has-feedback" :class="(passwdIsValid) ? 'has-success' : ((personne.passwd.normal !== '') ? 'has-error' : '')">
										<input class="form-control" type="password" placeholder="Saisir un mot de passe*" v-model="personne.passwd.normal" id="passwdNormal"/>
										<span class="glyphicon glyphicon-ok form-control-feedback" v-if="passwdIsValid"></span>
										<span class="glyphicon glyphicon-remove form-control-feedback" v-else-if="personne.passwd.normal !== ''"></span>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group has-feedback" :class="(passwdIsSame) ? ((personne.passwd.confirm !== '' && personne.passwd.normal !== '') ? 'has-success' : '') : 'has-error'">
										<input class="form-control" type="password" v-model="personne.passwd.confirm" placeholder="Confirmer le mot de passe*" id="confirmPasswd"/>
										<span class="glyphicon glyphicon-ok form-control-feedback" v-if="passwdIsSame && personne.passwd.confirm !== ''"></span>
										<span class="glyphicon glyphicon-remove form-control-feedback" v-else-if="(personne.passwd.confirm !== '' || personne.passwd.normal !== '')"></span>
									</div>
								</div>
							</div>
							<div class="row conditions">
								<div class="col-xs-1"><input type="checkbox" class="form-control check" v-model="fil"/></div>
								<div class="col-xs-11" :class="fil ? 'is_valid' : ''">
									Je reconnais avoir pris connaissance de la <a href="Download.php?idDocument=<?=$this->linkFIL[0]->id?>" target="_blank">Fiche d'informations légales
										de MeilleureSCPI.com</a>
								</div>
							</div>
							<div class="row conditions">
								<div class="col-xs-1"><input type="checkbox" class="form-control check" v-model="cgu"/></div>
								<div class="col-xs-11" :class="cgu ? 'is_valid' : ''">
									Je reconnais avoir pris connaissance des <a href="Download.php?idDocument=<?=$this->linkCGU[0]->id?>" target="_blank">Conditions générales
										d’utilisation</a>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 captcha-container">
									<div class="g-recaptcha"
										 data-sitekey="6LdQvwwUAAAAANOARBZ0WDlYRZ5A0XkfgAxxG8Sn"></div>
<!-- TEST -->
<?php /*									<div class="g-recaptcha"
										 data-sitekey="6LfswUAUAAAAAIOvFqmjPalPkmGRAHHoddP8wZ5E"></div>
*/ ?>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<div class="btn btn-create text-uppercase" @click="sendForm">
										Je cr&eacute;e mon compte
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
