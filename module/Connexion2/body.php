<div class="col-xs-12 col-lg-5 col-lg-push-1" id="connex">
	<div class="connex_header">
		<div class="connex_header_">
			<img id="logo" class="center-block" src="<?= $this->getPath() ?>img/MS-Logo-RVB.svg" />
		</div>
	</div>
	<div class="connex_body">
		<div id="connectme">
			<div class="connex_title text-center">CONNEXION</div>
			<div class="connex_error center-block"><?php if (!empty($this->err["connectme"])) echo $this->err["connectme"]; ?></div>
			<div class="connex_msg center-block"><?php if (!empty($this->msg["connectme"])) echo $this->msg["connectme"]; ?></div>
			<form method="post">
				<input type="hidden" name="action" value="connectme" />
				<input type="hidden" name="token" id="token" value="<?= $_SESSION['csrf'][0]; ?>"/>
				<div class="form-line text-center">
					<input type="email" class="form-control center-block" name="login" id="login" placeholder="Adresse email" required />
				</div>
				<div class="form-line text-center pos-rel">
					<input type="password" class="form-control center-block" name="password" placeholder="Mot de passe" id="passwd" required />
					<a id="forgottenpwd_a" class="pull-right forgottenpwd__a" href="#">Mot de passe oublié ?</a>
				</div>
<?php if ($this->captcha) : ?>
				<div class="form-group text-center">
					<label class="labelForm control-label">Êtes-vous un robot ?</label>  
					<div class="containerCaptcha col-xs-10 col-xs-push-2">
						<div class="g-recaptcha" data-sitekey="<?= __SITE_KEY_RECAPTCHA__ ?>"></div>
					</div>
				</div>
<?php endif; ?>
				<div class="form-line text-center">
					<button type="submit" class="bttn-mscpi-plainorange">SE CONNECTER</button>
				</div>
			</form>
		</div>
		<div id="forgottenpwd">
			<div class="connex_title text-center">MOT DE PASSE OUBLIÉ</div>
			<div class="connex_error center-block"><?php if (!empty($this->err["forgottenpwd"])) echo $this->err["forgottenpwd"]; ?></div>
			<form method="post">
				<input type="hidden" name="action" value="forgottenpwd" />
				<input type="hidden" name="token" id="token" value="<?= $_SESSION['csrf'][0]; ?>"/>
			<?php if (empty($this->err["forgottenpwd"])) : ?>
				<div class="form-line connex_desc center-block">
					Entrez l'adresse email associée à votre compte et nous vous enverrons un lien pour réinitialiser votre mot de passe.	
				</div>
			<?php endif; ?>
				<div class="form-line text-center">
					<input type="email" class="form-control center-block" name="login" id="login_lostpwd" placeholder="Adresse email" required />
					<div class="err">Veuillez fournir une adresse électronique valide</div>
				</div>
				<div class="form-line text-center">
					<button type="submit" class="bttn-mscpi-plainorange">RÉCUPÉRER MON MOT DE PASSE</button>
				</div>
				<div class="form-line text-center">
					<a id="connectme_a" href="#">Se connecter</a>
				</div>
			</form>
		</div>
		<div id="verifycode">
			<div class="connex_title text-center">VÉRIFICATION PAR SMS</div>
<?php if (!empty($this->err["verifycode"])) : ?>
			<div class="connex_error center-block">
				<?= $this->err["verifycode"]; ?>
			</div>
<?php elseif (!empty($this->msg["verifycode"])) : ?>	
			<div class="connex_msg center-block">
				<?= $this->msg["verifycode"]; ?>
			</div>
<?php endif; ?>
			<form method="post">
				<input type="hidden" name="action" value="verifycode" />
				<input type="hidden" name="_token" value="<?= $this->_token ?>" />
				<input type="hidden" name="token" id="token" value="<?= $_SESSION['csrf'][0]; ?>"/>
			<?php if (empty($this->err["verifycode"])) : ?>
				<div class="connex_desc center-block">Un code à 6 chiffres vient d'être envoyé au numéro se terminant par <i><?= $this->_num ?></i>, merci de le reporter ci-dessous.</div>
			<?php endif; ?>
				<div class="form-line text-center">
					<input type="text" class="form-control center-block" id="code" name="code" pattern="\d{6}" placeholder="Code reçu par sms" maxlength="6" required />
				</div>
				<div class="form-line text-center">
					<button type="submit" class="bttn-mscpi-plainorange">SE CONNECTER</button>
				</div>
			</form>
		</div>
		<div id="changepwd">
			<div class="connex_title text-center">CHANGEMENT MOT DE PASSE</div>
			<div class="connex_error center-block"><?php if (!empty($this->err["changepwd"])) echo $this->err["changepwd"]; ?></div>
			<form method="post" id="form_changepwd">
				<input type="hidden" name="action" value="changepwd" />
				<input type="hidden" name="reset" value="<?= $this->reset ?>" />
				<input type="hidden" name="token" id="token" value="<?= $_SESSION['csrf'][0]; ?>"/>
				<?php if (empty($this->err["changepwd"])) : ?>
					<div class="connex_desc center-block">
						De 8 à 42 caractères alphanumériques, dont au moins une majuscule, une minuscule et un chiffre.
					</div>
				<?php endif; ?>
				<div class="form-line text-center">
					<input type="password" class="form-control center-block" name="newpwd" id="newpwd" placeholder="Nouveau mot de passe" maxlength="42" pattern="^(?=.*\d)(?=.*[a-z])(?=.{8,42})(?=.*[A-Z])(?!.*\s).*$" title="Le mot de passe doit comporter 8 à 42 caractères, une majuscule, une minuscule et un chiffre." required />
				</div>
				<div class="form-line text-center">
					<input type="password" class="form-control center-block" name="confirmnewpwd" id="confirmnewpwd" placeholder="Ressaisissez le mot de passe" maxlength="42" pattern="^(?=.*\d)(?=.*[a-z])(?=.{8,42})(?=.*[A-Z])(?!.*\s).*$" title="Le mot de passe doit comporter 8 à 42 caractères, une majuscule, une minuscule et un chiffre." required />
				</div>
				<div class="form-line text-center">
					<button type="submit" class="bttn-mscpi-plainorange center-block">ENREGISTRER</button>
				</div>
				<div class="form-line text-center">
					<a id="cancel_changepwd_a" href="#">Annuler</a>
				</div>
			</form>
		</div>
	</div>
	<div class="connex_footer">
		<div class="connex_title text-center">PAS ENCORE INSCRIT(E) ?</div>
		<div class="text-center">
			<button class="bttn-mscpi"><a href="index.php?p=CreationCompte">CRÉER UN COMPTE</a></button>
		</div>
	</div>
</div>
