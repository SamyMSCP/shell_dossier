<div class="container">
	<div id="loading">
		<img src="img/loader.svg" style="width: 20vw; display: block; margin-left: auto; margin-right: auto;">
		<p style="text-align: center; color: white; font-weight : 20px;">Chargement ...</p>
	</div>
	<div id="form">
		<form class="form-horizontal" method="post">
			<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
			<fieldset>

			<legend>Vérification d'identité - MeilleureSCPI.com</legend>

			<div class="form-group">
			  <label class="col-md-4 control-label" for="passwordinput">Code de sécurité</label>
			 <div class="col-md-4">
			   <input id="passwordinput" name="pass" type="text" placeholder="******" class="form-control input-md" required="">

			 </div>
			</div>
			<div class="form-group">
			 <label class="col-md-4 control-label" for="submit"></label>
			<div class="col-md-4">
			  <button id="submit" name="submit" class="btn btn-primary">Continuer</button>
			</div>
			</div>

			</fieldset>
		</form>

	</div>
</div>
